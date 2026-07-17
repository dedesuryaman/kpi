@extends('layouts.admin.app')

@section('title', 'Performance Ranking Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-trophy-fill text-warning me-2"></i>
                Performance Ranking Report
            </h4>

            <p class="text-muted mb-0">
                Employee ranking based on final KPI performance score.
            </p>

        </div>

        <div class="btn-group">


            <a href="{{ route('reports.performance.ranking.excel', request()->query()) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export Excel
            </a>

            <a href="{{ route('reports.performance.ranking.pdf', request()->query()) }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                Export PDF
            </a>

            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-2"></i>
                Back
            </a>

        </div>

    </div>

    <form method="GET">

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row g-3">

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

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="80">Rank</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th class="text-center">Final Score</th>
                            <th class="text-center">Performance</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        <tr>

                            <td class="text-center">

                                @php
                                $rank = $results->firstItem() + $loop->index;
                                @endphp

                                @if($rank == 1)

                                🥇

                                @elseif($rank == 2)

                                🥈

                                @elseif($rank == 3)

                                🥉

                                @else

                                {{ $rank }}

                                @endif

                            </td>

                            <td>

                                <strong>

                                    {{ $result->employee->name }}

                                </strong>

                            </td>

                            <td>

                                {{ $result->employee->department->name ?? '-' }}

                            </td>

                            <td>

                                {{ $result->employee->position->name ?? '-' }}

                            </td>

                            <td class="text-center">

                                <span class="badge bg-primary fs-6">

                                    {{ number_format($result->final_score,2) }}

                                </span>

                            </td>

                            <td class="text-center">

                                @php($score = $result->final_score)

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

                            <td colspan="6" class="text-center py-5">

                                <i class="bi bi-trophy display-4 text-muted"></i>

                                <div class="mt-3">

                                    No ranking data available.

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