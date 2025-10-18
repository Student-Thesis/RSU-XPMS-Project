<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
   protected $fillable = ['user_id','organization_name','date_signed','mou_path','moa_path'];


    protected $casts = [
        'date_signed' => 'date',
    ];
}
