@extends('layouts.admin.app')

@section('title','HR Dashboard')

@push('styles')
<style>
    .stat-card {

        display: flex;

        justify-content: space-between;

        align-items: center;

        padding: 25px;

        border-radius: 18px;

        color: #fff;

        overflow: hidden;

        position: relative;

        transition: .35s;

        box-shadow: 0 12px 25px rgba(0, 0, 0, .15);

    }

    .stat-card:hover {

        transform: translateY(-8px);

        box-shadow: 0 18px 40px rgba(0, 0, 0, .25);

    }

    .stat-card::after {

        content: '';

        position: absolute;

        width: 180px;

        height: 180px;

        background: rgba(255, 255, 255, .15);

        border-radius: 50%;

        right: -70px;

        top: -70px;

    }

    .stat-icon {

        font-size: 42px;

        opacity: .85;

    }

    .card {

        border: none;

        border-radius: 18px;

        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);

    }

    .card-header {

        background: #fff;

        font-weight: 700;

        border-bottom: 1px solid #eee;

    }

    .avatar {

        width: 50px;

        height: 50px;

        border-radius: 50%;

        background: #0d6efd;

        color: white;

        display: flex;

        align-items: center;

        justify-content: center;

        font-weight: bold;

    }

    .timeline-item {

        display: flex;

        align-items: center;

        margin-bottom: 18px;

    }

    .timeline-dot {

        width: 12px;

        height: 12px;

        border-radius: 50%;

        margin-right: 15px;

    }

    .timeline-content {

        flex: 1;

    }

    .stats-section {
        background: url('{{ asset("assets/images/yurt6.jpg") }}') center center no-repeat;
        background-size: cover;

        padding: 25px;
        border-radius: 10px;

        margin-bottom: 30px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="stats-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-people-fill text-primary me-2"></i>
                    HR Dashboard
                </h3>
                <small class="text-muted">
                    Human Resource Performance Management
                </small>
            </div>

            <div>
                <span class="badge rounded-pill bg-success px-3 py-2">
                    <i class="bi bi-calendar-check me-1"></i>
                    {{ $activePeriod->name }}
                </span>
            </div>
        </div>

        <div class="row  g-4">

            <div class="col-xl-2 col-md-4">

                <div class="stat-card bg-primary">

                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>

                    <div>

                        <small>Total Employee</small>

                        <h2>{{ $totalEmployees }}</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="stat-card bg-success">

                    <div class="stat-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>

                    <div>

                        <small>Submitted</small>

                        <h2>{{ $submitted }}</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="stat-card bg-warning">

                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>

                    <div>

                        <small>Pending</small>

                        <h2>{{ $pending }}</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="stat-card bg-info">

                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>

                    <div>

                        <small>Approved</small>

                        <h2>{{ $approved }}</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="stat-card bg-danger">

                    <div class="stat-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>

                    <div>

                        <small>Rejected</small>

                        <h2>{{ $rejected }}</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="stat-card bg-dark">

                    <div class="stat-icon">
                        <i class="fas fa-user-minus"></i>
                    </div>

                    <div>

                        <small>Not Submitted</small>

                        <h2>{{ $notSubmitted }}</h2>

                    </div>

                </div>

            </div>

        </div>
    </div>
    <div class="row mt-4">

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-building text-primary me-2"></i>
                            Department Performance
                        </h5>

                        <span class="badge bg-light text-dark">
                            {{ count($departmentPerformance) }} Departments
                        </span>

                    </div>

                </div>

                <div class="card-body pt-2">

                    @foreach($departmentPerformance as $department)

                    <div class="dept-item">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="fw-semibold">

                                    {{ $department->name }}

                                </div>

                                <small class="text-muted">

                                    {{ $department->total_employee }} Employees

                                </small>

                            </div>

                            <div class="text-end">

                                <span class="score">

                                    {{ number_format($department->average_score,1) }}

                                </span>

                            </div>

                        </div>

                        <div class="progress mt-2" style=" height: 8px;">

                            <div class="progress-bar 
                                @if($department->average_score>=90)
        
                                bg-success
        
                                @elseif($department->average_score>=75)
        
                                bg-info
        
                                @elseif($department->average_score>=60)
        
                                bg-warning
        
                                @else
        
                                bg-danger
        
                                @endif" style="width:{{ $department->average_score }}%">
                            </div>


                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>
        <div class="col-lg-6">





            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-header bg-white border-0">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-gift text-primary me-2"></i>
                            Reward Recommendation
                        </h5>

                        <span class="badge bg-light text-dark">
                            Total :
                            {{ $rewardPending + $rewardApproved + $rewardRejected }}
                        </span>

                    </div>

                </div>

                <div class="card-body">

                    <div id="rewardChart"></div>

                    <hr class="my-4">

                    <div class="table-responsive">

                        <table class="table table-sm table-borderless align-middle mb-0">

                            <thead class="text-muted">

                                <tr>

                                    <th>Status</th>

                                    <th class="text-center">Total</th>

                                    <th class="text-end">Percentage</th>

                                </tr>

                            </thead>

                            <tbody>

                                @php
                                $total = $rewardPending + $rewardApproved + $rewardRejected;
                                @endphp

                                <tr>

                                    <td>

                                        <span class="badge rounded-pill bg-warning me-2">&nbsp;</span>

                                        Pending

                                    </td>

                                    <td class="text-center fw-semibold">

                                        {{ $rewardPending }}

                                    </td>

                                    <td class="text-end">

                                        {{ $total ? number_format(($rewardPending/$total)*100,1) : 0 }}%

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <span class="badge rounded-pill bg-success me-2">&nbsp;</span>

                                        Approved

                                    </td>

                                    <td class="text-center fw-semibold">

                                        {{ $rewardApproved }}

                                    </td>

                                    <td class="text-end">

                                        {{ $total ? number_format(($rewardApproved/$total)*100,1) : 0 }}%

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <span class="badge rounded-pill bg-danger me-2">&nbsp;</span>

                                        Rejected

                                    </td>

                                    <td class="text-center fw-semibold">

                                        {{ $rewardRejected }}

                                    </td>

                                    <td class="text-end">

                                        {{ $total ? number_format(($rewardRejected/$total)*100,1) : 0 }}%

                                    </td>

                                </tr>

                            </tbody>

                            <tfoot class="border-top">

                                <tr class="fw-bold">

                                    <td>Total</td>

                                    <td class="text-center">

                                        {{ $total }}

                                    </td>

                                    <td class="text-end">

                                        100%

                                    </td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>




        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-6">

            <div class="card">

                <div class="card-header">
                    Top Performer
                </div>

                <div class="card-body">


                    @foreach($topPerformers as $index=>$item)

                    <div class="d-flex align-items-center mb-3">

                        <div class="avatar">

                            {{ strtoupper(substr($item->employee->name,0,1)) }}

                        </div>

                        <div class="ms-3 flex-grow-1">

                            <strong>{{ $item->employee->name ?? '-' }}</strong>

                            <div class="text-muted">

                                {{ $item->employee->department->name ?? '-' }}

                            </div>

                        </div>

                        <h5>

                            @if($index==0)

                            🥇

                            @elseif($index==1)

                            🥈

                            @elseif($index==2)

                            🥉

                            @endif

                            {{ number_format($item->final_score,2) }}

                        </h5>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card">

                <div class="card-header">
                    Waiting Approval
                </div>

                <div class="card-body">


                    @foreach($waitingApproval as $item)

                    <div class="timeline-item">

                        <div class="timeline-dot bg-warning"></div>

                        <div class="timeline-content">

                            <strong>{{ $item->employee->name ?? '-' }}</strong>

                            <div class="text-muted">

                                {{ $item->employee->department->name ?? '-' }}

                            </div>

                        </div>

                        <span class="badge bg-warning">

                            Waiting

                        </span>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const pending  = {{ $rewardPending }};
const approved = {{ $rewardApproved }};
const rejected = {{ $rewardRejected }};

const total = pending + approved + rejected;

const noData = total === 0;

const options = {

    chart: {
        type: 'donut',
        height: 330
    },

    series: noData
        ? [1]
        : [pending, approved, rejected],

    labels: noData
        ? ['No Data']
        : ['Pending','Approved','Rejected'],

    colors: noData
        ? ['#d6d8db']
        : ['#ffc107','#198754','#dc3545'],

    legend: {
        position: 'bottom',
        fontSize: '14px'
    },

    dataLabels: {
        enabled: !noData
    },

    tooltip: {
        enabled: !noData
    },

    plotOptions: {

        pie: {

            donut: {

                size: '72%',

                labels: {

                    show: true,

                    total: {

                        show: true,

                        label: noData ? 'No Data' : 'Total',

                        formatter: function () {
                            return noData ? '0' : total;
                        }

                    },

                    value: {
                        formatter: function(val){
                            return noData ? '' : val;
                        }
                    }

                }

            }

        }

    }

};

new ApexCharts(
    document.querySelector("#rewardChart"),
    options
).render();

</script>
@endpush