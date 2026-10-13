<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ResetPasswordPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resetPermission = Permission::query()->firstOrCreate([
            'name' => 'user reset-password',
            'guard_name' => 'api',
        ]);

        $ownder = Role::query()->where('name', Roles::OWNER)->where('guard_name', 'api')->firstOrFail();

        $ownder->givePermissionTo($resetPermission);
    }
}
