<?php
namespace App\Service\Impl;

use App\Repositories\RoleRepository;
use App\Service\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleService extends BaseService implements RoleServiceInterface{
    
    protected $roleRepo;
    protected $payload;

    public function __construct(
        RoleRepository $roleRepo
    ) {
        parent::__construct($roleRepo);        
    }

    protected function requestPayload(): array {
        return ['name', 'permissions'];
    }

    protected function getSearchField(): array {
        return ['name'];
    }

    protected function getPerpage() : int {
        return 20;
    }

    protected function getSimpleFilter() : array {
        return [];
    }

    protected function getComplexFilter(): array{
        return ['id'];
    }

    protected function getDateFilter(): array {
        return ['created_at'];
    }


    protected function processPayload(?Request $request = null) {
        return $this
            ->generateSlug($this->payload['name'] ?? '')
            ->generateSomething();
    }

    protected function generateSlug($name) {
        if (empty($name)) {
            return $this;
        }
        $this->payload['slug'] = Str::slug($name);
        return $this;
    }

    protected function generateSomething() {
        // do something
        return $this;
    }

    protected function getManyToManyRelationship() : array {
        return ['permissions'];
    }

}
