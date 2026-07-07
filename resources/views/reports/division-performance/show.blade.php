@extends('layouts.admin.app')

@section('title', 'Division Performance')

@push('styles')
<style>
    .card {
        transition: .25s ease;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .75rem 1.5rem rgba(0, 0, 0, .08) !important;
    }

    .card .text-muted {
        font-size: .9rem;
    }

    .card .badge {
        font-size: .8rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="row mb-3">

        <div class="col-lg-8">

            <h3 class="fw-bold mb-1">

                {{ $department->name }}

            </h3>

            <p class="text-muted mb-0">

                Division Performance Analysis

            </p>

        </div>

        <div class="col-lg-4 text-end">

            <a href="{{ route('division-performance.index') }}" class="btn btn-secondary">

                <i class="fa fa-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>


    {{-- Summary --}}

    <div class="row">

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">

                        Total Employee

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $statistics['employee'] }}

                    </h2>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">

                        Average KPI

                    </small>

                    <h2 class="fw-bold mt-2 text-primary">

                        {{ number_format($statistics['average'],2) }}

                    </h2>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">

                        Highest Score

                    </small>

                    <h2 class="fw-bold mt-2 text-success">

                        {{ number_format($statistics['highest'],2) }}

                    </h2>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">

                        Lowest Score

                    </small>

                    <h2 class="fw-bold mt-2 text-danger">

                        {{ number_format($statistics['lowest'],2) }}

                    </h2>

                </div>

            </div>

        </div>

    </div>


    <div class="row">

        {{-- Division Information --}}

        <div class="col-lg-4">

            <div class="card border-1 shadow-sm rounded-1 h-100">

                <div class="card-header bg-white border-0 pb-0">

                    <div class="d-flex align-items-center">

                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">

                            <i class="fa fa-building text-primary"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-0">
                                Division Information
                            </h5>

                            <small class="text-muted">
                                Performance Overview
                            </small>

                        </div>

                    </div>

                </div>

                <div class="card-body pt-3">

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                        <span class="text-muted">
                            <i class="fa fa-sitemap me-2 text-secondary"></i>
                            Division
                        </span>

                        <span class="fw-semibold">
                            {{ $department->name }}
                        </span>

                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                        <span class="text-muted">
                            <i class="fa fa-users me-2 text-primary"></i>
                            Employee
                        </span>

                        <span class="badge bg-primary rounded-pill px-3">
                            {{ $statistics['employee'] }}
                        </span>

                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                        <span class="text-muted">
                            <i class="fa fa-chart-line me-2 text-info"></i>
                            Average KPI
                        </span>

                        <span class="fw-bold text-primary">
                            {{ number_format($statistics['average'],2) }}
                        </span>

                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                        <span class="text-muted">
                            <i class="fa fa-arrow-trend-up me-2 text-success"></i>
                            Highest
                        </span>

                        <span class="badge bg-success rounded-pill px-3">
                            {{ number_format($statistics['highest'],2) }}
                        </span>

                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2">

                        <span class="text-muted">
                            <i class="fa fa-arrow-trend-down me-2 text-danger"></i>
                            Lowest
                        </span>

                        <span class="badge bg-danger rounded-pill px-3">
                            {{ number_format($statistics['lowest'],2) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- KPI Distribution --}}

        <div class="col-lg-8">

            <div class="card shadow-sm border-1 rounded-1 h-100 mb-4">

                <div class="card-header bg-white text-center">

                    <h5 class="mb-0 fw-bold">

                        KPI Distribution

                    </h5>

                </div>

                <div class="card-body">


                    <div class="row">

                        <div class="col-lg-6">

                            <div class="card border-0 mb-4">

                                <div class="card-header bg-white text-center">

                                    <h5 class="mb-0 fw-bold">

                                        KPI Distribution

                                    </h5>

                                </div>

                                <div class="card-body">

                                    <canvas id="kpiBarChart" height="250"></canvas>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="card border-0 mb-4">

                                <div class="card-header bg-white text-center">

                                    <h5 class="mb-0 fw-bold">

                                        KPI Radar

                                    </h5>

                                </div>

                                <div class="card-body">

                                    <canvas id="radarChart" height="250"></canvas>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>


    {{-- Employee List --}}

    <div class="row">

        <div class="col-lg-12 mt-2">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">

                        Employee Performance

                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="employeeTable" class="table table-hover table-bordered align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th width="60" class="text-center">
                                        Rank
                                    </th>

                                    <th width="120">
                                        CODE
                                    </th>

                                    <th>
                                        Employee
                                    </th>

                                    <th width="120" class="text-center">
                                        Final Score
                                    </th>

                                    <th width="220">
                                        Performance
                                    </th>

                                    <th width="140" class="text-center">
                                        Category
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($employees as $employee)

                                @php

                                $score = (float) ($employee->final_score ?? 0);

                                if($score >= 90){

                                $badge = 'success';
                                $category = 'Excellent';

                                }elseif($score >= 80){

                                $badge = 'primary';
                                $category = 'Very Good';

                                }elseif($score >= 70){

                                $badge = 'info';
                                $category = 'Good';

                                }elseif($score >= 60){

                                $badge = 'warning';
                                $category = 'Fair';

                                }else{

                                $badge = 'danger';
                                $category = 'Poor';

                                }

                                @endphp

                                <tr>

                                    <td class="text-center fw-bold">

                                        {{ $loop->iteration }}

                                    </td>

                                    <td>

                                        {{ $employee->employee_code }}

                                    </td>

                                    <td>

                                        <strong>

                                            {{ $employee->name }}

                                        </strong>

                                    </td>

                                    <td class="text-center">

                                        <span class="fw-bold">

                                            {{ number_format($score,2) }}

                                        </span>

                                    </td>

                                    <td>

                                        <div class="progress" style="height:22px;">

                                            <div class="progress-bar bg-{{ $badge }}" role="progressbar"
                                                style="width: {{ min($score,100) }}%;">

                                                {{ number_format($score,1) }}%

                                            </div>

                                        </div>

                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-{{ $badge }}">

                                            {{ $category }}

                                        </span>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="6" class="text-center py-4 text-muted">

                                        No employee performance data found.

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        {{-- Analytics --}}
        <div class="row mt-4">

            {{-- Top 10 --}}
            <div class="col-lg-4">

                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-success text-white">

                        <h5 class="mb-0">

                            <i class="fa fa-trophy me-2"></i>

                            Top 10 Performer

                        </h5>

                    </div>

                    <div class="card-body p-0">

                        <table class="table table-sm table-hover mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Employee</th>

                                    <th class="text-end">Score</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($topEmployees as $employee)

                                <tr>

                                    <td>

                                        {{ $loop->iteration }}

                                    </td>

                                    <td>

                                        <strong>{{ $employee->name }}</strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $employee->employee_code }}

                                        </small>

                                    </td>

                                    <td class="text-end">

                                        <span class="badge bg-success">

                                            {{ number_format($employee->final_score,2) }}

                                        </span>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            {{-- Bottom 10 --}}
            <div class="col-lg-4">

                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-danger text-white">

                        <h5 class="mb-0">

                            <i class="fa fa-arrow-down me-2"></i>

                            Bottom 10 Performer

                        </h5>

                    </div>

                    <div class="card-body p-0">

                        <table class="table table-sm table-hover mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Employee</th>

                                    <th class="text-end">Score</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($bottomEmployees as $employee)

                                <tr>

                                    <td>

                                        {{ $loop->iteration }}

                                    </td>

                                    <td>

                                        <strong>{{ $employee->name }}</strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $employee->employee_code }}

                                        </small>

                                    </td>

                                    <td class="text-end">

                                        <span class="badge bg-danger">

                                            {{ number_format($employee->final_score,2) }}

                                        </span>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            {{-- Distribution --}}
            <div class="col-lg-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            Performance Distribution

                        </h5>

                    </div>

                    <div class="card-body">

                        <canvas id="distributionChart" height="250">

                        </canvas>

                    </div>

                </div>

            </div>

        </div>



        {{-- KPI Summary --}}
        <div class="row">

            <div class="col-lg-6">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">

                        <h5 class="mb-0 fw-bold">

                            KPI Category Summary

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">

                            <tr>

                                <th>Excellent</th>

                                <td class="text-end">

                                    {{ $distribution['excellent'] }}

                                </td>

                            </tr>

                            <tr>

                                <th>Very Good</th>

                                <td class="text-end">

                                    {{ $distribution['very_good'] }}

                                </td>

                            </tr>

                            <tr>

                                <th>Good</th>

                                <td class="text-end">

                                    {{ $distribution['good'] }}

                                </td>

                            </tr>

                            <tr>

                                <th>Fair</th>

                                <td class="text-end">

                                    {{ $distribution['fair'] }}

                                </td>

                            </tr>

                            <tr>

                                <th>Poor</th>

                                <td class="text-end">

                                    {{ $distribution['poor'] }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>



            {{-- Progress --}}
            <div class="col-lg-6">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">

                        <h5 class="mb-0 fw-bold">

                            Performance Progress

                        </h5>

                    </div>

                    <div class="card-body">

                        @php

                        $total = max(1, $statistics['employee']);

                        @endphp


                        <div class="mb-3">

                            <div class="d-flex justify-content-between">

                                <span>Excellent</span>

                                <span>{{ $distribution['excellent'] }}</span>

                            </div>

                            <div class="progress">

                                <div class="progress-bar bg-success"
                                    style="width: {{ ($distribution['excellent']/$total)*100 }}%">

                                </div>

                            </div>

                        </div>


                        <div class="mb-3">

                            <div class="d-flex justify-content-between">

                                <span>Very Good</span>

                                <span>{{ $distribution['very_good'] }}</span>

                            </div>

                            <div class="progress">

                                <div class="progress-bar bg-primary"
                                    style="width: {{ ($distribution['very_good']/$total)*100 }}%">

                                </div>

                            </div>

                        </div>


                        <div class="mb-3">

                            <div class="d-flex justify-content-between">

                                <span>Good</span>

                                <span>{{ $distribution['good'] }}</span>

                            </div>

                            <div class="progress">

                                <div class="progress-bar bg-info"
                                    style="width: {{ ($distribution['good']/$total)*100 }}%">

                                </div>

                            </div>

                        </div>


                        <div class="mb-3">

                            <div class="d-flex justify-content-between">

                                <span>Fair</span>

                                <span>{{ $distribution['fair'] }}</span>

                            </div>

                            <div class="progress">

                                <div class="progress-bar bg-warning"
                                    style="width: {{ ($distribution['fair']/$total)*100 }}%">

                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="d-flex justify-content-between">

                                <span>Poor</span>

                                <span>{{ $distribution['poor'] }}</span>

                            </div>

                            <div class="progress">

                                <div class="progress-bar bg-danger"
                                    style="width: {{ ($distribution['poor']/$total)*100 }}%">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    @endsection

    @push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(function(){
        
            $('#employeeTable').DataTable({
        
                responsive:true,
        
                pageLength:10,
        
                ordering:true,
        
                searching:true,
        
                autoWidth:false
        
            });
        });
        
        
        /*
        |--------------------------------------------------------------------------
        | Distribution Doughnut Chart
        |--------------------------------------------------------------------------
        */
        
        const distributionChart = new Chart(
        
            document.getElementById('distributionChart'),
        
            {
        
                type:'doughnut',
        
                data:{
        
                    labels:[
                        'Excellent',
                        'Very Good',
                        'Good',
                        'Fair',
                        'Poor'
                    ],
        
                    datasets:[{
        
                        data:[
        
                            {{ $distribution['excellent'] }},
        
                            {{ $distribution['very_good'] }},
        
                            {{ $distribution['good'] }},
        
                            {{ $distribution['fair'] }},
        
                            {{ $distribution['poor'] }}
        
                        ]
        
                    }]
        
                },
        
                options:{
        
                    responsive:true,
        
                    maintainAspectRatio:false,
        
                    plugins:{
        
                        legend:{
        
                            position:'bottom'
        
                        }
        
                    }
        
                }
        
            }
        
        );
        
        
        
        /*
        |--------------------------------------------------------------------------
        | KPI Bar Chart
        |--------------------------------------------------------------------------
        */
        
        const employeeNames = [
        
        @foreach($employees as $employee)
        
        '{{ $employee->name }}',
        
        @endforeach
        
        ];
        
        
        
        const employeeScores = [
        
        @foreach($employees as $employee)
        
        {{ $employee->final_score ?? 0 }},
        
        @endforeach
        
        ];
        
        
        
        new Chart(
        
        document.getElementById('kpiBarChart'),
        
        {
        
        type:'bar',
        
        data:{
        
        labels:employeeNames,
        
        datasets:[{
        
        label:'Final KPI',
        
        data:employeeScores
        
        }]
        
        },
        
        options:{
        
        responsive:true,
        
        maintainAspectRatio:false,
        
        plugins:{
        
        legend:{
        
        display:false
        
        }
        
        },
        
        scales:{
        
        y:{
        
        beginAtZero:true,
        
        max:100
        
        }
        
        }
        
        }
        
        }
        
        );
        
        
    
      const radarLabels = @json($radarLabels);
    const radarValues = @json($radarValues);
    
    const radarCtx = document.getElementById('radarChart');
    
    if (radarCtx) {
    
    new Chart(radarCtx, {
    type: 'radar',
    
    data: {
    labels: radarLabels,
    datasets: [{
    label: 'Average KPI',
    data: radarValues,
    fill: true,
    borderWidth: 2,
    pointRadius: 4,
    pointHoverRadius: 6
    }]
    },
    
    options: {
    responsive: true,
    maintainAspectRatio: false,
    
    plugins: {
    legend: {
    position: 'top'
    }
    },
    
    scales: {
    r: {
    beginAtZero: true,
    min: 0,
    max: 100,
    ticks: {
    stepSize: 20
    }
    }
    }
    }
    });
    
    }
        
    </script>
    @endpush