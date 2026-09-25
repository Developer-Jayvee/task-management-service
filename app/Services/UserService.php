<?php

namespace App\Services;

use App\Http\Resources\AssigneeResource;
use App\Models\Tenant;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UserService
{
    use ResponseTrait;

    public function usersTenant(Request $request)
    {
        $user = User::query()->findOrFail($request->user()->id);
        try {
            return $this->successResponse(
                data :  AssigneeResource::collection($user->getTenant()->members)
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
