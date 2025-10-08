<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Proposal extends Model
{
    protected $fillable = [
        'title','classification','team_members','leader','target_agenda','location','college_campus',
        'time_frame','beneficiaries_who','beneficiaries_how_many',
        'budget_ps','budget_mooe','budget_co','partner',
        'in_house','revised_proposal','ntp','endorsement','proposal_presentation','proposal_documents',
        'program_proposal','project_proposal','moa_mou','activity_design','certificate_of_appearance',
        'attendance_sheet','photos','terminal_report',
        'source_of_funds','expenditure','fund_utilization_rate','status',
        'documentation_report','code','remarks','drive_link',
    ];

    protected $casts = [
        'budget_ps' => 'decimal:2',
        'budget_mooe' => 'decimal:2',
        'budget_co' => 'decimal:2',
        'expenditure' => 'decimal:2',
        'in_house' => 'bool','revised_proposal' => 'bool','ntp' => 'bool','endorsement' => 'bool',
        'proposal_presentation' => 'bool','proposal_documents' => 'bool','program_proposal' => 'bool',
        'project_proposal' => 'bool','moa_mou' => 'bool','activity_design' => 'bool',
        'certificate_of_appearance' => 'bool','attendance_sheet' => 'bool','photos' => 'bool',
        'terminal_report' => 'bool',
    ];

    public function getApprovedBudgetAttribute(): float
    {
        return (float)($this->budget_ps ?? 0) + (float)($this->budget_mooe ?? 0) + (float)($this->budget_co ?? 0);
    }

    public function getLeaderAttribute($v): ?string
    {
        return $v ?: (collect(explode(',', (string)$this->team_members))->map('trim')->first() ?: null);
    }
}
