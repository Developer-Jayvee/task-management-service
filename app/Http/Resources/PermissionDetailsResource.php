<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $roleId = Role::query()->
        $roleHasPermission = DB::table('role_has_permissions','rhp')->where('permission_id',$this->permission_id)->exists();
        // $role = Role::query()->findOrFail($rolePermission->role_id);
        
        return [
            'permission_id' => $this->permission_id,
            'description' => $this->description,
            'category' => $this->category,
            'is_active' => true
        ];
    }
}
