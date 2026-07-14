@extends('layouts.admin.app')

@section('title', 'Monthly Assessment Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-calendar-month-fill text-primary me-2"></i>
                Monthly Assessment Report
            </h4>

            <p class="text-muted mb-0">
                Monthly KPI assessment summary report.
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

                <div class="row g-3">

                    <div class="col-md-3">

                        <label class="form-label">
                            Year
                        </label>

                        <select name="year" class="form-select">

                            @foreach($years as $year)

                            <option value="{{ $year }}" @selected($selectedYear==$year)>

                                {{ $year }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

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

    <div class="card shadow-sm">

        <div class="card-header">

            <strong>

                Monthly KPI Summary

            </strong>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">#</th>
                            <th>Period</th>
                            <th>Total Employees</th>
                            <th>Average Score</th>
                            <th>Highest Score</th>
                            <th>Lowest Score</th>
                            <th>Performance</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                <strong>

                                    {{ $result->period_name }}

                                </strong>

                            </td>

                            <td>

                                {{ $result->employee_count }}

                            </td>

                            <td>

                                {{ number_format($result->average_score,2) }}

                            </td>

                            <td>

                                {{ number_format($result->highest_score,2) }}

                            </td>

                            <td>

                                {{ number_format($result->lowest_score,2) }}

                            </td>

                            <td>

                                @php

                                $score = $result->average_score;

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

                                <span class="badge bg-warning text-dark">
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

                            <td colspan="7" class="text-center py-5">

                                <i class="bi bi-calendar-x display-5 text-muted"></i>

                                <div class="mt-3">

                                    No monthly assessment data found.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection