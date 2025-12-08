<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Proposal; 

class Agreement extends Model
{
    protected $fillable = ['user_id','organization_name','date_signed','mou_path','moa_path','mou_link','moa_link','proposal_id'];

    protected $casts = [
        'date_signed' => 'date',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id');
    }
}
