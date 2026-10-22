<?php

namespace App\Services;

use App\Http\Resources\PermissionDetailsResource;
use App\Models\PermissionDetails;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionDetailsService
{
    use ResponseTrait;

    public function viewPermissions(string $role)
    {
        try {
            $permission = PermissionDetails::query()->get()
                ->map(function ($data) use ($role) {
                    $role = Role::findByName($role,'api');
                    $roleHasPermission = DB::table('role_has_permissions', 'rhp')
                        ->where([
                            'permission_id' => $data->permission_id,
                            'role_id' => $role->id,
                        ])->exists();

                    return [
                        'permission_id' => $data->permission_id,
                        'label' => $data->label,
                        'description' => $data->description,
                        'is_active' => (bool) $roleHasPermission,
                    ];
                });

            return $this->successResponse(
                data: $permission
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function updateRolePermission(array $permissions, string $role)
    {
        try {
            $role = Role::findByName($role,'api');
            $permissionArr = [];
            foreach ($permissions as $key => $id) {
                $perm = Permission::findById($id,'api');
                if($perm) {
                    $permissionArr[] = $perm;
                }
            }
            $role->syncPermissions($permissionArr);
            return $this->successResponse(
                message: 'Successfully update permissions'
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

}
