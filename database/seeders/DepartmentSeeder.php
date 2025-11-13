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
        $manager     = Department::firstOrCreate(['name' => 'Project Leader']);
        $coordinator = Department::firstOrCreate(['name' => 'Coordinators']);

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
    }
}
