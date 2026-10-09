<?php

namespace App\Services;

use App\Http\Resources\AssigneeResource;
use App\Http\Resources\UserResource;
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
                data : AssigneeResource::collection($user->getTenant()->members)
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function getTenantMembers(Request $request)
    {
        try {
            $perPage = $request->query('perPage', 10);
            $page = $request->query('page', 1);

            $user = $request->user();
            $tenant = $user?->member?->tenant;

            $members = $tenant?->members()
                ->when($request->query('sort'), function ($query) use ($request) {
                    $query->where('role', $request->query('sort'));
                })
                ->whereHas('user', function ($query) use ($request) {
                    $query->when($request->query('search'), function ($query) use ($request) {
                        $search = $request->query('search');
                        $query->where('name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
                })
                ->where('tenant_id', $tenant->id)->paginate(perPage: $perPage, page: $page);

            return UserResource::collection($members);

        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
