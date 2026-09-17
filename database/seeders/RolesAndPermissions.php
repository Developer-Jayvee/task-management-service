<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Permission::create(['name' => 'project view']);
        Permission::create(['name' => 'project create']);
        Permission::create(['name' => 'project update']);
        Permission::create(['name' => 'project delete']);
        
        Permission::create(['name' => 'ticket view']);
        Permission::create(['name' => 'ticket create']);
        Permission::create(['name' => 'ticket update']);
        Permission::create(['name' => 'ticket update-status']);
        Permission::create(['name' => 'ticket delete']);

        $owner = Role::create(['name' => Roles::OWNER]);
        $member = Role::create(['name' => Roles::MEMBER]);

        $owner->givePermissionTo('project view');
        $owner->givePermissionTo('project create');
        $owner->givePermissionTo('project update');
        $owner->givePermissionTo('project delete');

        $owner->givePermissionTo('ticket view');
        $owner->givePermissionTo('ticket update');
        $owner->givePermissionTo('ticket update-status');
        $owner->givePermissionTo('ticket create');
        $owner->givePermissionTo('ticket delete');


        $member->givePermissionTo('ticket view');
        $member->givePermissionTo('ticket update-status');



    }
}
