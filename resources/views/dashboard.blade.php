@extends('layouts.app')

@section('content')
    @php
        /**
         * ✅ Make sure these exist to avoid undefined errors
         */
        $kpi = $kpi ?? [];
        $chart = $chart ?? [];
        $year = $year ?? now()->year;

        // ✅ FIX: define metric labels here (so @json($metricLabels) works)
        $metricLabels = $metricLabels ?? [
            ['NO. OF', 'FACULTY', 'INVOLVED', 'IN EXTENSION', '(60% = 173)'],
            ['NO. OF', 'IEC MATERIALS', 'DEVELOPED', '(25)'],
            ['NO. OF', 'IEC MATERIALS', 'REPRODUCED', '(600)'],
            ['NO. OF', 'IEC MATERIALS', 'DISTRIBUTED', '(600)'],
            ['NO. OF', 'QUALITY', 'EXTENSION', 'PROPOSALS', 'APPROVED', '(13)'],
            ['NO. OF', 'QUALITY', 'EXTENSION', 'PROPOSALS', 'IMPLEMENTED', '(13)'],
            ['NO. OF', 'QUALITY', 'EXTENSION', 'PROPOSALS', 'DOCUMENTED', '(13)'],
            ['NO. OF', 'COMMUNITY', 'POPULATION', 'SERVED', '(5,939)'],
            ['NO. OF', 'BENEFICIARIES', 'OF TECHNICAL', 'ASSISTANCE', '(813)'],
            ['NO. OF', 'MOA / MOU', 'SIGNED', '(8)'],
        ];

        // Safe numeric getter
        $num = fn($key) => number_format((int) ($kpi[$key] ?? 0));
    @endphp

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            {{-- ✅ MAIN GRID --}}
            <div class="row g-3">

                {{-- ✅ LEFT: KPI + CHART --}}
                <div class="col-12 col-lg-8">

                    {{-- KPI CARDS --}}
                    {{-- KPI CARDS (clickable -> go to faculties page and highlight columns) --}}
                    <div class="row g-3 text-center">

                        @php
                            // DO NOT name this $kpi (to avoid closure conflict)
                            $num = function (string $key, int $decimals = 0) use ($kpi) {
                                $value = (float) data_get($kpi, $key, 0);
                                return number_format($value, $decimals, '.', ',');
                            };
                        @endphp


                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'involved_extension']) }}" class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">Involved in <br>Extension</div>
                                    <div class="card-body">
                                        <p>{{ $num('involved_extension_total', 2) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'iec_developed']) }}" class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">IEC <br>Developed</div>
                                    <div class="card-body">
                                        <p>{{ $num('iec_developed_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'iec_reproduced']) }}" class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">IEC <br>Reproduced</div>
                                    <div class="card-body">
                                        <p>{{ $num('iec_reproduced_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'iec_distributed']) }}" class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">IEC <br>Distributed</div>
                                    <div class="card-body">
                                        <p>{{ $num('iec_distributed_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'proposals_approved']) }}" class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">Proposals <br>Approved</div>
                                    <div class="card-body">
                                        <p>{{ $num('proposals_approved_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Row 2 --}}
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'proposals_implemented']) }}"
                                class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of Quality Extension <br>Proposals Implemented
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $num('proposals_implemented_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'proposals_documented']) }}" class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of Quality Extension <br>Proposals Documented
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $num('proposals_documented_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'community_served']) }}" class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of Community <br>Population Served
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $num('population_served_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'beneficiaries_assistance']) }}"
                                class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of Beneficiaries of <br>Technical Assistance
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $num('beneficiaries_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2-4">
                            <a href="{{ route('faculties.index', ['focus' => 'moa_mou']) }}" class="kpi-link">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of <br>MOA/MOU Signed
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $num('moa_mou_total') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <style>
                        .kpi-link {
                            text-decoration: none;
                            color: inherit;
                            display: block;
                        }

                        .kpi-link:hover .kpi-card {
                            box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
                            transform: translateY(-1px);
                            transition: .15s;
                        }
                    </style>


                    {{-- CHART CARD --}}
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="graph_head">
                                <h4 class="kpi-title mb-2">KPI Summary by Campus ({{ $year }})</h4>
                                <div class="p-2 small text-muted">Events loaded: {{ ($upcomingEvents ?? collect())->count() }}</div>


                                <div class="row align-items-center g-2">
                                    <div class="col-md-5 col-sm-12">
                                        <select id="campusSelect" class="form-control form-control-sm">
                                            <option value="__all__" selected>All Campuses</option>
                                            @foreach (array_keys($chart ?? []) as $campusName)
                                                <option value="{{ $campusName }}">{{ $campusName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <div class="chart-type-options d-flex flex-wrap align-items-center">
                                            <span class="label-text me-2">Chart type:</span>

                                            <input id="ct-line" type="radio" name="chartType" value="line"
                                                class="ct-radio">
                                            <label for="ct-line" class="radio-clean ms-3 me-2">
                                                <span class="radio-ui"></span>
                                                <span class="radio-text">Line</span>
                                            </label> &nbsp &nbsp

                                            <input id="ct-bar" type="radio" name="chartType" value="bar"
                                                class="ct-radio" checked>
                                            <label for="ct-bar" class="radio-clean ms-3 me-2">
                                                <span class="radio-ui"></span>
                                                <span class="radio-text">Bar</span>
                                            </label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="area_chart" style="height: 450px;">
                                <canvas id="monthlyTrendsChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ✅ RIGHT: Upcoming Events --}}
                <div class="col-12 col-lg-4">
                    <div class="card card-info h-100">
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <i class="bi bi-calendar-event me-1"></i>
                                Upcoming Events (7 days)
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            @if (($upcomingEvents ?? collect())->isEmpty())
                                <p class="text-muted p-3 mb-0">
                                    No upcoming events in the next 7 days.
                                </p>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach ($upcomingEvents as $event)
                                        <li class="list-group-item d-flex flex-column">
                                            {{-- Title --}}
                                            <div class="fw-semibold">
                                                {{ $event->title }}
                                            </div>

                                            {{-- ✅ Description (new) --}}
                                            @if (!empty($event->description))
                                                <div class="small text-muted mt-1">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 120) }}
                                                </div>
                                            @endif

                                            {{-- Date --}}
                                            <div class="small text-muted mt-1">
                                                @php
                                                    $start = \Carbon\Carbon::parse($event->start_date);
                                                    $end = $event->end_date
                                                        ? \Carbon\Carbon::parse($event->end_date)
                                                        : null;
                                                @endphp

                                                <i class="bi bi-clock"></i>
                                                {{ $start->format('M d, Y') }}
                                                @if ($end && $end->toDateString() !== $start->toDateString())
                                                    – {{ $end->format('M d, Y') }}
                                                @endif
                                            </div>

                                            {{-- Location --}}
                                            @if ($event->location)
                                                <div class="small">
                                                    <i class="bi bi-geo-alt"></i>
                                                    {{ $event->location }}
                                                </div>
                                            @endif

                                            {{-- Badges --}}
                                            <div class="mt-1">
                                                @if ($event->visibility === 'private')
                                                    <span class="badge bg-secondary">Private</span>
                                                @else
                                                    <span class="badge bg-success">Public</span>
                                                @endif

                                                @if ($event->priority)
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $event->priority }}
                                                    </span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            {{-- STYLES --}}
            <style>
                /* 5 columns on large screens */
                @media (min-width: 992px) {
                    .col-lg-2-4 {
                        flex: 0 0 auto;
                        width: 20%;
                    }
                }

                .kpi-card {
                    border-radius: 8px;
                }

                .kpi-card .card-body p {
                    font-size: clamp(22px, 3.2vw, 38px);
                    font-weight: 700;
                    margin: 0;
                }

                .kpi-card .card-header {
                    font-weight: 600;
                    font-size: clamp(12px, 1.2vw, 14px);
                    line-height: 1.2;
                }

                .graph_head .kpi-title {
                    font-size: 1.2rem;
                    font-weight: 700;
                    margin-bottom: .25rem;
                    line-height: 1.2;
                }

                .graph_head .label-text {
                    font-size: .85rem;
                    color: #666;
                }

                .area_chart {
                    min-height: 200px;
                }

                .counter_section,
                .counter_section .full,
                .counter_section .counter_no,
                .counter_section .couter_icon {
                    box-shadow: none !important;
                    border: none !important;
                    background: transparent !important;
                }

                /* ================================
               ADMINLTE HARD OVERRIDE
               Remove ANY default/pseudo radios
            ================================ */

                /* hide the real radio no matter what AdminLTE does */
                .chart-type-options .ct-radio {
                    display: none !important;
                }

                /* AdminLTE/Bootstrap sometimes draws radios via label::before/::after */
                .chart-type-options .radio-clean::before,
                .chart-type-options .radio-clean::after {
                    content: none !important;
                    display: none !important;
                }

                /* rebuild label layout */
                .chart-type-options .radio-clean {
                    display: inline-flex !important;
                    align-items: center !important;
                    gap: 6px !important;
                    cursor: pointer !important;
                    user-select: none !important;
                    font-size: .9rem !important;
                    margin: 0 !important;
                }

                /* outer ring (unchecked = white inside) */
                .chart-type-options .radio-ui {
                    width: 16px !important;
                    height: 16px !important;
                    border: 2px solid #6c757d !important;
                    border-radius: 50% !important;
                    background: #fff !important;
                    position: relative !important;
                    box-sizing: border-box !important;
                    flex: 0 0 16px !important;
                }

                /* default: NO dot */
                .chart-type-options .radio-ui::after {
                    content: none !important;
                }

                /* checked: show DARK dot (input is before label, so use sibling selector) */
                .chart-type-options .ct-radio:checked+.radio-clean .radio-ui {
                    border-color: #212529 !important;
                }

                .chart-type-options .ct-radio:checked+.radio-clean .radio-ui::after {
                    content: '' !important;
                    width: 8px !important;
                    height: 8px !important;
                    background: #212529 !important;
                    border-radius: 50% !important;
                    position: absolute !important;
                    top: 50% !important;
                    left: 50% !important;
                    transform: translate(-50%, -50%) !important;
                }
            </style>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartData = @json($chart); // { campus: [values...] }
        const metricLabels = @json($metricLabels); // multi-line labels
        const campuses = Object.keys(chartData || {});

        const colors = [
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(199, 199, 199, 0.7)',
            'rgba(0, 128, 0, 0.7)',
            'rgba(128, 0, 128, 0.7)',
            'rgba(0, 0, 128, 0.7)',
            'rgba(128, 128, 0, 0.7)',
            'rgba(0, 128, 128, 0.7)',
        ];
        const borderColors = colors.map(c => c.replace('0.7', '1'));

        const baseBackgroundColor = colors[0];
        const baseBorderColor = borderColors[0];

        const campusSelect = document.getElementById('campusSelect');
        const chartTypeRadios = document.querySelectorAll('input[name="chartType"]');
        const canvas = document.getElementById('monthlyTrendsChart');

        function getSelectedCampus() {
            return campusSelect ? campusSelect.value : '__all__';
        }

        function getSelectedChartType() {
            const checked = document.querySelector('input[name="chartType"]:checked');
            return checked ? checked.value : 'bar';
        }

        // ✅ OPTION B: yMax = (round up to next 100) + 100
        function computeYMaxRoundedPlus100(datasets) {
            const values = (datasets || [])
                .map(d => d.data || [])
                .flat()
                .map(v => Number(v))
                .filter(v => Number.isFinite(v));

            const maxVal = values.length ? Math.max(...values) : 0;
            const roundedUp = Math.ceil(maxVal / 100) * 100;
            return roundedUp + 100;
        }

        function applyDynamicYAxis(chart) {
            const newMax = computeYMaxRoundedPlus100(chart.data.datasets || []);
            chart.options.scales.y.max = newMax;
            chart.options.scales.y.ticks.stepSize = 100;
        }

        function buildDatasets(selection, chartType) {
            // ALL CAMPUSES
            if (selection === '__all__') {
                const typeForAll = (chartType === 'line') ? 'line' : 'bar';

                return campuses.map((campus, index) => {
                    const data = chartData[campus] || [];
                    const ds = {
                        label: campus,
                        data,
                        type: typeForAll,
                        backgroundColor: colors[index % colors.length],
                        borderColor: borderColors[index % borderColors.length],
                        borderWidth: 1,
                    };

                    if (typeForAll === 'line') {
                        ds.fill = false;
                        ds.tension = 0.2;
                        ds.pointRadius = 3;
                    }
                    return ds;
                });
            }

            // SINGLE CAMPUS
            const data = chartData[selection] || [];
            const ds = {
                label: selection,
                data,
                type: (chartType === 'line') ? 'line' : 'bar',
                backgroundColor: baseBackgroundColor,
                borderColor: baseBorderColor,
                borderWidth: 1,
            };

            if (chartType === 'line') {
                ds.fill = false;
                ds.tension = 0.2;
                ds.pointRadius = 3;
            }

            return [ds];
        }

        if (canvas) {
            const ctx = canvas.getContext('2d');

            const initialSelection = getSelectedCampus();
            const initialType = getSelectedChartType();
            const initialBaseType = (initialType === 'line') ? 'line' : 'bar';

            let campusChart = new Chart(ctx, {
                type: initialBaseType,
                data: {
                    labels: metricLabels,
                    datasets: buildDatasets(initialSelection, initialType),
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            min: 0,
                            ticks: {
                                stepSize: 100,
                                autoSkip: false,
                                padding: 8
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                title: function(items) {
                                    const label = items[0].label;
                                    if (Array.isArray(label)) return label.join(' ');
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            applyDynamicYAxis(campusChart);
            campusChart.update();

            if (campusSelect) {
                campusSelect.addEventListener('change', function() {
                    const selection = getSelectedCampus();
                    const type = getSelectedChartType();
                    const baseType = (type === 'line') ? 'line' : 'bar';

                    campusChart.config.type = baseType;
                    campusChart.data.datasets = buildDatasets(selection, type);

                    applyDynamicYAxis(campusChart);
                    campusChart.update();
                });
            }

            chartTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const selection = getSelectedCampus();
                    const type = getSelectedChartType();
                    const baseType = (type === 'line') ? 'line' : 'bar';

                    campusChart.config.type = baseType;
                    campusChart.data.datasets = buildDatasets(selection, type);

                    applyDynamicYAxis(campusChart);
                    campusChart.update();
                });
            });
        }
    </script>
@endpush
