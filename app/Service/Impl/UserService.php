<?php
namespace App\Service\Impl;

use App\Repositories\UserRepository;
use App\Service\Interfaces\UserServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserService extends BaseService implements UserServiceInterface {

    protected $userRepo;
    protected $payload;

    public function __construct(
        UserRepository $userRepo,
    ) {
        parent::__construct($userRepo);
    }

    protected function getSearchField(): array {
        return ['name', 'email'];
    }

    protected function getPerpage() : int {
        return 20;
    }

    protected function requestPayload(): array {
        return ['name', 'email', 'password' , 'birthday', 'roles'];
    }

    protected function getSimpleFilter() : array {
        return ['name', 'email'];
    }

    protected function getComplexFilter(): array{
        return ['id', 'age'];
    }

    protected function getDateFilter(): array {
        return ['created_at', 'birthday'];
    }

    protected function processPayload(?Request $request = null) {
        if (!$request) {
            return $this;
        }

        return $this
            ->calculateAgeFromBirthday();
    }

    protected function calculateAgeFromBirthday() {
        if(isset($this->payload['birthday'])) {
            $this->payload['age'] = Carbon::parse($this->payload['birthday'])->age;
        }
        return $this;
    }

    protected function getManyToManyRelationship() : array {
        return ['roles'];
    }

}
