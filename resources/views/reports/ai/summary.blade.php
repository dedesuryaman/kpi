@extends('layouts.admin.app')

@section('title', 'AI Summary Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="bi bi-stars text-primary me-2"></i>

                AI Performance Analysis Summary

            </h4>

            <p class="text-muted mb-0">

                Overview of AI-generated employee performance analyses.

            </p>

        </div>

        <div class="btn-group">
            <!--
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
        -->

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

                    <div class="col-md-6">

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

                            <i class="bi bi-search me-1"></i>

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

            <div class="card border-start border-primary border-4 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Total Employees

                    </small>

                    <h3 class="fw-bold">

                        {{ $summary['totalEmployee'] }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-start border-success border-4 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        AI Analysis Completed

                    </small>

                    <h3 class="fw-bold text-success">

                        {{ $summary['analyzed'] }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-start border-danger border-4 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Waiting for Analysis

                    </small>

                    <h3 class="fw-bold text-danger">

                        {{ $summary['notAnalyzed'] }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    {{-- Data Table --}}

    <div class="card shadow-sm">

        <div class="card-header">

            <strong>

                AI Performance Analysis

            </strong>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>

                            <th>Employee</th>

                            <th>Department</th>

                            <th>Position</th>

                            <th class="text-center">Final Score</th>

                            <th class="text-center">AI Status</th>

                            <th>Generated At</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        @php

                        $analysis = $result->latestAiAnalysis;

                        @endphp

                        <tr>

                            <td>

                                {{ $results->firstItem() + $loop->index }}

                            </td>

                            <td>

                                {{ $result->employee->name }}

                            </td>

                            <td>

                                {{ $result->employee->department->name ?? '-' }}

                            </td>

                            <td>

                                {{ $result->employee->position->name ?? '-' }}

                            </td>

                            <td class="text-center">

                                <strong>

                                    {{ number_format($result->final_score,2) }}

                                </strong>

                            </td>

                            <td class="text-center">

                                @if($analysis)

                                <span class="badge bg-success">

                                    <i class="bi bi-check-circle me-1"></i>

                                    Completed

                                </span>

                                @else

                                <span class="badge bg-warning text-dark">

                                    <i class="bi bi-hourglass-split me-1"></i>

                                    Pending

                                </span>

                                @endif

                            </td>

                            <td>

                                {{ optional($analysis)->created_at?->format('d M Y H:i') ?? '-' }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <i class="bi bi-stars display-4 text-muted"></i>

                                <div class="mt-3">

                                    No AI analysis data available.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $results->links() }}

            </div>

        </div>

    </div>

</div>

@endsection