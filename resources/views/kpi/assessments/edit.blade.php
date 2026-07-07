@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Edit KPI Assessment
            </h3>

            <p class="text-muted mb-0">
                Update employee KPI performance evaluation.
            </p>
        </div>

        <a href="{{ route('kpi.assessments.index') }}" class="btn btn-light border">

            <i class="fas fa-arrow-left me-2"></i>
            Back

        </a>

    </div>

    <form id="assessmentForm" action="{{ route('kpi.assessments.update', [$employee->id, $period->id]) }}"
        method="POST">

        @csrf
        @method('PUT')

        @csrf
        @method('PUT')

        <div class="row">

            {{-- Employee --}}
            <div class="col-lg-8">

                <div class="card border-1 shadow-sm mb-4 h-100">

                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            Employee Information
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-md-6">

                                <small class="text-muted">
                                    Employee
                                </small>

                                <div class="fw-semibold">
                                    {{ $employee->name }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted">
                                    Employee Code
                                </small>

                                <div class="fw-semibold">
                                    {{ $employee->employee_code }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted">
                                    Department
                                </small>

                                <div class="fw-semibold">
                                    {{ $employee->department->name ?? '-' }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted">
                                    Assessment Period
                                </small>

                                <div class="fw-semibold">
                                    {{ $period->name }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted">
                                    Assessor
                                </small>

                                <div class="fw-semibold">
                                    {{ auth()->user()->name }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted">
                                    Assessment Date
                                </small>

                                <input type="date" class="form-control mt-2" name="assessment_date"
                                    value="{{ old('assessment_date', optional($scores->first()->assessment_date)->format('Y-m-d')) }}">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Summary --}}
            <div class="col-lg-4">

                <div class="card border-1 shadow-sm h-100">

                    <div class="card-body text-center">

                        <div id="finalScore" class="display-5 fw-bold text-success">

                            {{ number_format($finalScore,2) }}

                        </div>

                        <div class="text-muted mb-3">
                            Final KPI Score
                        </div>

                        <span id="ratingBadge" class="badge bg-success">

                            Excellent

                        </span>

                        <hr>

                        <div class="row">

                            <div class="col-6">

                                <h5 class="fw-bold">
                                    {{ $scores->count() }}
                                </h5>

                                <small class="text-muted">
                                    Indicators
                                </small>

                            </div>

                            <div class="col-6">

                                <h5 id="avgScore" class="fw-bold">

                                    {{ number_format($averageScore,2) }}

                                </h5>

                                <small class="text-muted">
                                    Average Score
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Indicator --}}
        <div class="card border-1 shadow-sm mt-2">

            <div class="card-header  d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="fw-bold mb-0">
                        KPI Indicator Assessment
                    </h5>
                    <small class="text-muted">
                        Update score for each KPI indicator.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Update Assessment
                </button>

            </div>

            <div class="card-body p-0">

                @php
                $groupedScores = $scores->groupBy('indicator.kpi_master_id');
                @endphp

                @foreach($groupedScores as $masterId => $items)

                <div class="border-bottom">

                    {{-- Group Header --}}
                    <div class="bg-light px-4 py-3 border-bottom border-1 border-secondary">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h6 class="fw-bold mb-1">
                                    {{ $items->first()->indicator->master->name }}
                                </h6>

                                <small class="text-muted">
                                    {{ $items->count() }} Indicator(s)
                                </small>

                            </div>

                            <div class="text-end">

                                <small class="text-muted d-block">
                                    Average Score
                                </small>

                                <span class="badge bg-success fs-6 px-3 py-2">
                                    {{ number_format($items->avg('score'),2) }}
                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th style="width:35%">Indicator</th>

                                    <th class="text-center" width="110">
                                        Weight
                                    </th>

                                    <th width="170">
                                        Score
                                    </th>

                                    <th class="text-center" width="120">
                                        Weighted
                                    </th>

                                    <th>
                                        Notes
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($items as $score)

                                <tr>

                                    <td>

                                        <div class="fw-semibold">
                                            {{ $score->indicator->name }}
                                        </div>

                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-secondary px-3 py-2">
                                            {{ $score->indicator->weight }}%
                                        </span>

                                    </td>

                                    <td>

                                        <input type="number" class="form-control score-input"
                                            name="scores[{{ $score->id }}][score]" value="{{ $score->score }}" min="0"
                                            max="100" step="0.01">

                                    </td>

                                    <td class="text-center">

                                        <span class="weighted-score fw-bold text-success fs-6">

                                            {{ number_format($score->final_score,2) }}

                                        </span>

                                    </td>

                                    <td>

                                        <textarea class="form-control" rows="2"
                                            name="scores[{{ $score->id }}][notes]">{{ $score->notes }}</textarea>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                            <tfoot class="table-light">

                                <tr>

                                    <td colspan="2">

                                        <strong>Total Indicator</strong>

                                        <span class="badge bg-primary ms-2">
                                            {{ $items->count() }}
                                        </span>

                                    </td>

                                    <td class="text-end fw-bold">
                                        Total Final Score
                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-success fs-6 px-3 py-2">

                                            {{ number_format($items->sum('final_score'),2) }}

                                        </span>

                                    </td>

                                    <td></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </form>

</div>

@endsection