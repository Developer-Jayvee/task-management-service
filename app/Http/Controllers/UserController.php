<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $_userService
    ) {}

    public function index(Request $request) 
    {
        return $this->_userService->tenantMembers($request);
    }
    public function getAssignees(Request $request)
    {
        return $this->_userService->usersTenant($request);
    }
}
