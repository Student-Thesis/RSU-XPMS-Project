<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Operations','Sales','Accounting','HR','IT'] as $name) {
            Department::firstOrCreate(['name' => $name]);
        }
    }
}
