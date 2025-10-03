<?php

// database/seeders/RecordFormSeeder.php
namespace Database\Seeders;

use App\Models\RecordForm;
use Illuminate\Database\Seeder;

class RecordFormSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['ECO-00-001','Faculty Extension Involvement','https://docs.google.com/document/d/1ieQ26xU9W-hj0CJhqnOInG6VZtkTFDzm/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-002','Summary of Faculty Extension Involvement','https://docs.google.com/document/d/146Of7PklEiGJG3lkbqajLk-CmfMcan7G/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-003','Technical Advice Slip','https://docs.google.com/document/d/1iovqO_RklBR9tfhel61taRxWpkosGeMm/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-004','Financial Report','https://docs.google.com/document/d/1nnMeyhI5KGMQj7msUgCREs5_-TXT3OMh/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-005','Training Needs Assessment (TNA)','https://docs.google.com/document/d/1Wn2Pa-BUdVMJ9mxiPa8AD5vYi4dCgCpx/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-006','Extension Training Proposal','https://docs.google.com/document/d/1KqRSMrFNlao8FTbjXCLBVWctdL1YysyU/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-007','Special Order Form','https://docs.google.com/document/d/19s8cIYPycKNauBYd9IY6ViOrwaQ7d92o/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-008','Extension Project Accomplishment Report','https://docs.google.com/document/d/1xzHbEaAZxDVeIt5iwbdmIZyXmo4kS8ns/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-009','Extension Project Monitoring Report','https://docs.google.com/document/d/19a0hYjsC4I32HY3fGwzs_vcTJLOGA51I/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Extension Service Request Form','https://docs.google.com/document/d/1Ok9sBp-Y6X87WeLdU5luLLO_9jNB5ETe/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Extension Training Proposal Evaluation Form','https://docs.google.com/document/d/1R0FWvcPkzEQmWCChSIWPB6HtTnoVJXsz/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Project LIB (Line Item Budget)','https://docs.google.com/spreadsheets/d/18k7Iui74MN1PDIJZdhAOTvD2VVKZy4FD/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Evaluation Form for Partner Agency','https://docs.google.com/document/d/1igAgbZ4CE4q3PNHlyNZYsJ2EJoXhcTQU/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Calendar of Activites','https://docs.google.com/document/d/19V03XNZW0pUBAtkiaRwVDlP74xoCoFxY/edit?usp=sharing&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Evaluation Criteria Form (Completed)','https://docs.google.com/document/d/1TR3gGuSa-YL88g2MyrGQiWpsV09xlHPZ/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Evaluation Criteria Form (Proposed)','https://docs.google.com/document/d/1VfN_zrOMubFzQ2Jhdq1PN5D4ygwl_PyH/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Project Proposal Form for Technology Transfer','https://docs.google.com/document/d/1p5fqAZFCyhkIJNjzonU23C-BvyVOvJf1/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Project Work Plan Form','https://docs.google.com/document/d/1U8sdGUUo41aH5Y22ZgF2ingJtII39kmT/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Project Proposal Tempalte','https://docs.google.com/document/d/16MfnzeflPT36_Xad-vbHj5EkF22xnMHP/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Project Monitoring Report Template','https://docs.google.com/document/d/1F_77-5G5Eu0rOwZ3XJT9Agt2VQkfxiOz/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Project Evaluation Template','https://docs.google.com/document/d/1KgForyqbXMRV2SKdEt7AqseTrNH86dNK/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Terminal & Progress Report Template','https://docs.google.com/document/d/1kF5c6yELdoAS2bVl1lbJUHSp7bpT--n2/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
            ['ECO-00-010','Activity Proposal Tempalate','https://docs.google.com/document/d/1vo2LhbB0lewZh8Lf_1C1juhCDwh_ehPu/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true'],
        ];

        foreach ($rows as $i => [$code, $title, $url]) {
            RecordForm::updateOrCreate(
                ['record_code' => $code, 'title' => $title],
                [
                    'link_url' => $url,
                    'maintenance_years' => 5,
                    'preservation_years' => 5,
                    'remarks' => 'IN-USE',
                    'display_order' => $i + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
