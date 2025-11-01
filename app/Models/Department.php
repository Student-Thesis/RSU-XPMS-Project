<?php

// app/Models/Department.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Department extends Model
{
    use LogsActivity;
    protected $fillable = ['name'];

    public function permissions() {
        return $this->hasMany(DepartmentPermission::class);
    }

     public function users()
    {
        return $this->hasMany(User::class);   // users.department_id
    }
}
