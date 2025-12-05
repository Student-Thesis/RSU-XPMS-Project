<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = ['user_id','organization_name','date_signed','mou_path','moa_path','mou_link','moa_link'];

    protected $casts = [
        'date_signed' => 'date',
    ];
}
