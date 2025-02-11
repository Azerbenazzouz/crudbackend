<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepositroy {
    public function __construct(User $model) {
        parent::__construct($model);
    }

    public function syncRoles($user, $roles) {
        User::find($user->id)->roles()->sync($roles);
    }
}
