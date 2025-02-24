<?php
namespace App\Service\Impl;

use App\Repositories\PermissionRepository;
use App\Service\Interfaces\PermissionServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PermissionService extends BaseService implements PermissionServiceInterface{
    protected $permissionRepo;
    protected $payload;

    public function __construct(
        PermissionRepository $permissionRepo
    ) {
        parent::__construct($permissionRepo);
        $this->permissionRepo = $permissionRepo;
    }

    protected function requestPayload(): array {
        return ['name'];
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
        return $this->setUserId();
    }

    public function createModulePermission(Request $request): array {
        DB::beginTransaction();
        try {
            $model = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->input('model')));
            if(empty($model)) {
                throw new \InvalidArgumentException('Model name is invalid');
            }
            $method = [
                'all',
                'index',
                'store',
                'update',
                'destroy',
                'deleteMultiple',
                'show',
                'viewAll',
                'actionAll'
            ];
            $permissions = [];

            foreach ($method as $action) {
                $payload = [
                    'name' =>"{$model}:{$action}",
                ];
                if($this->permissionRepo->checkExist('name', $payload['name'])) continue;
                $data = $this->permissionRepo->create($payload);
                $permissions[] = $data;
            }

            DB::commit();
            return [
                'data' => [
                    'permissions' => $permissions
                ],
                'flag' => true
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage(),
                'flag' => false
            ];
        }

        return $method;
    }
}
