<?php

namespace Database\Seeders;

use App\Models\PermissionDetails;
use Illuminate\Database\Seeder;

class PermissionDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data extracted directly from the Beekeeper Studio screenshot
        $permissions = [
            ['permission_id' => 1, 'description' => 'View Project','label' => 'project'],
            ['permission_id' => 2, 'description' => 'Create Project','label' => 'project'],
            ['permission_id' => 3, 'description' => 'Update Project','label' => 'project'],
            ['permission_id' => 4, 'description' => 'Delete Project','label' => 'project'],
            ['permission_id' => 5, 'description' => 'View Ticket','label' => 'ticket'],
            ['permission_id' => 6, 'description' => 'Create Ticket','label' => 'ticket'],
            ['permission_id' => 7, 'description' => 'Update Ticket','label' => 'ticket'],
            ['permission_id' => 8, 'description' => 'Update Ticket Status','label' => 'ticket'], 
            ['permission_id' => 9, 'description' => 'Delete Ticket','label' => 'ticket'],
            ['permission_id' => 10, 'description' => 'Reset Password','label' => 'user'], 
        ];

        // Insert the data into your target table. 
        // Note: Change 'your_target_table_name' to the actual table you want to insert this into.
        // If you are updating the existing 'permissions' table, you might use a different approach.
        
        foreach ($permissions as $permission) {
            PermissionDetails::query()->create([
                'permission_id' => $permission['permission_id'],
                'description' => $permission['description'],
                'label' => $permission['label']
            ]);
        }
    }
}