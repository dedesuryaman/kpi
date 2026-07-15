@extends('layouts.admin.app')

@section('title', 'AI Development Recommendations')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="bi bi-lightbulb text-warning me-2"></i>

                AI Development Recommendations

            </h4>

            <p class="text-muted mb-0">

                AI-generated recommendations to improve employee performance and career development.

            </p>

        </div>

        <div class="btn-group">

            <a href="#" class="btn btn-success">

                <i class="bi bi-file-earmark-excel me-1"></i>

                Excel

            </a>

            <a href="#" class="btn btn-danger">

                <i class="bi bi-file-earmark-pdf me-1"></i>

                PDF

            </a>

            <button onclick="window.print()" class="btn btn-secondary">

                <i class="bi bi-printer me-1"></i>

                Print

            </button>

        </div>

    </div>

    {{-- Filter --}}

    <form method="GET">

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">

                            Period

                        </label>

                        <select name="period_id" class="form-select">

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected($selectedPeriod==$period->id)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">

                            Department

                        </label>

                        <select name="department_id" class="form-select">

                            <option value="">

                                All Departments

                            </option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}" @selected($selectedDepartment==$department->id)>

                                {{ $department->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2 d-grid">

                        <label>&nbsp;</label>

                        <button class="btn btn-primary">

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    {{-- Summary --}}

    <div class="row mb-4">

        <div class="col-lg-4">

            <div class="card border-start border-primary border-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Employees

                    </small>

                    <h3>

                        {{ $summary['totalEmployee'] }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-start border-success border-4">

                <div class="card-body">

                    <small class="text-muted">

                        AI Completed

                    </small>

                    <h3>

                        {{ $summary['analyzed'] }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-start border-warning border-4">

                <div class="card-body">

                    <small class="text-muted">

                        Pending

                    </small>

                    <h3>

                        {{ $summary['notAnalyzed'] }}

                    </h3>

                </div>

            </div>

        </div>

    </div>
    <div class="row ">
        @forelse($results as $result)

        @php

        $analysis = $result->latestAiAnalysis;

        @endphp

        <div class="col-md-6 ">
            <div class="card shadow-sm mb-3">
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3">

                            <h5 class="mb-1">

                                {{ $result->employee->name }}

                            </h5>

                            <small class="text-muted">

                                {{ $result->employee->department->name ?? '-' }}

                            </small>

                            <br>

                            <small>

                                {{ $result->employee->position->name ?? '-' }}

                            </small>

                            <hr>

                            <span class="badge bg-primary">

                                Score

                                {{ number_format($result->final_score,2) }}

                            </span>

                        </div>

                        <div class="col-md-9">

                            @if($analysis)

                            <div class="alert alert-warning">

                                <h6>

                                    <i class="bi bi-lightbulb me-2"></i>

                                    AI Recommendation

                                </h6>

                                {!! nl2br(e($analysis->recommendation ?? 'No recommendation available.')) !!}
                            </div>

                            @if(!empty($analysis->development_plan))

                            <div class="card">

                                <div class="card-header">

                                    Development Plan

                                </div>

                                <div class="card-body">

                                    {!! nl2br(e($analysis->development_plan)) !!}

                                </div>

                            </div>

                            @endif

                            @else

                            <div class="text-center py-4">

                                <i class="bi bi-stars display-6 text-muted"></i>

                                <div class="mt-2">

                                    AI analysis has not been generated.

                                </div>

                            </div>

                            @endif

                        </div>

                    </div>

                </div>
            </div>

        </div>

        @empty

        <div class="card">

            <div class="card-body text-center py-5">

                <i class="bi bi-lightbulb display-3 text-muted"></i>

                <h5 class="mt-3">

                    No recommendations available.

                </h5>

            </div>

        </div>

        @endforelse
    </div>

    <div class="mt-3">

        {{ $results->links() }}

    </div>

</div>

@endsection