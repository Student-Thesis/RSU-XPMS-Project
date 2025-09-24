<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $ops = Department::firstWhere('name','Operations');

        // ROOT user (bypass all)
        User::firstOrCreate(
            ['email' => 'root@xpms.com'],
            [
                'name' => 'Root User',
                'password' => Hash::make('password'), // CHANGE in real env
                'department_id' => $ops?->id,
                'is_root' => true,
            ]
        );

        // Normal user in Operations (limited by dept perms)
        User::firstOrCreate(
            ['email' => 'ops@xpms.com'],
            [
                'name' => 'Ops User',
                'password' => Hash::make('password'), // CHANGE
                'department_id' => $ops?->id,
                'is_root' => false,
            ]
        );
    }
}
