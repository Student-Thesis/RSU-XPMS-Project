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
            <div class="full graph_head d-flex justify-content-between align-items-center gap-2">
                <div class="heading1 margin_0">
                    <h2>Monthly Trends (Dummy Data)</h2>
                </div>

                {{-- Dropdown filter --}}
                <div class="dropdown" style="position: relative;">
                    <button class="btn btn-sm btn-outline-secondary" id="chartFilterBtn" type="button">
                        <i class="fa fa-filter"></i> Filter Colleges/Campuses
                    </button>
                    <div id="chartFilterMenu"
                         style="display:none; position:absolute; right:0; top:110%; z-index:999;
                                background:#fff; border:1px solid #ddd; border-radius:6px;
                                width:260px; max-height:280px; overflow-y:auto; box-shadow:0 10px 25px rgba(0,0,0,.08);">
                        <div style="padding:.5rem .75rem; border-bottom:1px solid #eee; display:flex; justify-content:space-between; align-items:center;">
                            <strong style="font-size:.8rem;">COLLEGE / CAMPUS</strong>
                            <a href="javascript:void(0)" id="chartSelectAll" style="font-size:.7rem;">Select all</a>
                        </div>
                        <div id="chartFilterList" style="padding:.5rem .75rem .75rem;">
                            {{-- items will be injected via JS --}}
                        </div>
                        <div style="padding:.5rem .75rem; border-top:1px solid #eee; text-align:right;">
                            <button class="btn btn-sm btn-success" id="chartFilterApply">OK</button>
                        </div>
                    </div>
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
    const ctx = document.getElementById('canvas').getContext('2d');
    let chartInstance = null;

    const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    const campuses = [
        '(Blanks)','CAFES','Cajidiocan Campus','Calatrava Campus','CAS','CBA','CCMADI',
        'CED','CET','GEPS','Sta. Maria Campus','Santa Fe Campus',
        'San Andres Campus','San Agustin Campus','Romblon Campus','San Fernando Campus'
    ];

    const colors = [
        '#2563eb','#dc2626','#16a34a','#ca8a04','#7c3aed','#db2777',
        '#0d9488','#0284c7','#f97316','#0891b2','#9333ea','#e11d48',
        '#22c55e','#b91c1c','#3b82f6','#6366f1'
    ];

    function randomData() {
        return Array.from({length: 12}, () => Math.floor(Math.random() * 46) + 5);
    }

    const chartData = {};
    campuses.forEach(name => chartData[name] = randomData());

    const allDatasets = campuses.map((name, i) => ({
        key: name,
        dataset: {
            label: name,
            data: chartData[name],
            fill: false,
            borderColor: colors[i % colors.length],
            tension: 0.25,
        }
    }));

    let selectedKeys = [...campuses];

    /** 🧩 Render chart safely (destroy old one first) */
    function renderChart() {
        if (chartInstance) {
            chartInstance.destroy(); // ✅ properly remove old chart from memory
        }

        const activeDatasets = allDatasets
            .filter(d => selectedKeys.includes(d.key))
            .map(d => d.dataset);

        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: activeDatasets
            },
            options: {
                responsive: true,
                animation: false, // avoid flicker delay
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
    }

    // 🧩 Initialize chart once DOM is ready
    renderChart();

    // 🧩 Build filter dropdown dynamically
    const listEl = document.getElementById('chartFilterList');
    listEl.innerHTML = campuses.map((name) => `
        <label style="display:flex;gap:.5rem;align-items:center;margin-bottom:.35rem;font-size:.8rem;cursor:pointer;">
            <input type="checkbox" class="chart-filter-item" value="${name}" checked />
            <span>${name}</span>
        </label>
    `).join('');

    const btn = document.getElementById('chartFilterBtn');
    const menu = document.getElementById('chartFilterMenu');

    btn.addEventListener('click', () => {
        menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
    });

    document.getElementById('chartSelectAll').addEventListener('click', () => {
        document.querySelectorAll('.chart-filter-item').forEach(cb => cb.checked = true);
    });

    document.getElementById('chartFilterApply').addEventListener('click', () => {
        selectedKeys = Array.from(document.querySelectorAll('.chart-filter-item'))
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        renderChart(); // ✅ re-render from scratch, no ghost hover issue
        menu.style.display = 'none';
    });

    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target) && !btn.contains(e.target)) {
            menu.style.display = 'none';
        }
    });
})();
</script>
@endpush