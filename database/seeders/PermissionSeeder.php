<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'View Project',   'slug' => 'project.view'],
            ['name' => 'Create Project', 'slug' => 'project.create'],
            ['name' => 'Delete Project', 'slug' => 'project.delete'],
            ['name' => 'Export Project', 'slug' => 'project.export'],
            ['name' => 'Manage Department Permissions', 'slug' => 'permissions.manage']
        ];
        foreach ($items as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
