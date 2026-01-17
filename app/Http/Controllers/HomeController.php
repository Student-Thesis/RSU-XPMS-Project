<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\CalendarEvent; // 👈 add this

class HomeController extends Controller
{
    public function index()
    {
        $year = now()->year;

        $campusOptions = ['CAFES', 'CAJIDIOCAN CAMPUS', 'CALATRAVA CAMPUS', 'CAS', 'CBA', 'CCMADI', 'CED', 'CET', 'GEPS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'SAN FERNANDO CAMPUS'];

        $user = auth()->user();
        $userType = $user->user_type ?? null;
        $isSuper = in_array($userType, ['root', 'admin']);

        $userCampus = $user->campus_college ?? ($user->college ?? null);

        /**
         * ✅ 1) GLOBAL FACULTY DATA (for KPI cards – no campus restriction)
         */
        $globalFaculties = Faculty::whereYear('created_at', $year)->get();

        $kpi = [
            'involved_extension_total' =>(int) round($globalFaculties->sum('involved_extension_total') / 4),
            'iec_developed_total' => $globalFaculties->sum('iec_developed_total'),
            'iec_reproduced_total' => $globalFaculties->sum('iec_reproduced_total'),
            'iec_distributed_total' => $globalFaculties->sum('iec_distributed_total'),
            'proposals_approved_total' => $globalFaculties->sum('proposals_approved_total'),
            'proposals_implemented_total' => $globalFaculties->sum('proposals_implemented_total'),
            'proposals_documented_total' => $globalFaculties->sum('proposals_documented_total'),
            'population_served_total' => $globalFaculties->sum('community_served_total'),
            'beneficiaries_total' => $globalFaculties->sum('beneficiaries_assistance_total'),
            'moa_mou_total' => $globalFaculties->sum('moa_mou_total'),
        ];

        /**
         * ✅ 2) FACULTY DATA FOR CHART (respect original restriction)
         *    - super: all campuses
         *    - normal: only their campus
         */
        if ($isSuper) {
            $campusesForChart = $campusOptions;
        } else {
            if ($userCampus && in_array($userCampus, $campusOptions)) {
                $campusesForChart = [$userCampus];
            } else {
                $campusesForChart = [];
            }
        }

        $facultiesForChartQuery = Faculty::whereYear('created_at', $year);

        if (!$isSuper && $userCampus) {
            $facultiesForChartQuery->where('campus_college', $userCampus);
        }

        $facultiesForChart = $facultiesForChartQuery->get();

        $chart = [];

        foreach ($campusesForChart as $campus) {
            $group = $facultiesForChart->where('campus_college', $campus);

            $chart[$campus] = [
                (int) $group->sum(function ($f) {
                    return $f->involved_extension_q1 + $f->involved_extension_q2 + $f->involved_extension_q3 + $f->involved_extension_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->iec_developed_q1 + $f->iec_developed_q2 + $f->iec_developed_q3 + $f->iec_developed_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->iec_reproduced_q1 + $f->iec_reproduced_q2 + $f->iec_reproduced_q3 + $f->iec_reproduced_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->iec_distributed_q1 + $f->iec_distributed_q2 + $f->iec_distributed_q3 + $f->iec_distributed_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->proposals_approved_q1 + $f->proposals_approved_q2 + $f->proposals_approved_q3 + $f->proposals_approved_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->proposals_implemented_q1 + $f->proposals_implemented_q2 + $f->proposals_implemented_q3 + $f->proposals_implemented_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->proposals_documented_q1 + $f->proposals_documented_q2 + $f->proposals_documented_q3 + $f->proposals_documented_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->community_served_q1 + $f->community_served_q2 + $f->community_served_q3 + $f->community_served_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->beneficiaries_assistance_q1 + $f->beneficiaries_assistance_q2 + $f->beneficiaries_assistance_q3 + $f->beneficiaries_assistance_q4;
                }),
                (int) $group->sum(function ($f) {
                    return $f->moa_mou_q1 + $f->moa_mou_q2 + $f->moa_mou_q3 + $f->moa_mou_q4;
                }),
            ];
        }

        /**
         * ✅ 3) UPCOMING EVENTS (same as before)
         */
        $start = now()->startOfDay();
        $end = now()->addDays(7)->endOfDay();

        $upcomingEvents = CalendarEvent::query()
            ->whereBetween('start_date', [$start, $end])
            ->where(function ($q) use ($user) {
                $q->where('visibility', 'public')->orWhere(function ($q) use ($user) {
                    $q->where('visibility', 'private')->where('created_by', $user->id);
                });
            })
            ->orderBy('start_date')
            ->limit(10)
            ->get();

        return view('dashboard', [
            'kpi' => $kpi, // 🌍 global for KPI cards
            'chart' => $chart, // 🔐 filtered per original logic
            'year' => $year,
            'campuses' => $campusesForChart, // chart dropdown respects role
            'isSuper' => $isSuper,
            'userCampus' => $userCampus,
            'upcomingEvents' => $upcomingEvents,
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
