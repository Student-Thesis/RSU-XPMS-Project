<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    $rows = Proposal::query()
        ->whereYear('created_at', $year)
        ->selectRaw('college_campus, MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('college_campus', 'month')
        ->get();

    // 2) Get all campuses that actually appear in projects
    $campuses = $rows
        ->pluck('college_campus')
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
        foreach ($rows->where('college_campus', $campus) as $row) {
            $monthIndex = (int)$row->month - 1; // MONTH() is 1..12 → index 0..11
            $chart[$campus][$monthIndex] = (int)$row->total;
        }
    }

    // 4) KPIs (just to keep your Blade happy)
    $kpi = [
        'involved_extension_total' => Proposal::count(), // total projects
        'iec_developed_total'      => 0,
        'iec_reproduced_total'     => 0,
        'iec_distributed_total'    => 0,
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
