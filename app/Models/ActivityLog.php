<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    // UUID primary
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'action',
        'model_type',
        'model_id',
        'changes',
        'ip_address',
        'user_agent',
        'notifiable_user_id'
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    // so ->created_at->diffForHumans() works in Blade
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function notifiableUser()
    {
        return $this->belongsTo(User::class, 'notifiable_user_id');
    }
}
