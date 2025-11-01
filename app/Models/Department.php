<?php

// app/Models/Department.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    public function permissions() {
        return $this->hasMany(DepartmentPermission::class);
    }

     public function users()
    {
        return $this->hasMany(User::class);   // users.department_id
    }
}
