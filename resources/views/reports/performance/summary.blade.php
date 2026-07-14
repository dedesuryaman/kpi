@extends('layouts.admin.app')

@section('title', 'Performance Summary Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-speedometer2 text-primary me-2"></i>
                Performance Summary Report
            </h4>

            <p class="text-muted mb-0">
                Overall employee performance summary based on KPI assessment results.
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

    {{-- FILTER --}}

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">

                            Period

                        </label>

                        <select class="form-select" name="period_id">

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected($period->id==$selectedPeriod)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">

                            Department

                        </label>

                        <select class="form-select" name="department_id">

                            <option value="">
                                All Department
                            </option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}" @selected($department->id==$selectedDepartment)>

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

            </form>

        </div>

    </div>

    {{-- SUMMARY CARD --}}

    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card border-start border-primary border-4">

                <div class="card-body">

                    <small class="text-muted">
                        Employees
                    </small>

                    <h3>

                        {{ number_format($summary['employees']) }}

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

                    <h3>

                        {{ number_format($summary['average'],2) }}

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

                    <h3>

                        {{ number_format($summary['highest'],2) }}

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

                    <h3>

                        {{ number_format($summary['lowest'],2) }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}

    <div class="card shadow-sm">

        <div class="card-header">

            Overall Employee Performance

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Employee</th>

                            <th>Department</th>

                            <th>Final Score</th>

                            <th>ABC Fitness</th>

                            <th>MDP State</th>

                            <th>AI Recommendation</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($results as $result)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $result->employee->name }}

                            </td>

                            <td>

                                {{ $result->employee->department->name ?? '-' }}

                            </td>

                            <td>

                                <strong>

                                    {{ number_format($result->final_score,2) }}

                                </strong>

                            </td>

                            <td>

                                {{ number_format($result->fitness_score,4) }}

                            </td>

                            <td>

                                {{ $result->mdp_state }}

                            </td>

                            <td>

                                {{ $result->latestRewardRecommendation->recommendation ?? '-' }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{ $results->links() }}

        </div>

    </div>

</div>

@endsection