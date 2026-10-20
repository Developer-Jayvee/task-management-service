<?php

namespace App\Http\Controllers;

use App\Services\RolesService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct(
        public RolesService $_service
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->_service->roleList();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $roleId)
    {
        return $this->_service->deleteRole(
            Role::query()->findOrFail($roleId)
        );
    }
}
