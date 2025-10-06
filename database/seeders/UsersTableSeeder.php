<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Root user
        User::updateOrCreate(
            ['email' => 'root@xpms.com'],
            [
                'username' => 'Root',
                'first_name' => 'Root',
                'last_name' => 'User',
                'password' => Hash::make('root'),
                'department_id' => 1, // Admins department
                'user_type' => 'root',
            ],
        );

        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@xpms.com'],
            [
                'username' => 'Admin',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => Hash::make('admin123'),
                'department_id' => 1, // Admins department
                'user_type' => 'admin',
            ],
        );

        // Manager user
        User::updateOrCreate(
            ['email' => 'manager@xpms.com'],
            [
                'username' => 'Manager',
                'first_name' => 'Manager',
                'last_name' => 'User',
                'password' => Hash::make('manager123'),
                'department_id' => 2, // Managers department
                'user_type' => 'manager',
            ],
        );

        // Coordinator user
        User::updateOrCreate(
            ['email' => 'coordinator@xpms.com'],
            [
                'username' => 'Coordinator',
                'first_name' => 'Coordinator',
                'last_name' => 'User',
                'password' => Hash::make('coordinator123'),
                'department_id' => 3, // Coordinators department
                'user_type' => 'coordinator',
            ],
        );
    }
}
