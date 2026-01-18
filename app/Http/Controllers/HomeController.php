<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   public function index()
{
    $year = now()->year;

    $campusOptions = [
        'CAFES', 'CAJIDIOCAN CAMPUS', 'CALATRAVA CAMPUS', 'CAS', 'CBA', 'CCMADI',
        'CED', 'CET', 'GEPS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS',
        'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'SAN FERNANDO CAMPUS'
    ];

    $user = auth()->user();
    $userType = $user->user_type ?? null;
    $isSuper = in_array($userType, ['root', 'admin'], true);

    $userCampus = $user->campus_college ?? ($user->college ?? null);

    /**
     * ✅ 1) GLOBAL KPI DATA
     */
    $globalFaculties = Faculty::whereYear('created_at', $year)->get();

    $kpi = [
        'involved_extension_total'    => round((float) ($globalFaculties->sum('involved_extension_total') / 4), 2),
        'iec_developed_total'         => (float) $globalFaculties->sum('iec_developed_total'),
        'iec_reproduced_total'        => (float) $globalFaculties->sum('iec_reproduced_total'),
        'iec_distributed_total'       => (float) $globalFaculties->sum('iec_distributed_total'),
        'proposals_approved_total'    => (float) $globalFaculties->sum('proposals_approved_total'),
        'proposals_implemented_total' => (float) $globalFaculties->sum('proposals_implemented_total'),
        'proposals_documented_total'  => (float) $globalFaculties->sum('proposals_documented_total'),
        'population_served_total'     => (float) $globalFaculties->sum('community_served_total'),
        'beneficiaries_total'         => (float) $globalFaculties->sum('beneficiaries_assistance_total'),
        'moa_mou_total'               => (float) $globalFaculties->sum('moa_mou_total'),
    ];

    /**
     * ✅ 2) FACULTY DATA FOR CHART (role-based)
     */
    if ($isSuper) {
        $campusesForChart = $campusOptions;
    } else {
        if ($userCampus && in_array($userCampus, $campusOptions, true)) {
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
            (int) $group->sum(fn($f) => $f->involved_extension_q1 + $f->involved_extension_q2 + $f->involved_extension_q3 + $f->involved_extension_q4),
            (int) $group->sum(fn($f) => $f->iec_developed_q1 + $f->iec_developed_q2 + $f->iec_developed_q3 + $f->iec_developed_q4),
            (int) $group->sum(fn($f) => $f->iec_reproduced_q1 + $f->iec_reproduced_q2 + $f->iec_reproduced_q3 + $f->iec_reproduced_q4),
            (int) $group->sum(fn($f) => $f->iec_distributed_q1 + $f->iec_distributed_q2 + $f->iec_distributed_q3 + $f->iec_distributed_q4),
            (int) $group->sum(fn($f) => $f->proposals_approved_q1 + $f->proposals_approved_q2 + $f->proposals_approved_q3 + $f->proposals_approved_q4),
            (int) $group->sum(fn($f) => $f->proposals_implemented_q1 + $f->proposals_implemented_q2 + $f->proposals_implemented_q3 + $f->proposals_implemented_q4),
            (int) $group->sum(fn($f) => $f->proposals_documented_q1 + $f->proposals_documented_q2 + $f->proposals_documented_q3 + $f->proposals_documented_q4),
            (int) $group->sum(fn($f) => $f->community_served_q1 + $f->community_served_q2 + $f->community_served_q3 + $f->community_served_q4),
            (int) $group->sum(fn($f) => $f->beneficiaries_assistance_q1 + $f->beneficiaries_assistance_q2 + $f->beneficiaries_assistance_q3 + $f->beneficiaries_assistance_q4),
            (int) $group->sum(fn($f) => $f->moa_mou_q1 + $f->moa_mou_q2 + $f->moa_mou_q3 + $f->moa_mou_q4),
        ];
    }

    /**
     * ✅ 3) DASHBOARD EVENTS
     * Show ALL PUBLIC events, plus PRIVATE events owned by user.
     */
    $upcomingEvents = CalendarEvent::query()
        ->where(function ($q) use ($user) {
            $q->whereRaw("LOWER(TRIM(visibility)) = 'public'")
              ->orWhere(function ($q) use ($user) {
                  $q->whereRaw("LOWER(TRIM(visibility)) = 'private'")
                    ->where('created_by', $user->id);
              });
        })
        ->orderBy('start_date', 'asc')
        ->limit(50)
        ->get();

    return view('dashboard', [
        'kpi'            => $kpi,
        'chart'          => $chart,
        'year'           => $year,
        'campuses'       => $campusesForChart,
        'isSuper'        => $isSuper,
        'userCampus'     => $userCampus,
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
