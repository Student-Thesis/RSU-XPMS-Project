<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

class HomeController extends Controller
{
    public function index()
    {
        // Current year
        $year = now()->year;

        // 🔹 Define ALL campuses you want to appear in the filter + chart
        $allCampuses = [
            'CAFES',
            'Cajidiocan Campus',
            'Calatrava Campus',
            'CAS',
            'CBA',
            'CCMADI',
            'CED',
            'CET',
            'GEPS',
            'Sta. Maria Campus',
            'Santa Fe Campus',
            'San Andres Campus',
            'San Agustin Campus',
            'Romblon Campus',
            'San Fernando Campus',
        ];

        // 1) Get all faculty rows for this year (one query only)
        $faculties = Faculty::whereYear('created_at', $year)->get();

        // 2) Build chart array for ALL campuses (even if no rows → all 0)
        // Each value is computed from q1 + q2 + q3 + q4
        $chart = [];

        foreach ($allCampuses as $campus) {
            $group = $faculties->where('campus_college', $campus);

            $chart[$campus] = [
                // NO. OF FACULTY INVOLVED IN EXTENSION (60% = 173)
                (int) $group->sum(function ($f) {
                    return $f->involved_extension_q1
                        + $f->involved_extension_q2
                        + $f->involved_extension_q3
                        + $f->involved_extension_q4;
                }),

                // NO. OF IEC MATERIALS DEVELOPED (25)
                (int) $group->sum(function ($f) {
                    return $f->iec_developed_q1
                        + $f->iec_developed_q2
                        + $f->iec_developed_q3
                        + $f->iec_developed_q4;
                }),

                // NO. OF IEC MATERIALS REPRODUCED (600)
                (int) $group->sum(function ($f) {
                    return $f->iec_reproduced_q1
                        + $f->iec_reproduced_q2
                        + $f->iec_reproduced_q3
                        + $f->iec_reproduced_q4;
                }),

                // NO. OF IEC MATERIALS DISTRIBUTED (600)
                (int) $group->sum(function ($f) {
                    return $f->iec_distributed_q1
                        + $f->iec_distributed_q2
                        + $f->iec_distributed_q3
                        + $f->iec_distributed_q4;
                }),

                // NO. OF QUALITY EXTENSION PROPOSALS APPROVED (13)
                (int) $group->sum(function ($f) {
                    return $f->proposals_approved_q1
                        + $f->proposals_approved_q2
                        + $f->proposals_approved_q3
                        + $f->proposals_approved_q4;
                }),

                // NO. OF QUALITY EXTENSION PROPOSALS IMPLEMENTED (13)
                (int) $group->sum(function ($f) {
                    return $f->proposals_implemented_q1
                        + $f->proposals_implemented_q2
                        + $f->proposals_implemented_q3
                        + $f->proposals_implemented_q4;
                }),

                // NO. OF QUALITY EXTENSION PROPOSALS DOCUMENTED (13)
                (int) $group->sum(function ($f) {
                    return $f->proposals_documented_q1
                        + $f->proposals_documented_q2
                        + $f->proposals_documented_q3
                        + $f->proposals_documented_q4;
                }),

                // NO. OF COMMUNITY POPULATION SERVED (5,939)
                (int) $group->sum(function ($f) {
                    return $f->community_served_q1
                        + $f->community_served_q2
                        + $f->community_served_q3
                        + $f->community_served_q4;
                }),

                // NO. OF BENEFICIARIES OF TECHNICAL ASSISTANCE (813)
                (int) $group->sum(function ($f) {
                    return $f->beneficiaries_assistance_q1
                        + $f->beneficiaries_assistance_q2
                        + $f->beneficiaries_assistance_q3
                        + $f->beneficiaries_assistance_q4;
                }),

                // NO. OF MOA / MOU SIGNED (8)
                (int) $group->sum(function ($f) {
                    return $f->moa_mou_q1
                        + $f->moa_mou_q2
                        + $f->moa_mou_q3
                        + $f->moa_mou_q4;
                }),
            ];
        }

        // 3) KPI CARDS (overall totals across all campuses, still using q1–q4)
       $kpi = [
            'involved_extension_total' => $faculties->sum('involved_extension_total'),
            'iec_developed_total'      => $faculties->sum('iec_developed_total'),
            'iec_reproduced_total'     => $faculties->sum('iec_reproduced_total'),
            'iec_distributed_total'    => $faculties->sum('iec_distributed_total'),
            'proposals_approved_total' => $faculties->sum('proposals_approved_total'),

            'proposals_implemented_total' => null,
            'proposals_documented_total'  => null,
            'population_served_total'     => null,
            'beneficiaries_total'         => null,
            'moa_mou_total'               => null,
        ];

        return view('dashboard', [
            'kpi'      => $kpi,
            'chart'    => $chart,      // campus => [metrics...], derived from q1–q4
            'year'     => $year,
            'campuses' => $allCampuses, // if you need it in Blade
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }
}
