<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view_setting',
            'edit_setting',
            'add_user',
            'show_user',
            'edit_user',
            'delete_user',
        ];

        foreach($permissions as $permission)
        {
            Permission::updateOrCreate(
                ['name' => $permission],[
                    'name' => $permission,
                    'guard_name' => 'web',
                ]);
        }
    }
}
