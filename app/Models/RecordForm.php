<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecordForm extends Model
{
    use SoftDeletes;

    protected $table = 'record_forms';

    protected $fillable = [
        'record_code',
        'title',
        'link_url',
        'maintenance_years',
        'preservation_years',
        'remarks',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'           => 'boolean',
        'maintenance_years'   => 'integer',
        'preservation_years'  => 'integer',
        'display_order'       => 'integer',
    ];
}
