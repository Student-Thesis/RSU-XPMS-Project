<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

class HomeController extends Controller
{
    public function index()
    {
        // Aggregate KPI totals from `faculties`
        // Columns are defined in your SQL dump (involved_extension_*, iec_* , proposals_*, community_served_*, beneficiaries_assistance_*, moa_mou_*)
        $kpi = Faculty::query()
            ->selectRaw('
                SUM(involved_extension_total)    as involved_extension_total,
                SUM(iec_developed_total)         as iec_developed_total,
                SUM(iec_reproduced_total)        as iec_reproduced_total,
                SUM(iec_distributed_total)       as iec_distributed_total,
                SUM(proposals_approved_total)    as proposals_approved_total
            ')
            ->first();

        // Per-quarter breakdowns for the chart
        $quarters = Faculty::query()
            ->selectRaw('
                SUM(involved_extension_q1) as ext_q1,
                SUM(involved_extension_q2) as ext_q2,
                SUM(involved_extension_q3) as ext_q3,
                SUM(involved_extension_q4) as ext_q4,

                SUM(iec_developed_q1) as dev_q1,
                SUM(iec_developed_q2) as dev_q2,
                SUM(iec_developed_q3) as dev_q3,
                SUM(iec_developed_q4) as dev_q4
            ')
            ->first();

        // Safe defaults (avoid nulls)
        $kpi = [
            'involved_extension_total' => (int)($kpi->involved_extension_total ?? 0),
            'iec_developed_total'      => (int)($kpi->iec_developed_total ?? 0),
            'iec_reproduced_total'     => (int)($kpi->iec_reproduced_total ?? 0),
            'iec_distributed_total'    => (int)($kpi->iec_distributed_total ?? 0),
            'proposals_approved_total' => (int)($kpi->proposals_approved_total ?? 0),
        ];

        $chart = [
            'ext' => [
                (int)($quarters->ext_q1 ?? 0),
                (int)($quarters->ext_q2 ?? 0),
                (int)($quarters->ext_q3 ?? 0),
                (int)($quarters->ext_q4 ?? 0),
            ],
            'dev' => [
                (int)($quarters->dev_q1 ?? 0),
                (int)($quarters->dev_q2 ?? 0),
                (int)($quarters->dev_q3 ?? 0),
                (int)($quarters->dev_q4 ?? 0),
            ],
        ];


        return view('dashboard', compact('kpi', 'chart'));
    }

    public function register()
    {
        return view('auth.register');
    }
}
