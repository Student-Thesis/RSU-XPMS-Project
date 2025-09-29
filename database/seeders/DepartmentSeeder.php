<?php

// database/seeders/DepartmentSeeder.php
namespace Database\Seeders;

use App\Models\Department;
use App\Models\DepartmentPermission;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $admin   = Department::firstOrCreate(['name' => 'Admins']);
        $manager = Department::firstOrCreate(['name' => 'Managers']);
        $coor    = Department::firstOrCreate(['name' => 'Coordinators']);

        // Coordinators: can view Projects only
        DepartmentPermission::updateOrCreate(
            ['department_id' => $coor->id, 'resource' => 'Projects'],
            ['can_view' => true]
        );

        // Managers: full on Forms
        DepartmentPermission::updateOrCreate(
            ['department_id' => $manager->id, 'resource' => 'Forms'],
            ['can_view' => true, 'can_create' => true, 'can_update' => true, 'can_delete' => true]
        );

        // Admins: full on Faculty
        DepartmentPermission::updateOrCreate(
            ['department_id' => $admin->id, 'resource' => 'Faculty'],
            ['can_view' => true, 'can_create' => true, 'can_update' => true, 'can_delete' => true]
        );

        // Admins: full on Users
        DepartmentPermission::updateOrCreate(
            ['department_id' => $admin->id, 'resource' => 'Users'],
            ['can_view' => true, 'can_create' => true, 'can_update' => true, 'can_delete' => true]
        );
    }
}
