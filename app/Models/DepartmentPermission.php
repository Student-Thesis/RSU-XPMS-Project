<?php

// app/Models/DepartmentPermission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class DepartmentPermission extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'department_id', 'resource',
        'can_view', 'can_create', 'can_update', 'can_delete',
    ];

    protected $casts = [
        'can_view' => 'boolean',
        'can_create' => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
    ];

      public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
