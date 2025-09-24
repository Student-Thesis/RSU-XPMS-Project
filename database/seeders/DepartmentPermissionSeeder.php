<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Permission;

class DepartmentPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $ops = Department::firstWhere('name','Operations');
        if ($ops) {
            $opsPerms = Permission::whereIn('slug', [
                'invoices.view','invoices.create','invoices.export'
            ])->pluck('id')->all();
            $ops->permissions()->syncWithoutDetaching($opsPerms);
        }

        $acct = Department::firstWhere('name','Accounting');
        if ($acct) {
            $acctPerms = Permission::whereIn('slug', [
                'invoices.view','invoices.export','invoices.delete'
            ])->pluck('id')->all();
            $acct->permissions()->syncWithoutDetaching($acctPerms);
        }
    }
}
