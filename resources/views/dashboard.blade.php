@extends('layouts.app')

@section('content')
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

            <div id="content">
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        {{-- KPI CARDS --}}
                        <div class="row text-center">

                            <!-- 1 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">Involved in </br>Extension</div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['involved_extension_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 2 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">IEC </br>Developed</div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['iec_developed_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 3 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">IEC </br>Reproduced</div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['iec_reproduced_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 4 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">IEC </br> Distributed</div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['iec_distributed_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 5 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header">Proposals </br>Approved</div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['proposals_approved_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row text-center mt-4">

                            <!-- 1 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of Quality Extension </br>Proposals Implemented
                                    </div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['proposals_implemented_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 2 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of Quality Extension </br>Proposals Documented
                                    </div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['proposals_documented_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 3 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of Community </br>Population Served
                                    </div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['population_served_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 4 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of Beneficiaries of </br>Technical Assistance
                                    </div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['beneficiaries_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 5 -->
                            <div class="kpi-col mb-3">
                                <div class="card kpi-card h-100">
                                    <div class="card-header text-uppercase">
                                        No. of </br>MOA/MOU Signed
                                    </div>
                                    <div class="card-body">
                                        <p>{{ number_format($kpi['moa_mou_total']) }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <style>
                            .kpi-col {
                                width: 20%;
                                padding-left: 0 !important;
                                padding-right: 0 !important;
                            }

                            .kpi-card {
                                margin: 6px;
                                border-radius: 8px;
                            }

                            .kpi-card .card-body p {
                                font-size: 38px;
                                font-weight: 700;
                                margin: 0;
                            }
                        </style>

                        {{-- METRIC LABELS (for chart) --}}
                        @php
                            $metricLabels = [
                                ['NO. OF', 'FACULTY', 'INVOLVED', 'IN EXTENSION', '(60% = 173)'],
                                ['NO. OF', 'IEC MATERIALS', 'DEVELOPED', '(25)'],
                                ['NO. OF', 'IEC MATERIALS', 'REPRODUCED', '(600)'],
                                ['NO. OF', 'IEC MATERIALS', 'DISTRIBUTED', '(600)'],
                                ['NO. OF', 'QUALITY', 'EXTENSION', 'PROPOSALS', 'APPROVED', '(13)'],
                                ['NO. OF', 'QUALITY', ' EXTENSION', 'PROPOSALS', 'IMPLEMENTED', '(13)'],
                                ['NO. OF', 'QUALITY', ' EXTENSION', 'PROPOSALS', 'DOCUMENTED', '(13)'],
                                ['NO. OF', 'COMMUNITY', 'POPULATION', 'SERVED', '(5,939)'],
                                ['NO. OF', 'BENEFICIARIES', 'OF TECHNICAL', 'ASSISTANCE', '(813)'],
                                ['NO. OF', 'MOA / MOU', 'SIGNED', '(8)'],
                            ];
                        @endphp

                        {{-- CHART --}}
                        <div class="row column2 graph margin_bottom_30">
                            <div class="col-md-12 col-lg-12">
                                <div class="white_shd full">
                                    <style>
                                        .graph_head { margin-bottom: 1rem; }
                                        .graph_head .kpi-title {
                                            font-size: 1.4rem;
                                            font-weight: 700;
                                            margin-bottom: .5rem;
                                            line-height: 1.2;
                                        }
                                        .graph_head label,
                                        .graph_head span.label-text {
                                            font-size: .8rem;
                                            color: #666;
                                        }
                                        .graph_head .form-control-sm { max-width: 230px; }
                                        .graph_head .chart-type-options label {
                                            font-size: .8rem;
                                            margin-bottom: 0;
                                        }
                                    </style>

                                    <div class="full graph_head">
                                        <h4 class="kpi-title mb-3">KPI Summary by Campus ({{ $year }})</h4>

                                        <div class="row align-items-center g-2">
                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <select id="campusSelect" class="form-control form-control-sm">
                                                    <option value="__all__" selected>All Campuses</option>
                                                    @foreach (array_keys($chart ?? []) as $campusName)
                                                        <option value="{{ $campusName }}">{{ $campusName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <div class="chart-type-options d-flex flex-wrap align-items-center">
                                                    <span class="label-text me-2 mr-2">Chart type:</span>

                                                    <label class="d-flex align-items-center ms-3 mr-2">
                                                        <input type="radio" name="chartType" value="line" class="me-2">
                                                        <span>&nbsp Line</span>
                                                    </label>

                                                    <label class="d-flex align-items-center ms-3 mr-2">
                                                        <input type="radio" name="chartType" value="bar" class="me-1" checked>
                                                        <span>&nbsp Bar</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="full graph_revenue">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content">
                                                    <div class="area_chart" style="height: 450px;">
                                                        <canvas id="monthlyTrendsChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /graph_revenue -->
                                </div>
                            </div>
                        </div>
                        <!-- end graph -->
                    </div>

                    {{-- UPCOMING EVENTS (next 7 days) --}}
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title mb-0">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    Upcoming Events (7 days)
                                </h3>
                            </div>
                            <div class="card-body p-0">
                                @if ($upcomingEvents->isEmpty())
                                    <p class="text-muted p-3 mb-0">
                                        No upcoming events in the next 7 days.
                                    </p>
                                @else
                                    <ul class="list-group list-group-flush">
                                        @foreach ($upcomingEvents as $event)
                                            <li class="list-group-item d-flex flex-column">
                                                <div class="fw-semibold">
                                                    {{ $event->title }}
                                                </div>

                                                <div class="small text-muted">
                                                    @php
                                                        $start = \Carbon\Carbon::parse($event->start_date);
                                                        $end = $event->end_date ? \Carbon\Carbon::parse($event->end_date) : null;
                                                    @endphp

                                                    <i class="bi bi-clock"></i>
                                                    {{ $start->format('M d, Y') }}
                                                    @if ($end && $end->toDateString() !== $start->toDateString())
                                                        – {{ $end->format('M d, Y') }}
                                                    @endif
                                                </div>

                                                @if ($event->location)
                                                    <div class="small">
                                                        <i class="bi bi-geo-alt"></i>
                                                        {{ $event->location }}
                                                    </div>
                                                @endif

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
            </div>

            <style>
                .counter_section { box-shadow: none !important; border: none !important; background: transparent !important; }
                .counter_section .full { box-shadow: none !important; border: none !important; background: transparent !important; }
                .counter_section .counter_no,
                .counter_section .couter_icon { background: transparent !important; box-shadow: none !important; border: none !important; }
                .margin_bottom_30 { margin-bottom: 30px; }

                /* Ensure the chart area has enough vertical space */
                .area_chart { min-height: 200px; }
            </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartData = @json($chart); // { campus: [values...] }
        const metricLabels = @json($metricLabels); // multi-line labels
        const campuses = Object.keys(chartData);

        // Color palette for campuses
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

        // Single-campus base color
        const baseBackgroundColor = colors[0];
        const baseBorderColor = borderColors[0];

        const campusSelect = document.getElementById('campusSelect');
        const chartTypeRadios = document.querySelectorAll('input[name="chartType"]');
        const ctx = document.getElementById('monthlyTrendsChart').getContext('2d');

        function getSelectedCampus() {
            return campusSelect.value; // "__all__" or campus name
        }

        function getSelectedChartType() {
            const checked = document.querySelector('input[name="chartType"]:checked');
            return checked ? checked.value : 'bar';
        }

        /**
         * ✅ OPTION B: yMax = (round up to next 100) + 100
         * Examples:
         * - max=100  -> 200
         * - max=101  -> 300
         * - max=999  -> 1100
         */
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
            chart.options.scales.y.ticks.stepSize = 100; // keep ticks clean
        }

        /**
         * Build datasets depending on selection:
         * - "__all__"  => all campuses, each with its own color
         * - campusName => single campus (bar / line)
         */
        function buildDatasets(selection, chartType) {
            // 🔹 ALL CAMPUSES
            if (selection === '__all__') {
                const typeForAll = (chartType === 'line') ? 'line' : 'bar';

                return campuses.map((campus, index) => {
                    const data = chartData[campus] || [];
                    const ds = {
                        label: campus,
                        data: data,
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

            // 🔹 SINGLE CAMPUS
            const data = chartData[selection] || [];

            const datasets = [{
                label: selection + ' (Bar)',
                data: data,
                type: 'bar',
                backgroundColor: baseBackgroundColor,
                borderColor: baseBorderColor,
                borderWidth: 1,
            }];

            if (chartType === 'line') {
                datasets[0].type = 'line';
                datasets[0].label = selection + ' (Line)';
                datasets[0].fill = false;
                datasets[0].tension = 0.2;
                datasets[0].pointRadius = 3;
            }

            return datasets;
        }

        const initialSelection = getSelectedCampus(); // "__all__"
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
                    intersect: false,
                },
                scales: {
                    x: {
                        stacked: false,
                        ticks: { autoSkip: false }
                    },
                    y: {
                        beginAtZero: true,
                        min: 0,
                        // ✅ removed fixed max: 1000
                        ticks: {
                            stepSize: 100,
                            autoSkip: false,
                            padding: 8,
                            callback: v => v
                        },
                        title: {
                            display: true,
                            text: 'Counts'
                        }
                    }
                },
                plugins: {
                    legend: { position: 'top' },
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

        // ✅ set dynamic max on first render
        applyDynamicYAxis(campusChart);
        campusChart.update();

        campusSelect.addEventListener('change', function() {
            const selection = getSelectedCampus();
            const type = getSelectedChartType();
            const baseType = (type === 'line') ? 'line' : 'bar';

            campusChart.config.type = baseType;
            campusChart.data.datasets = buildDatasets(selection, type);

            // ✅ recompute max per selection
            applyDynamicYAxis(campusChart);
            campusChart.update();
        });

        chartTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const selection = getSelectedCampus();
                const type = getSelectedChartType();
                const baseType = (type === 'line') ? 'line' : 'bar';

                campusChart.config.type = baseType;
                campusChart.data.datasets = buildDatasets(selection, type);

                // ✅ recompute max per type
                applyDynamicYAxis(campusChart);
                campusChart.update();
            });
        });
    </script>
@endpush
