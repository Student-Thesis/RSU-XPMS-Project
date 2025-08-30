<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
         User::updateOrCreate(
            ['email' => 'admin@admin.com'], // match on email
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'), // default password
                // If you have roles/flags add here, e.g.:
                // 'is_admin' => true,
            ]
        );
    }
}
