<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = [
        'user_id',
        'resource',
        'can_view',
        'can_create',
        'can_update',
        'can_delete',
    ];
}
