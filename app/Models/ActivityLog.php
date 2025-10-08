<?php

// app/Models/ActivityLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','user_id','action','model_type','model_id','changes','ip_address','user_agent'
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
