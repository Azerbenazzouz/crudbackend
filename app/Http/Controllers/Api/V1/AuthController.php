<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ApiResource;
use App\Repositories\RefreshTokenRepositroy;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Service\Impl\RefreshTokenService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller {

    private $refreshTokenService;
    private $refreshTokenRepository;
    private $userRepository;
    private $roleRepository;

    public function __construct(RefreshTokenService $refreshTokenService, RefreshTokenRepositroy $refreshTokenRepository, UserRepository $userRepository, RoleRepository $roleRepository) {
        $this->refreshTokenService = $refreshTokenService;
        $this->refreshTokenRepository = $refreshTokenRepository;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }


    public function authenticate(AuthRequest $request) {
        $credentials = [
            'email' => $request->string('email'),
            'password' => $request->string('password')
        ];

        if (! $token = auth('api')->attempt($credentials)) {
            return ApiResource::message('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        // create Refresh Token
        $refreshTokenPayload = [
            'refresh_token' => Str::uuid(),
            'user_id' => auth('api')->user()->id,
            'expires_at' => now()->addMonth()// expired in 1 day
        ];

        if($this->refreshTokenService->create($refreshTokenPayload)) {
            return ApiResource::ok($this->respondWithToken($token, $refreshTokenPayload), 'SUCCESS', Response::HTTP_OK);
        }

        return ApiResource::message('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    protected function respondWithToken($token, $refreshTokenPayload) {
        return [
            'accessToken' => $token,
            'refreshToken' => $refreshTokenPayload['refresh_token'],
            'tokenType' => 'bearer',
            'expiresIn' => auth('api')->factory()->getTTL()
        ];
    }

    public function me() {
        $auth = auth('api')->user();
        $auth->roles->makeHidden(['created_at', 'updated_at', 'pivot']);
        return ApiResource::ok(['auth' => $auth], 'SUCCESS', Response::HTTP_OK);
    }

    public function refreshToken(RefreshTokenRequest $request) {
        $refreshToken = $this->refreshTokenRepository->findRefreshTokenValid($request->input('refreshToken'));
        $user = $this->userRepository->findById($refreshToken->user_id);
        if(!$user){
            return ApiResource::message('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        try {
            if(auth('api')->getToken()){
                auth('api')->invalidate(true);
            }
        } catch (TokenExpiredException $e) {
            return ApiResource::message('Token Expired', Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $e) {
            return ApiResource::message('Token Invalid', Response::HTTP_UNAUTHORIZED);
        } catch (JWTException $e) {
            return ApiResource::message('Fail to invalidate token', Response::HTTP_UNAUTHORIZED);
        }


        $token = auth('api')->login($user); // login user with new token
        if($token) {
            return ApiResource::ok($this->respondWithToken($token, $refreshToken), 'SUCCESS', Response::HTTP_OK);
        }

        return ApiResource::message('Server Error...', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function logout() {
        try {
            $user = auth('api')->user();
            $this->refreshTokenRepository->deleteByUserId($user->id);

            auth('api')->invalidate(true);
            auth('api')->logout();

            return ApiResource::message('Logout Success', Response::HTTP_OK);
        } catch (\Exception $e) {
            return ApiResource::message('Server Error...', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register(RegisterRequest $request) {
        try {
            $payload = $request->only(['name', 'email', 'birthday']);
            $payload['password'] = bcrypt($request->password);

            DB::beginTransaction();

            // Recherche spécifiquement le rôle 'User'
            $role = $this->roleRepository->findByField("name", "User");

            if (!$role) {
                // Si le rôle User n'existe pas, on le crée
                $role = $this->roleRepository->create([
                    'name' => 'User',
                    'slug' => 'user'
                ]);
            }

            $user = $this->userRepository->create($payload);
            $this->userRepository->syncRoles($user, [$role->id]);
            $user->load('roles');
            $user->roles->makeHidden(['created_at', 'updated_at', 'pivot']);

            DB::commit();

            return ApiResource::ok($user, 'User registered successfully', Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResource::message('Registration failed: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
