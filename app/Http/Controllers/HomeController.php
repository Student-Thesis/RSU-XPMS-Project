<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Proposal;

class HomeController extends Controller
{
   public function index()
{
    // Which year to report? -> this year
    $year = now()->year;

    // 1) Get counts per campus per month
    // result shape:
    // college_campus | month | total
    $rows = Faculty::query()
        ->whereYear('created_at', $year)
        ->selectRaw('campus_college, MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('campus_college', 'month')
        ->get();

    // 2) Get all campuses that actually appear in projects
    $campuses = $rows
        ->pluck('campus_college')
        ->filter()            // remove null / empty
        ->unique()
        ->values();

    // 3) Build chart array like:
    // [
    //   "CAS" => [0,3,1,0,2,0,0,0,0,0,0,0],
    //   "CBA" => [1,0,0,0,0,0,0,0,0,0,0,0],
    // ]
    // index 0 = January, 11 = December (we'll match this in JS)
    $chart = [];
    foreach ($campuses as $campus) {
        // start with 12 zeros
        $chart[$campus] = array_fill(0, 12, 0);

        // fill from DB rows
        foreach ($rows->where('campus_college', $campus) as $row) {
            $monthIndex = (int)$row->month - 1; // MONTH() is 1..12 → index 0..11
            $chart[$campus][$monthIndex] = (int)$row->total;
        }
    }

    // 4) KPIs (just to keep your Blade happy)
    $kpi = [
         'involved_extension_total' => Faculty::sum('involved_extension_total'),

    'iec_developed_total'      => Faculty::sum('iec_developed_total'),
    'iec_reproduced_total'     => Faculty::sum('iec_reproduced_total'),
    'iec_distributed_total'    => Faculty::sum('iec_distributed_total'),
        'proposals_approved_total' => Proposal::where('status', 'approved')->count(),
    ];

    return view('dashboard', [
        'kpi'   => $kpi,
        'chart' => $chart,    // <-- IMPORTANT: now campus => [jan..dec]
        'year'  => $year,
    ]);
}

    public function register()
    {
        return view('auth.register');
    }
}
