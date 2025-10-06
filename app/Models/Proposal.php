<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'title',
        'classification',
        'team_members',
        'target_agenda',
        'location',
        'time_frame',
        'beneficiaries_who',
        'beneficiaries_how_many',
        'budget_ps',
        'budget_mooe',
        'budget_co',
        'partner',
    ];

    protected $casts = [
        'beneficiaries_how_many' => 'integer',
        'budget_ps'   => 'decimal:2',
        'budget_mooe' => 'decimal:2',
        'budget_co'   => 'decimal:2',
    ];
}
