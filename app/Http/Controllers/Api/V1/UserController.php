<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\User\DeleteMultipleRequest;
use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Service\Interfaces\UserServiceInterface as UserService;


class UserController extends BaseController {

    protected $userService;
    protected $resource = UserResource::class;
    public function __construct(
        UserService $userService
    ) {
        parent::__construct($userService);
    }

    protected function getStoreRequest(): string {
        return StoreRequest::class;
    }

    protected function getUpdateRequest(): string {
        return UpdateRequest::class;
    }

    protected function getDeleteRequest(): string {
        return DeleteRequest::class;
    }

    protected function getDeleteMultipleRequest(): string {
        return DeleteMultipleRequest::class;
    }
}
