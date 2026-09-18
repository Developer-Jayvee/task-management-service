<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [];

        foreach ([
            'project view',
            'project create',
            'project update',
            'project delete',
            'ticket view',
            'ticket create',
            'ticket update',
            'ticket update-status',
            'ticket delete',
        ] as $name) {
            $permissions[$name] = Permission::create([
                'name' => $name,
                'guard_name' => 'api',
            ]);
        }

        $owner = Role::create(['name' => Roles::OWNER, 'guard_name' => 'api']);
        $member = Role::create(['name' => Roles::MEMBER, 'guard_name' => 'api']);

        $owner->givePermissionTo([
            $permissions['project view'],
            $permissions['project create'],
            $permissions['project update'],
            $permissions['project delete'],
            $permissions['ticket view'],
            $permissions['ticket create'],
            $permissions['ticket update'],
            $permissions['ticket update-status'],
            $permissions['ticket delete'],
        ]);

        $member->givePermissionTo([
            $permissions['ticket view'],
            $permissions['ticket update-status'],
        ]);

    }
}
