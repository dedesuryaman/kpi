@extends('layouts.admin.app')

@section('title', 'Assessment Summary Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-clipboard-data-fill text-primary me-2"></i>
                Assessment Summary Report
            </h4>

            <p class="text-muted mb-0">
                Employee KPI assessment summary report.
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

            <button class="btn btn-secondary" onclick="window.print()">
                <i class="bi bi-printer me-1"></i>
                Print
            </button>

        </div>

    </div>

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
                                All Department
                            </option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}" @selected($selectedDepartment==$department->id)>

                                {{ $department->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2 d-grid">

                        <label class="form-label">&nbsp;</label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card border-start border-primary border-4">

                <div class="card-body">

                    <small class="text-muted">
                        Total Employees
                    </small>

                    <h3 class="fw-bold">

                        {{ $results->total() }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-success border-4">

                <div class="card-body">

                    <small class="text-muted">
                        Average Score
                    </small>

                    <h3 class="fw-bold">

                        {{ number_format($results->avg('final_score'),2) }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-warning border-4">

                <div class="card-body">

                    <small class="text-muted">
                        Highest Score
                    </small>

                    <h3 class="fw-bold">

                        {{ number_format($results->max('final_score'),2) }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-danger border-4">

                <div class="card-body">

                    <small class="text-muted">
                        Lowest Score
                    </small>

                    <h3 class="fw-bold">

                        {{ number_format($results->min('final_score'),2) }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Final Score</th>
                            <th>Category</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        <tr>

                            <td>

                                {{ $loop->iteration + ($results->firstItem()-1) }}

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

                            <td>

                                <strong>

                                    {{ number_format($result->final_score,2) }}

                                </strong>

                            </td>

                            <td>

                                @php

                                $score = $result->final_score;

                                @endphp

                                @if($score >= 90)

                                <span class="badge bg-success">
                                    Excellent
                                </span>

                                @elseif($score >= 80)

                                <span class="badge bg-primary">
                                    Very Good
                                </span>

                                @elseif($score >= 70)

                                <span class="badge bg-info">
                                    Good
                                </span>

                                @elseif($score >= 60)

                                <span class="badge bg-warning">
                                    Fair
                                </span>

                                @else

                                <span class="badge bg-danger">
                                    Poor
                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                <i class="bi bi-inbox display-5 text-muted"></i>

                                <div class="mt-2">

                                    No assessment data found.

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