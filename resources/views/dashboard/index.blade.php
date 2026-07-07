@extends('layouts.admin.app')

@push('styles')
<style>
    /* ===== MODERN STAT CARD ===== */
    .stat-card {
        border-radius: 18px;
        color: #fff;
        padding: 22px;
        position: relative;
        overflow: hidden;
    }

    .stat-label {
        font-size: 18px;
        font-weight: 500;
        opacity: .85;
        margin-bottom: 8px;
        letter-spacing: .3px;
    }

    .stat-number {
        font-size: 30px;
        font-weight: 700;
    }

    /* soft shadow lebih modern */
    .shadow-soft {
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
    }

    /* ===== DASHBOARD CARD ===== */
    .dashboard-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
    }

    /* header card modern */
    .card-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* ===== TABLE MODERN ===== */
    .table-modern {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-modern tr {
        background: #f8fafc;
        border-radius: 12px;
    }

    .table-modern td {
        padding: 12px;
        border: none;
    }

    .badge-soft {
        background: #e2e8f0;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
    }

    /* ===== CHART ===== */
    .chart-container {
        height: 380px;
        position: relative;
    }
</style>
@endpush
@section('content')

<div class="row g-4">

    <!-- STAT CARDS -->
    <div class="col-md-3">
        <div class="stat-card bg-blue shadow-soft">
            <div class="stat-label">Total Employees</div>
            <div class="stat-number">245</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-green shadow-soft">
            <div class="stat-label">Excellent KPI</div>
            <div class="stat-number">78</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-orange shadow-soft">
            <div class="stat-label">Average KPI</div>
            <div class="stat-number">121</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-purple shadow-soft">
            <div class="stat-label">Need Improvement</div>
            <div class="stat-number">46</div>
        </div>
    </div>

</div>


<div class="row mt-4 g-4">

    <!-- CHART -->
    <div class="col-lg-8">
        <div class="dashboard-card h-100">

            <div class="card-header-modern">
                <div>
                    <h5 class="mb-0">KPI Performance Overview</h5>
                    <small class="text-muted">Monthly performance trend</small>
                </div>
            </div>

            <div class="chart-container mt-3">
                <canvas id="kpiChart"></canvas>
            </div>

        </div>
    </div>

    <!-- TABLE -->
    <div class="col-lg-4">
        <div class="dashboard-card h-100">

            <div class="card-header-modern">
                <div>
                    <h5 class="mb-0">Top Employees</h5>
                    <small class="text-muted">Highest KPI score</small>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-modern">
                    <tbody>
                        <tr>
                            <td><span class="badge-soft">EMP001</span></td>
                            <td>John Doe</td>
                            <td class="text-end"><strong>98%</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge-soft">EMP002</span></td>
                            <td>Jane Smith</td>
                            <td class="text-end"><strong>96%</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge-soft">EMP003</span></td>
                            <td>Michael</td>
                            <td class="text-end"><strong>95%</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('kpiChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'KPI Score',
            data: [65, 72, 80, 75, 88, 92],
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37,99,235,.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush