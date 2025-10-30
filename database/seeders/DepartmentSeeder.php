<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DepartmentPermission;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // create base departments
        $admin       = Department::firstOrCreate(['name' => 'Admins']);
        $manager     = Department::firstOrCreate(['name' => 'Managers']);
        $coordinator = Department::firstOrCreate(['name' => 'Coordinators']);
        $user        = Department::firstOrCreate(['name' => 'Users']); // renamed to plural to match others

        // master list of resources we used in routes
        $resources = [
            'users',
            'project',
            'forms',
            'faculty',
            'calendar',
            'notifications',
            'settings',
            'messages',
            // also protect permission UI itself
            'department_permissions',
        ];

        /* ========== ADMINS: full access ========== */
        foreach ($resources as $res) {
            DepartmentPermission::updateOrCreate(
                ['department_id' => $admin->id, 'resource' => $res],
                [
                    'can_view'   => true,
                    'can_create' => true,
                    'can_update' => true,
                    'can_delete' => true,
                ]
            );
        }

        /* ========== MANAGERS: all except delete ========== */
        foreach ($resources as $res) {
            DepartmentPermission::updateOrCreate(
                ['department_id' => $manager->id, 'resource' => $res],
                [
                    'can_view'   => true,
                    'can_create' => true,
                    'can_update' => true,
                    'can_delete' => false,
                ]
            );
        }

        /* ========== COORDINATORS: all except delete ========== */
        foreach ($resources as $res) {
            DepartmentPermission::updateOrCreate(
                ['department_id' => $coordinator->id, 'resource' => $res],
                [
                    'can_view'   => true,
                    'can_create' => true,
                    'can_update' => true,
                    'can_delete' => false,
                ]
            );
        }

        /* ========== USERS: view only ========== */
        foreach ($resources as $res) {
            DepartmentPermission::updateOrCreate(
                ['department_id' => $user->id, 'resource' => $res],
                [
                    'can_view'   => true,
                    'can_create' => false,
                    'can_update' => false,
                    'can_delete' => false,
                ]
            );
        }
    }
}
