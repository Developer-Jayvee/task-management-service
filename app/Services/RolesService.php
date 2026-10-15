<?php

namespace App\Services;

use App\Http\Resources\RolesResource;
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
}
