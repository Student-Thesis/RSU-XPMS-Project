@extends('layouts.app')

@section('content')
    <!-- right content -->
    <div id="content">
        @include('layouts.partials.topnav')

        <!-- dashboard inner -->
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h2>Dashboard</h2>
                        </div>
                    </div>
                </div>

                {{-- KPI Row 1 --}}
                <div class="row column1">
                    <div class="col-md-6 col-lg-3">
                        <div class="full counter_section margin_bottom_30">
                            <div class="couter_icon">
                                <div><i class="fa fa-user yellow_color"></i></div>
                            </div>
                            <div class="counter_no">
                                <div>
                                    <p class="total_no">{{ number_format($kpi['involved_extension_total']) }}</p>
                                    <p class="head_couter">No. Of Involved in Extension</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="full counter_section margin_bottom_30">
                            <div class="couter_icon">
                                <div><i class="fa fa-clock-o blue1_color"></i></div>
                            </div>
                            <div class="counter_no">
                                <div>
                                    <p class="total_no">{{ number_format($kpi['iec_developed_total']) }}</p>
                                    <p class="head_couter">No. Of IEC Materials Developed</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="full counter_section margin_bottom_30">
                            <div class="couter_icon">
                                <div><i class="fa fa-cloud-download green_color"></i></div>
                            </div>
                            <div class="counter_no">
                                <div>
                                    <p class="total_no">{{ number_format($kpi['iec_reproduced_total']) }}</p>
                                    <p class="head_couter">No. Of IEC Materials Reproduced</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="full counter_section margin_bottom_30">
                            <div class="couter_icon">
                                <div><i class="fa fa-comments-o red_color"></i></div>
                            </div>
                            <div class="counter_no">
                                <div>
                                    <p class="total_no">{{ number_format($kpi['iec_distributed_total']) }}</p>
                                    <p class="head_couter">No. OF IEC Materials Distributed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KPI Row 2 --}}
                <div class="row column1">
                    <div class="col-md-6 col-lg-3">
                        <div class="full counter_section margin_bottom_30">
                            <div class="couter_icon">
                                <div><i class="fa fa-check-square-o red_color"></i></div>
                            </div>
                            <div class="counter_no">
                                <div>
                                    <p class="total_no">{{ number_format($kpi['proposals_approved_total']) }}</p>
                                    <p class="head_couter">No. Of Quality Extension Proposal Approved</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart --}}
                <div class="row column2 graph margin_bottom_30">
                    <div class="col-md-l2 col-lg-12">
                        <div class="white_shd full">
                            <div class="full graph_head d-flex justify-content-between align-items-center gap-2 flex-wrap">
                                <div class="heading1 margin_0">
                                    <h2>Monthly Trends (Dummy Data)</h2>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <label for="campusSelect" class="mb-0" style="font-size:.8rem;">College/Campus:</label>
                                    <select id="campusSelect" class="form-control form-control-sm" style="min-width:220px;">
                                        <option value="CAFES">CAFES</option>
                                        <option value="Cajidiocan Campus">Cajidiocan Campus</option>
                                        <option value="Calatrava Campus">Calatrava Campus</option>
                                        <option value="CAS">CAS</option>
                                        <option value="CBA">CBA</option>
                                        <option value="CCMADI">CCMADI</option>
                                        <option value="CED">CED</option>
                                        <option value="CET">CET</option>
                                        <option value="GEPS">GEPS</option>
                                        <option value="Sta. Maria Campus">Sta. Maria Campus</option>
                                        <option value="Santa Fe Campus">Santa Fe Campus</option>
                                        <option value="San Andres Campus">San Andres Campus</option>
                                        <option value="San Agustin Campus">San Agustin Campus</option>
                                        <option value="Romblon Campus">Romblon Campus</option>
                                        <option value="San Fernando Campus">San Fernando Campus</option>
                                        <option value="(Blanks)">(Blanks)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="full graph_revenue">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="content">
                                            <div class="area_chart">
                                                {{-- 👇 use a UNIQUE id so theme scripts won't draw their demo chart here --}}
                                                <canvas id="monthlyTrendsChart" height="120"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /graph_revenue -->
                        </div>
                    </div>
                </div>
                <!-- end graph -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" crossorigin="anonymous"></script>
<script>
(function () {
    const canvas = document.getElementById('monthlyTrendsChart');
    const select  = document.getElementById('campusSelect');
    if (!canvas || !select) return;

    const ctx = canvas.getContext('2d');

    // this comes from controller: ['CAS' => [..12 nums..], 'CBA' => [...], ...]
    const chartData = @json($chart ?? []);

    // months
    const labels = ['January','February','March','April','May','June','July','August','September','October','November','December'];

    let chart = null;

    function render(campus) {
        if (chart) chart.destroy();

        const data = chartData[campus] || Array(12).fill(0);

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: campus + ' ({{ $year ?? now()->year }})',
                        data: data,
                        borderColor: 'rgba(0, 168, 120, 1)',
                        backgroundColor: 'rgba(0, 168, 120, .15)',
                        tension: 0.35,
                        pointRadius: 3,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                animation: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });
    }

    // fill dropdown from PHP keys (so it always matches DB)
    const campusNames = Object.keys(chartData);
    if (campusNames.length) {
        // clear existing options
        select.innerHTML = '';
        campusNames.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = c;
            select.appendChild(opt);
        });

        // render first campus
        render(campusNames[0]);
    } else {
        // no data → still render zeros
        render('(No data)');
    }

    // change handler
    select.addEventListener('change', function () {
        render(this.value);
    });
})();
</script>
@endpush
