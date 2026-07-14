@extends('layouts.admin.app')

@section('title', 'ABC Result')

@section('content')

<div class="container-fluid py-4">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                    <i class="fa-solid fa-brain text-primary fs-3"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">Artificial Bee Colony Result</h2>
                                    <p class="text-muted mb-0">
                                        Optimization result of KPI weight using the <strong>Artificial Bee Colony
                                            (ABC)</strong> algorithm.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('abc.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fa-solid fa-arrow-left me-2"></i>Back to Optimization
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- SUMMARY CARD --}}
    {{-- ========================================================= --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fa-solid fa-calendar-days text-primary fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Period</small>
                            <h5 class="fw-bold mb-0">{{ $result->period->name }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded bg-success bg-opacity-10 p-3 me-3">
                            <i class="fa-solid fa-trophy text-success fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Best Fitness</small>
                            <h4 class="fw-bold text-success mb-0">{{ number_format($result->fitness, 8) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fa-solid fa-repeat text-warning fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Max Iteration</small>
                            <h4 class="fw-bold mb-0">{{ number_format($result->max_iteration) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded bg-info bg-opacity-10 p-3 me-3">
                            <i class="fa-solid fa-stopwatch text-info fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Execution Time</small>
                            <h4 class="fw-bold mb-0">
                                {{ number_format($result->execution_time, 2) }} <small
                                    class="text-muted fs-6">ms</small>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- PARAMETERS & KPI TABLE --}}
    {{-- ========================================================= --}}
    <div class="row mb-4">
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-sliders text-primary me-2"></i>
                        <h5 class="fw-bold mb-0">Optimization Parameters</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr class="border-bottom border-light">
                                <td class="ps-4 py-3 fw-semibold">Population Size</td>
                                <td class="text-end pe-4"><span class="badge bg-primary">{{ $result->population_size
                                        }}</span></td>
                            </tr>
                            <tr class="border-bottom border-light">
                                <td class="ps-4 py-3 fw-semibold">Maximum Iteration</td>
                                <td class="text-end pe-4"><span class="badge bg-warning text-dark">{{
                                        $result->max_iteration }}</span></td>
                            </tr>
                            <tr class="border-bottom border-light">
                                <td class="ps-4 py-3 fw-semibold">Limit Trial</td>
                                <td class="text-end pe-4"><span class="badge bg-secondary">{{ $result->limit_trial
                                        }}</span></td>
                            </tr>
                            <tr class="border-bottom border-light">
                                <td class="ps-4 py-3 fw-semibold">Execution Time</td>
                                <td class="text-end pe-4"><span class="badge bg-info">{{
                                        number_format($result->execution_time, 2) }} ms</span></td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-bold">Best Fitness</td>
                                <td class="text-end pe-4"><span class="badge bg-success fs-7">{{
                                        number_format($result->fitness, 8) }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-chart-column text-success me-2"></i>
                            <h5 class="fw-bold mb-0">Best KPI Weight Distribution</h5>
                        </div>
                        <span class="badge bg-success">{{ $result->details->count() }} Indicators</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @php($total = 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>KPI Indicator</th>
                                    <th width="180" class="text-end">Weight</th>
                                    <th width="170" class="text-end">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result->details as $detail)
                                @php($total += $detail->weight)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $detail->kpiMaster->name ?? 'Unknown' }}</td>
                                    <td class="text-end">{{ number_format($detail->weight, 10) }}</td>
                                    <td class="text-end"><span class="badge bg-success fs-6">{{
                                            number_format($detail->weight * 100, 2) }}%</span>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="2"><i class="fa-solid fa-calculator me-2 text-success"></i>Total Weight
                                    </th>
                                    <th class="text-end text-success fw-bold font-monospace">{{ number_format($total,
                                        10) }}</th>
                                    <th class="text-end"><span class="badge bg-success fs-6">{{ number_format($total *
                                            100, 2) }}%</span></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- VISUAL ANALYTICS --}}
    {{-- ========================================================= --}}
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-chart-bar text-primary me-2"></i>
                        <h5 class="fw-bold mb-0">KPI Weight Distribution Bar</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div style="height:400px; position: relative;">
                        <canvas id="weightChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-chart-pie text-success me-2"></i>
                        <h5 class="fw-bold mb-0">Percentage Distribution</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div style="height:400px; position: relative;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    
    // Perbaikan Parsing Data JSON (Satu baris lurus mencegah break character script)
    const labels = {!! json_encode($result->details->map(function($d) { return $d->kpiMaster->name ?? 'Unknown'; })->values()) !!};
    const weights = {!! json_encode($result->details->pluck('weight')->values()) !!};

    // Generator warna palet dinamis untuk chart agar berwarna kontras
    const colors = labels.map((_, i) => `hsla(${(i * (360 / labels.length)) % 360}, 70%, 60%, 0.85)`);
    const borderColors = labels.map((_, i) => `hsla(${(i * (360 / labels.length)) % 360}, 70%, 45%,  1)`);

    // ==========================================================
    // BAR CHART
    // ==========================================================
    const weightChart = new Chart(
        document.getElementById('weightChart'),
        {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'KPI Weight',
                    data: weights,
                    backgroundColor: colors,
                    borderColor: borderColors,
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label(context) {
                                return ` Weight : ${context.raw.toFixed(8)} (${(context.raw * 100).toFixed(2)}%)`;
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        // max: 1, // Dihapus/dikomentari agar scale menyesuaikan nilai bobot mikro secara otomatis
                        ticks: {
                            callback(value) {
                                return (value * 100).toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        }
    );

    // ==========================================================
    // DOUGHNUT CHART
    // ==========================================================
    const pieChart = new Chart(
        document.getElementById('pieChart'),
        {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: weights,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    hoverOffset: 10,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                animation: {
                    animateRotate: true,
                    animateScale: true
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            boxWidth: 8,
                            font: { size: 11 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label(context) {
                                return ` ${context.label}: ${(context.raw * 100).toFixed(2)}%`;
                            }
                        }
                    }
                }
            }
        }
    );
});
</script>
@endpush