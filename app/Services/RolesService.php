<?php

namespace App\Services;

use App\Http\Resources\RolesResource;
use App\Models\Member;
use App\Traits\ResponseTrait;
use Spatie\Permission\Models\Role;

class RolesService
{
   use ResponseTrait;


   public function roleList()
   {
        try {
            return $this->successResponse(
                data: RolesResource::collection(Role::query()->get())
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
   }

    public function deleteRole(Role $role)
    {
        try {
            $hasUser = Member::query()->where('role',$role->name)->exists();
            if($hasUser) {
                throw new \Exception("Role is currently used.", 409);
            }
            $role->delete();

            return $this->successResponse(
                message: "Successfully deleted"
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
