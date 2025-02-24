<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Repositories\UserRepository;

class UpdateRequest extends BaseRequest {

    private $userRepository;

    public function __construct() {
        $this->userRepository = app(UserRepository::class);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255|min:3',
            'birthday' => 'nullable|date|before:today',
            'password' => 'string|min:6|max:24',
            'email' => 'nullable|email|unique:users,email,'.$this->route('user').',id',
            'roles' => 'array',
            'roles.*' => 'required|exists:roles,id', // Validate each item in the array (roles ID exists in the roles table)
            'avatar' => 'nullable|string',
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $user = $this->userRepository->findById($this->route('user'));
            if (!$user) {
                $validator->errors()->add('user', 'User not found');
            }
        });
    }
}
