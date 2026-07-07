@extends('layouts.admin.app')

@section('title', 'Performance History')

@push('styles')

<style>
    .stat-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        transition: .25s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .75rem 2rem rgba(0, 0, 0, .12);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .chart-card {
        border: none;
        border-radius: 18px;
    }

    .section-title {
        font-weight: 700;
        font-size: 15px;
        color: #555;
    }

    .score-big {
        font-size: 34px;
        font-weight: 700;
        line-height: 1;
    }

    .growth-up {
        color: #16a34a;
        font-weight: 600;
    }

    .growth-down {
        color: #dc2626;
        font-weight: 600;
    }

    .progress {
        height: 9px;
        border-radius: 20px;
    }

    .table td {
        vertical-align: middle;
    }

    .kpi-item {

        display: flex;

        justify-content: space-between;

        margin-bottom: 15px;

    }

    .kpi-item:last-child {

        margin-bottom: 0;

    }
</style>

@endpush

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="fas fa-chart-line text-primary"></i>

                Performance History

            </h3>

            <small class="text-muted">

                Performance analytics and KPI trends.

            </small>

        </div>

        <form method="GET">

            <select name="year" class="form-select" onchange="this.form.submit()">

                <option value="">

                    All Year

                </option>

                @foreach($years as $item)

                <option value="{{ $item }}" {{ $year==$item ? 'selected' : '' }}>

                    {{ $item }}

                </option>

                @endforeach

            </select>

        </form>

    </div>

    {{-- SUMMARY --}}
    <div class="row mb-4">

        {{-- Current --}}

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card stat-card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-muted">

                                Current Score

                            </div>

                            <div class="score-big text-primary">

                                {{ number_format($current['final_score'] ?? 0,2) }}

                            </div>

                        </div>

                        <div class="stat-icon bg-primary-subtle text-primary">

                            <i class="fas fa-chart-line"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Highest --}}

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card stat-card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-muted">

                                Highest Score

                            </div>

                            <div class="score-big text-success">

                                {{ number_format($highest,2) }}

                            </div>

                        </div>

                        <div class="stat-icon bg-success-subtle text-success">

                            <i class="fas fa-trophy"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Average --}}

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card stat-card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-muted">

                                Average Score

                            </div>

                            <div class="score-big text-info">

                                {{ number_format($average,2) }}

                            </div>

                        </div>

                        <div class="stat-icon bg-info-subtle text-info">

                            <i class="fas fa-chart-bar"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Growth --}}

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card stat-card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-muted">

                                Growth

                            </div>

                            <div class="score-big">

                                {{ $growth>0?'+':'' }}{{ number_format($growth,2) }}

                            </div>

                            @if($growth>=0)

                            <small class="growth-up">

                                <i class="fas fa-arrow-up"></i>

                                Improving

                            </small>

                            @else

                            <small class="growth-down">

                                <i class="fas fa-arrow-down"></i>

                                Decreasing

                            </small>

                            @endif

                        </div>

                        <div class="stat-icon bg-warning-subtle text-warning">

                            <i class="fas fa-arrow-trend-up"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- CHARTS --}}
    <div class="row">

        {{-- Performance Trend --}}

        <div class="col-lg-8 mb-4">

            <div class="card chart-card shadow-sm">

                <div class="card-header bg-white border-0">

                    <div class="section-title">

                        Performance Trend

                    </div>

                </div>

                <div class="card-body">

                    <div id="performanceTrendChart"></div>

                </div>

            </div>

        </div>

        {{-- Rating Distribution --}}

        <div class="col-lg-4 mb-4">

            <div class="card chart-card shadow-sm">

                <div class="card-header bg-white border-0">

                    <div class="section-title">

                        Rating Distribution

                    </div>

                </div>

                <div class="card-body">

                    <div id="ratingChart"></div>

                </div>

            </div>

        </div>

    </div>

    {{-- SECOND ROW --}}
    <div class="row">

        {{-- KPI Category --}}

        <div class="col-lg-8 mb-4">

            <div class="card chart-card shadow-sm">

                <div class="card-header bg-white border-0">

                    <div class="section-title">

                        KPI Category Performance

                    </div>

                </div>

                <div class="card-body">

                    <div id="categoryChart"></div>

                </div>

            </div>

        </div>

        {{-- Radar --}}

        <div class="col-lg-4 mb-4">

            <div class="card chart-card shadow-sm">

                <div class="card-header bg-white border-0">

                    <div class="section-title">

                        KPI Radar

                    </div>

                </div>

                <div class="card-body">

                    <div id="radarChart"></div>

                </div>

            </div>

        </div>

    </div>

    {{-- THIRD ROW --}}

    <div class="row">

        {{-- Best KPI --}}

        <div class="col-lg-6 mb-4">

            <div class="card chart-card shadow-sm">

                <div class="card-header bg-white">

                    <strong>

                        Best KPI

                    </strong>

                </div>

                <div class="card-body">

                    @foreach($bestKPIs as $kpi)

                    <div class="kpi-item">

                        <div>

                            {{ $kpi['name'] }}

                        </div>

                        <div>

                            <strong class="text-success">

                                {{ $kpi['score'] }}

                            </strong>

                        </div>

                    </div>

                    <div class="progress mb-3">

                        <div class="progress-bar bg-success" style="width:{{ $kpi['score'] }}%">

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- Need Improvement --}}

        <div class="col-lg-6 mb-4">

            <div class="card chart-card shadow-sm">

                <div class="card-header bg-white">

                    <strong>

                        Need Improvement

                    </strong>

                </div>

                <div class="card-body">

                    @foreach($worstKPIs as $kpi)

                    <div class="kpi-item">

                        <div>

                            {{ $kpi['name'] }}

                        </div>

                        <div>

                            <strong class="text-danger">

                                {{ $kpi['score'] }}

                            </strong>

                        </div>

                    </div>

                    <div class="progress mb-3">

                        <div class="progress-bar bg-danger" style="width:{{ $kpi['score'] }}%">

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    {{-- Performance Timeline --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <strong>

                Performance Timeline

            </strong>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>Period</th>

                            <th>Total KPI</th>

                            <th>Average</th>

                            <th>Final Score</th>

                            <th>Rating</th>

                            <th>Trend</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($histories as $history)

                        @php

                        $previous = $loop->index > 0
                        ? $histories[$loop->index-1]['final_score']
                        : null;

                        @endphp

                        <tr>

                            <td>

                                {{ $history['period']->name }}

                            </td>

                            <td>

                                {{ $history['total_kpi'] }}

                            </td>

                            <td>

                                {{ number_format($history['average_score'],2) }}

                            </td>

                            <td>

                                <strong>

                                    {{ number_format($history['final_score'],2) }}

                                </strong>

                            </td>

                            <td>

                                {{ $history['rating'] }}

                            </td>

                            <td>

                                @if($previous===null)

                                -

                                @elseif($history['final_score']>$previous)

                                <span class="text-success">

                                    <i class="fas fa-arrow-up"></i>

                                </span>

                                @elseif($history['final_score']<$previous) <span class="text-danger">

                                    <i class="fas fa-arrow-down"></i>

                                    </span>

                                    @else

                                    <span class="text-secondary">

                                        <i class="fas fa-minus"></i>

                                    </span>

                                    @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        
        /*====================================================
        PERFORMANCE TREND
        ====================================================*/
        
        new ApexCharts(
        
        document.querySelector("#performanceTrendChart"),
        
        {
        
        chart:{
        
        type:'area',
        
        height:360,
        
        toolbar:{show:true},
        
        zoom:{enabled:true}
        
        },
        
        stroke:{
        
        curve:'smooth',
        
        width:4
        
        },
        
        dataLabels:{
        
        enabled:false
        
        },
        
        series:[{
        
        name:'Final Score',
        
        data:@json($trendScores)
        
        }],
        
        xaxis:{
        
        categories:@json($trendLabels)
        
        },
        
        yaxis:{
        
        min:0,
        
        max:100
        
        },
        
        tooltip:{
        
        theme:'light'
        
        },
        
        fill:{
        
        type:'gradient',
        
        gradient:{
        
        shadeIntensity:.4,
        
        opacityFrom:.6,
        
        opacityTo:.1
        
        }
        
        }
        
        }
        
        ).render();
        
        /*====================================================
        CATEGORY
        ====================================================*/
        
        new ApexCharts(
        
        document.querySelector("#categoryChart"),
        
        {
        
        chart:{
        
        type:'bar',
        
        height:340,
        
        toolbar:{show:true}
        
        },
        
        plotOptions:{
        
        bar:{
        
        horizontal:true,
        
        borderRadius:6
        
        }
        
        },
        
        series:[{
        
        name:'Score',
        
        data:@json($categoryScores)
        
        }],
        
        xaxis:{
        
        max:100,
        
        categories:@json($categoryLabels)
        
        },
        
        dataLabels:{
        
        enabled:true
        
        }
        
        }
        
        ).render();
        
        /*====================================================
        DONUT
        ====================================================*/
        
        new ApexCharts(
        
        document.querySelector("#ratingChart"),
        
        {
        
        chart:{
        
        type:'donut',
        
        height:340
        
        },
        
        labels:@json(array_keys($ratingDistribution)),
        
        series:@json(array_values($ratingDistribution)),
        
        legend:{
        
        position:'bottom'
        
        },
        
        plotOptions:{
        
        pie:{
        
        donut:{
        
        size:'65%'
        
        }
        
        }
        
        }
        
        }
        
        ).render();
        
        /*====================================================
        RADAR
        ====================================================*/
        
        new ApexCharts(
        
        document.querySelector("#radarChart"),
        
        {
        
        chart:{
        
        type:'radar',
        
        height:340
        
        },
        
        series:[{
        
        name:'Score',
        
        data:@json($categoryScores)
        
        }],
        
        xaxis:{
        
        categories:@json($categoryLabels)
        
        },
        
        stroke:{
        
        width:3
        
        },
        
        markers:{
        
        size:5
        
        },
        
        fill:{
        
        opacity:.35
        
        }
        
        }
        
        ).render();
        
        });
        
</script>

@endpush