<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Agreement extends Model
{
    use LogsActivity;
   protected $fillable = ['user_id','organization_name','date_signed','mou_path','moa_path'];


    protected $casts = [
        'date_signed' => 'date',
    ];
}
