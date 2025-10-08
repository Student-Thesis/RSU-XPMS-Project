<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proposal;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example proposals
        $samples = [
            [
                'title' => 'Community Organic Farming Program',
                'classification' => 'Program',
                'team_members' => 'Alice Santos, Bob Cruz, Charlie Reyes',
                'leader' => 'Alice Santos',
                'target_agenda' => 'Environmental Awareness',
                'location' => 'Romblon Campus',
                'college_campus' => 'CAFES',
                'time_frame' => '6 months',
                'beneficiaries_who' => 'Local Farmers',
                'beneficiaries_how_many' => 150,
                'budget_ps' => 25000,
                'budget_mooe' => 15000,
                'budget_co' => 5000,
                'partner' => 'LGU Romblon',
                'in_house' => true,
                'revised_proposal' => false,
                'ntp' => true,
                'endorsement' => true,
                'proposal_presentation' => true,
                'proposal_documents' => true,
                'program_proposal' => true,
                'project_proposal' => false,
                'moa_mou' => true,
                'activity_design' => true,
                'certificate_of_appearance' => false,
                'attendance_sheet' => false,
                'photos' => false,
                'terminal_report' => false,
                'source_of_funds' => 'External Donor',
                'expenditure' => 20000,
                'fund_utilization_rate' => '80%',
                'status' => 'Ongoing',
                'documentation_report' => 'Draft available',
                'code' => '2025-001',
                'remarks' => 'Need additional funding',
                'drive_link' => 'https://drive.google.com/example1',
            ],
            [
                'title' => 'Literacy for All Project',
                'classification' => 'Project',
                'team_members' => 'Diana Cruz, Edgar Lopez',
                'leader' => 'Diana Cruz',
                'target_agenda' => 'Education',
                'location' => 'Sta. Maria Campus',
                'college_campus' => 'CED',
                'time_frame' => '3 months',
                'beneficiaries_who' => 'Elementary Students',
                'beneficiaries_how_many' => 200,
                'budget_ps' => 10000,
                'budget_mooe' => 8000,
                'budget_co' => 2000,
                'partner' => 'DepEd',
                'in_house' => false,
                'revised_proposal' => true,
                'ntp' => false,
                'endorsement' => false,
                'proposal_presentation' => true,
                'proposal_documents' => false,
                'program_proposal' => false,
                'project_proposal' => true,
                'moa_mou' => false,
                'activity_design' => true,
                'certificate_of_appearance' => true,
                'attendance_sheet' => true,
                'photos' => true,
                'terminal_report' => false,
                'source_of_funds' => 'GAA',
                'expenditure' => 9000,
                'fund_utilization_rate' => '75%',
                'status' => 'Ongoing',
                'documentation_report' => 'Pending',
                'code' => '2025-002',
                'remarks' => 'Schedule presentation',
                'drive_link' => 'https://drive.google.com/example2',
            ],
        ];

        foreach ($samples as $sample) {
            Proposal::create($sample);
        }
    }
}
