<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

class HomeController extends Controller
{
    public function index()
    {
        $year = now()->year;

        // 🔹 Canonical list of campuses (must match what you store in DB)
        $campusOptions = [
            'CAFES',
            'CAJIDIOCAN CAMPUS',
            'CALATRAVA CAMPUS',
            'CAS',
            'CBA',
            'CCMADI',
            'CED',
            'CET',
            'GEPS',
            'STA. MARIA CAMPUS',
            'SANTA FE CAMPUS',
            'SAN ANDRES CAMPUS',
            'SAN AGUSTIN CAMPUS',
            'ROMBLON CAMPUS',
            'SAN FERNANDO CAMPUS',
        ];

        // 🔹 Get logged-in user
        $user = auth()->user();

        // user_type logic: root/admin can see everything
        $userType   = $user->user_type ?? null;
        $isSuper    = in_array($userType, ['root', 'admin']);

        // Try to read campus/college from user record
        // adjust if your column name is different
        $userCampus = $user->campus_college
            ?? $user->college
            ?? null;

        // 🔹 Decide which campuses to include in the chart
        if ($isSuper) {
            // root/admin → all campuses
            $campusesForChart = $campusOptions;
        } else {
            // normal user → only their campus, if valid; otherwise fallback to none/all
            if ($userCampus && in_array($userCampus, $campusOptions)) {
                $campusesForChart = [$userCampus];
            } else {
                // fallback: no campus match → you can either:
                //  - show nothing: []
                //  - or show all: $campusOptions
                // Here we choose to show nothing rather than wrong data
                $campusesForChart = [];
            }
        }

        // 🔹 Base faculty query for this year
        $facultiesQuery = Faculty::whereYear('created_at', $year);

        // If not super, filter faculty rows to the user's campus
        if (!$isSuper && $userCampus) {
            $facultiesQuery->where('campus_college', $userCampus);
        }

        // Execute query once
        $faculties = $facultiesQuery->get();

        // 🔹 Build chart data (using only $campusesForChart)
        $chart = [];

        foreach ($campusesForChart as $campus) {
            // Filter current campus from loaded collection
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

        // 🔹 KPI cards – will automatically be:
        //  - ALL campuses for root/admin
        //  - Only that campus for normal users (due to query filter above)
        $kpi = [
            'involved_extension_total'    => $faculties->sum('involved_extension_total'),
            'iec_developed_total'         => $faculties->sum('iec_developed_total'),
            'iec_reproduced_total'        => $faculties->sum('iec_reproduced_total'),
            'iec_distributed_total'       => $faculties->sum('iec_distributed_total'),
            'proposals_approved_total'    => $faculties->sum('proposals_approved_total'),
            'proposals_implemented_total' => $faculties->sum('proposals_implemented_total'),
            'proposals_documented_total'  => $faculties->sum('proposals_documented_total'),
            'population_served_total'     => $faculties->sum('community_served_total'),
            'beneficiaries_total'         => $faculties->sum('beneficiaries_assistance_total'),
            'moa_mou_total'               => $faculties->sum('moa_mou_total'),
        ];

        return view('dashboard', [
            'kpi'          => $kpi,
            'chart'        => $chart,
            'year'         => $year,
            'campuses'     => $campusesForChart, // campuses actually shown
            'isSuper'      => $isSuper,
            'userCampus'   => $userCampus,
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function showForgotForm()
    {
        return view('auth.reset');
    }
}
