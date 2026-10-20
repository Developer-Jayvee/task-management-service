<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;
use App\Services\PermissionDetailsService;
class PermissionDetailsController extends Controller
{
     public function __construct(
        public PermissionDetailsService $_service
    ){}
    public function index(Request $request)
    {
        $request->validate([
            'role' => ['required','in:member,owner']
        ]);
        
        return $this->_service->viewPermissions(
            role: $request->query('role','member')
        );
    }

    public function update(UpdatePermissionRequest $request)
    {
        return $this->_service->updateRolePermission(
            permissions: $request->input('permission_ids'),
            role:$request->input('role'),
        );
    }
}
