<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $_userService
    ) {}

    public function index(Request $request)
    {
        return $this->_userService->getTenantMembers($request);
    }

    public function getAssignees(Request $request)
    {
        return $this->_userService->usersTenant($request);
    }

    public function toggleStatus(User $userId,string $status) 
    {
        return $this->_userService->toggleStatus(
            user: $userId,
            status: $status
        );
    }
}
