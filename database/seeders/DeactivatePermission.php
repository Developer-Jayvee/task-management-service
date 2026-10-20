<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DeactivatePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $updatePermission = Permission::query()->firstOrCreate([
            'name' => 'user deactivate',
            'guard_name' => 'api',
        ]);

        $owner = Role::query()->where('name', Roles::OWNER)->where('guard_name', 'api')->firstOrFail();

        $owner->givePermissionTo($updatePermission);
    }
}
