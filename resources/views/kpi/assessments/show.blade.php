@extends('layouts.admin.app')

@section('content')
@push('styles')
<style>
    .table tbody tr:hover {
        background: #f8fbff;
    }

    .progress {
        border-radius: 20px;
    }

    .progress-bar {
        border-radius: 20px;
    }

    .card {
        border-radius: 16px;
    }

    .badge {
        border-radius: 20px;
        font-weight: 600;
    }

    .table thead th {
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: .5px;
    }

    .card-header h4 {
        font-weight: 700;
    }
</style>
@endpush
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                KPI Assessment Detail
            </h3>

            <p class="text-muted mb-0">
                Employee KPI performance evaluation summary.
            </p>
        </div>

        <a href="{{ route('kpi.assessments.index') }}" class="btn btn-light border">

            <i class="fas fa-arrow-left me-2"></i>
            Back

        </a>

    </div>

    <div class="row">

        {{-- Employee Info --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        Employee Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">
                            <small class="text-muted">Employee</small>
                            <div class="fw-semibold">
                                {{ $employee->name }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Employee Code</small>
                            <div class="fw-semibold">
                                {{ $employee->employee_code }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Department</small>
                            <div class="fw-semibold">
                                {{ $employee->department->name ?? '-' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Assessment Period</small>
                            <div class="fw-semibold">
                                {{ $period->name }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Assessor</small>
                            <div class="fw-semibold">
                                {{ $assessor->name ?? '-' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Assessment Date</small>
                            <div class="fw-semibold">
                                {{ $scores->max('assessment_date') }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            @php

            $rating =
            $finalScore >= 90 ? 'Excellent' :
            ($finalScore >= 80 ? 'Very Good' :
            ($finalScore >= 70 ? 'Good' :
            ($finalScore >= 60 ? 'Fair' : 'Poor')));

            $color =
            $finalScore >= 90 ? 'success' :
            ($finalScore >= 80 ? 'primary' :
            ($finalScore >= 70 ? 'info' :
            ($finalScore >= 60 ? 'warning' : 'danger')));

            $totalWeight = $scores->sum(fn($item) => $item->indicator->weight);

            $highestScore = $scores->max('score');
            $lowestScore = $scores->min('score');

            @endphp

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-{{ $color }} text-white text-center py-4">

                    <small class="text-uppercase">
                        Overall Performance
                    </small>

                    <h1 class="fw-bold my-2">
                        {{ number_format($finalScore,1) }}
                    </h1>

                    <span class="badge bg-light text-{{ $color }} px-3 py-2">
                        {{ $rating }}
                    </span>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-6">

                            <div class="border rounded p-3 text-center">

                                <small class="text-muted d-block">
                                    Indicators
                                </small>

                                <h4 class="fw-bold mb-0">
                                    {{ $scores->count() }}
                                </h4>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="border rounded p-3 text-center">

                                <small class="text-muted d-block">
                                    Weight Avg
                                </small>

                                <h4 class="fw-bold mb-0">
                                    {{ number_format($weightAvg,0) }}%
                                </h4>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="border rounded p-3 text-center">

                                <small class="text-muted d-block">
                                    Highest Score
                                </small>

                                <h4 class="fw-bold text-success mb-0">
                                    {{ number_format($highestScore,1) }}
                                </h4>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="border rounded p-3 text-center">

                                <small class="text-muted d-block">
                                    Lowest Score
                                </small>

                                <h4 class="fw-bold text-danger mb-0">
                                    {{ number_format($lowestScore,1) }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ================= KPI DETAILS ================= --}}

    @php

    $masterConfig = [
    'Attendance' => [
    'icon' => 'fa-user-check',
    'color' => 'success',
    ],
    'Productivity' => [
    'icon' => 'fa-chart-line',
    'color' => 'primary',
    ],
    'Quality' => [
    'icon' => 'fa-award',
    'color' => 'warning',
    ],
    'Discipline' => [
    'icon' => 'fa-scale-balanced',
    'color' => 'danger',
    ],
    'Innovation' => [
    'icon' => 'fa-lightbulb',
    'color' => 'info',
    ],
    ];

    @endphp

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h4 class="fw-bold mb-1">

                        <i class="fas fa-chart-pie text-primary me-2"></i>

                        KPI Assessment Details

                    </h4>

                    <small class="text-muted">

                        Performance evaluation grouped by KPI Master

                    </small>

                </div>

                <span class="badge bg-primary fs-6 px-3 py-2">

                    {{ $scores->count() }} Indicators

                </span>

            </div>

        </div>

    </div>

    @foreach($groupedScores as $masterName => $items)

    @php

    $totalWeight = $items->sum(fn($x)=>$x->indicator->weight);

    $subtotal = $items->sum('final_score');

    $avgScore = $items->avg('score');


    $config = [
    'icon' => 'fa-chart-bar',
    'color' => match (true) {
    $avgScore >= 90 => 'success', // Hijau
    $avgScore >= 80 => 'primary', // Biru
    $avgScore >= 70 => 'info', // Cyan
    $avgScore >= 60 => 'warning', // Kuning
    default => 'danger', // Merah
    },
    ];

    @endphp

    <div class="card border-0 shadow-sm mb-4">

        {{-- HEADER --}}

        <div class="card-header bg-{{ $config['color'] }} text-white">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h4 class="mb-1">

                        <i class="fas {{ $config['icon'] }} me-2"></i>

                        {{ $masterName }}

                    </h4>

                    <small>

                        {{ $items->count() }} KPI Indicator(s)

                    </small>

                </div>

                <div class="text-end">

                    <h3 class="mb-0">

                        {{ number_format($subtotal,2) }}

                    </h3>

                    <small>Contribution Score</small>

                </div>

            </div>

        </div>

        {{-- SUMMARY --}}

        <div class="card-body border-bottom bg-light">

            <div class="row text-center">

                <div class="col-md-3">

                    <small class="text-muted d-block">

                        Weight

                    </small>

                    <h5 class="fw-bold">

                        {{ number_format($totalWeight,0) }}%

                    </h5>

                </div>

                <div class="col-md-3">

                    <small class="text-muted d-block">

                        Average

                    </small>

                    <h5 class="fw-bold text-primary">

                        {{ number_format($avgScore,1) }}

                    </h5>

                </div>

                <div class="col-md-3">

                    <small class="text-muted d-block">

                        Indicators

                    </small>

                    <h5 class="fw-bold">

                        {{ $items->count() }}

                    </h5>

                </div>

                <div class="col-md-3">

                    <small class="text-muted d-block">

                        Achievement

                    </small>

                    <h5 class="fw-bold text-success">

                        {{ number_format($avgScore,0) }}%

                    </h5>

                </div>

            </div>

            <div class="progress mt-3" style="height:8px;">

                <div class="progress-bar bg-{{ $config['color'] }}" style="width:{{ min($avgScore,100) }}%">

                </div>

            </div>

        </div>

        {{-- TABLE --}}

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Indicator</th>

                        <th class="text-center" width="120">

                            Weight

                        </th>

                        <th class="text-center" width="120">

                            Score

                        </th>

                        <th class="text-center" width="160">

                            Weighted Score

                        </th>

                        <th>Notes</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($items as $item)

                    <tr>

                        <td>

                            <div class="fw-semibold">

                                {{ $item->indicator->name }}

                            </div>

                            @if($item->indicator->description)

                            <small class="text-muted">

                                {{ $item->indicator->description }}

                            </small>

                            @endif

                        </td>

                        <td class="text-center">

                            <span class="badge bg-secondary">

                                {{ number_format($item->indicator->weight,0) }}%

                            </span>

                        </td>

                        <td class="text-center">

                            @php

                            $scoreColor =
                            $item->score>=90 ? 'success' :
                            ($item->score>=80 ? 'primary' :
                            ($item->score>=70 ? 'info' :
                            ($item->score>=60 ? 'warning' : 'danger')));

                            @endphp

                            <span class="badge bg-{{ $scoreColor }} px-3 py-2">

                                {{ number_format($item->score,1) }}

                            </span>

                        </td>

                        <td class="text-center">

                            <span class="fw-bold text-success fs-6">

                                {{ number_format($item->final_score,2) }}

                            </span>

                        </td>

                        <td>

                            {{ $item->notes ?: '-' }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

                <tfoot class="table-light">

                    <tr>

                        <th colspan="3" class="text-end">

                            Total {{ $masterName }}

                        </th>

                        <th class="text-center text-success fs-5">

                            {{ number_format($subtotal,2) }}

                        </th>

                        <th></th>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

    @endforeach

    {{-- GRAND TOTAL --}}

    <div class="card border-0 shadow-lg">

        <div class="card-body py-4">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h3 class="fw-bold mb-1">

                        Overall KPI Performance

                    </h3>

                    <p class="text-muted mb-0">

                        Final score calculated from all KPI Master categories.

                    </p>

                </div>

                <div class="col-md-4 text-end">

                    <div class="display-4 fw-bold text-success">

                        {{ number_format($finalScore,2) }}

                    </div>

                    <span class="badge bg-success fs-6 px-4 py-2">

                        {{ $rating }}

                    </span>

                </div>

            </div>

        </div>

    </div>

</div>


@endsection