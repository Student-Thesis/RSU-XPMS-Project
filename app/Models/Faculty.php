<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';

    protected $fillable = [
        'campus_college',
        'num_faculties',

        'involved_extension_total','involved_extension_q1','involved_extension_q2','involved_extension_q3','involved_extension_q4',

        'iec_developed_total','iec_developed_q1','iec_developed_q2','iec_developed_q3','iec_developed_q4',
        'iec_reproduced_total','iec_reproduced_q1','iec_reproduced_q2','iec_reproduced_q3','iec_reproduced_q4',
        'iec_distributed_total','iec_distributed_q1','iec_distributed_q2','iec_distributed_q3','iec_distributed_q4',

        'proposals_approved_total','proposals_approved_q1','proposals_approved_q2','proposals_approved_q3','proposals_approved_q4',
        'proposals_implemented_total','proposals_implemented_q1','proposals_implemented_q2','proposals_implemented_q3','proposals_implemented_q4',
        'proposals_documented_total','proposals_documented_q1','proposals_documented_q2','proposals_documented_q3','proposals_documented_q4',

        'community_served_total','community_served_q1','community_served_q2','community_served_q3','community_served_q4',

        'beneficiaries_assistance_total','beneficiaries_assistance_q1','beneficiaries_assistance_q2','beneficiaries_assistance_q3','beneficiaries_assistance_q4',

        'moa_mou_total','moa_mou_q1','moa_mou_q2','moa_mou_q3','moa_mou_q4',
    ];
}
