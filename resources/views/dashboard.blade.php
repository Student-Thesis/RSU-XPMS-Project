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

                {{-- KPI Row 2 (single tile you had) --}}
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
                            <div class="full graph_head">
                                <div class="heading1 margin_0">
                                    <h2>Quarterly Trends (Involved in Extension vs IEC Developed)</h2>
                                </div>
                            </div>
                            <div class="full graph_revenue">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="content">
                                            <div class="area_chart">
                                                <canvas height="120" id="canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- If you have more series later (reproduced/distributed), we can add easily --}}
                        </div>
                    </div>
                </div>
                <!-- end graph -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Chart.js CDN (lightweight) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" integrity="sha384-7l8B6hN2l8Y9v9C3kI6k1T3H2X6KQmY0eZ2E69+JdF4qzC7z1tQdY/7mQ8h1aQ5x" crossorigin="anonymous"></script>
    <script>
        (function () {
            const ctx = document.getElementById('canvas').getContext('2d');

            const labels = ['Q1','Q2','Q3','Q4'];

            const involved = @json($chart['ext']);
            const developed = @json($chart['dev']);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Involved in Extension',
                            data: involved,
                            fill: false,
                            tension: 0.25,
                        },
                        {
                            label: 'IEC Developed',
                            data: developed,
                            fill: false,
                            tension: 0.25,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    interaction: { mode: 'nearest', axis: 'x', intersect: false },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        })();
    </script>
@endpush
