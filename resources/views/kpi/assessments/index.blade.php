@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                KPI Assessments
            </h3>
            <p class="text-muted mb-0">
                Employee performance assessment records and KPI evaluation results.
            </p>
        </div>

        <a href="{{ route('kpi.assessments.create') }}" class="btn btn-primary px-4">
            <i class="fas fa-plus me-2"></i>
            New Assessment
        </a>
    </div>
    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <form method="GET" action="{{ route('kpi.assessments.index') }}">

                <div class="row g-3 align-items-end">

                    {{-- Search --}}
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">
                            Search Employee
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>

                            <input type="text" name="search" class="form-control" placeholder="Employee name or code..."
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    {{-- Department --}}
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">
                            Department
                        </label>

                        <select name="department" class="form-select">
                            <option value="">All Departments</option>

                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department')==$department->id ? 'selected'
                                :
                                '' }}>
                                {{ $department->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Period --}}
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">
                            Period
                        </label>

                        <select name="period" class="form-select">
                            <option value="">All Periods</option>

                            @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ request('period')==$period->id ? 'selected' : '' }}>
                                {{ $period->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Button --}}
                    <div class="col-lg-2">
                        <div class="d-flex gap-2">

                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-2"></i>
                                Filter
                            </button>

                            <a href="{{ route('kpi.assessments.index') }}" class="btn btn-light border">
                                <i class="fas fa-rotate-left"></i>
                            </a>

                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- Main Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <div class="row g-3">

                <div class="col-lg-3">
                    <div class="bg-light rounded-4 p-3">
                        <small class="text-muted">Total Assessments</small>
                        <h3 class="fw-bold mb-0">
                            {{ $assessments->total() }}
                        </h3>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="bg-light rounded-4 p-3">
                        <small class="text-muted">Average KPI Score</small>
                        <h3 class="fw-bold mb-0 text-primary">
                            {{ number_format($assessments->avg('average_score'),1) }}
                        </h3>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="bg-light rounded-4 p-3">
                        <small class="text-muted">Top Rating</small>
                        <h3 class="fw-bold mb-0 text-success">
                            Excellent
                        </h3>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="bg-light rounded-4 p-3">
                        <small class="text-muted">Current Period</small>
                        <h3 class="fw-bold mb-0">
                            {{ $currentPeriod?->name ?? 'All Periods' }}
                        </h3>
                    </div>
                </div>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Employee</th>
                            <th>Period</th>
                            <th>Total KPI</th>
                            <th>Average</th>
                            <th>Final Score</th>
                            <th>Rating</th>
                            <th>Assessment Date</th>
                            <th width="140" class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($assessments as $item)

                        @php

                        $rating =
                        $item->total_score >= 90 ? 'Excellent' :
                        ($item->total_score >= 80 ? 'Very Good' :
                        ($item->total_score >= 70 ? 'Good' :
                        ($item->total_score >= 60 ? 'Fair' : 'Poor')));

                        $ratingClass =
                        $item->total_score >= 90 ? 'success' :
                        ($item->total_score >= 80 ? 'primary' :
                        ($item->total_score >= 70 ? 'info' :
                        ($item->total_score >= 60 ? 'warning' : 'danger')));

                        @endphp

                        <tr>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div
                                        class="avatar-sm rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center me-3">

                                        {{ strtoupper(substr($item->employee_name,0,1)) }}

                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $item->employee_name }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $item->employee_code }}
                                        </small><br>

                                        <small class="text-muted">
                                            {{ $item->department_name }}
                                        </small>

                                    </div>

                                </div>

                            </td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $item->period_name }}
                                </span>
                            </td>

                            <td>

                                <span class="badge bg-secondary">
                                    {{ $item->total_indicators }} KPI
                                </span>

                            </td>

                            <td>

                                <span class="fw-semibold">
                                    {{ number_format($item->average_score,1) }}
                                </span>

                            </td>

                            <td>

                                <span class="fw-bold text-primary fs-6">
                                    {{ number_format($item->total_score,1) }}
                                </span>

                            </td>

                            <td>

                                <span class="badge bg-{{ $ratingClass }}">
                                    {{ $rating }}
                                </span>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($item->assessment_date)->format('d M Y') }}

                            </td>

                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('kpi.assessments.show',[$item->employee_id,$item->period_id]) }}"
                                        class="btn btn-sm btn-light border" title="View Details">

                                        <i class="fas fa-eye text-info"></i>

                                    </a>

                                    <a href="{{ route('kpi.assessments.edit',[$item->employee_id,$item->period_id]) }}"
                                        class="btn btn-sm btn-light border" title="Edit">

                                        <i class="fas fa-pen text-warning"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="8">

                                <div class="text-center py-5">

                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width:80px;height:80px">

                                        <i class="fas fa-chart-line fa-2x text-muted"></i>

                                    </div>

                                    <h5 class="fw-bold">
                                        No KPI Assessments Found
                                    </h5>

                                    <p class="text-muted">
                                        No employee performance assessments have been recorded yet.
                                    </p>

                                    <a href="{{ route('kpi.assessments.create') }}" class="btn btn-primary">

                                        <i class="fas fa-plus me-2"></i>
                                        Create Assessment

                                    </a>

                                </div>

                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if($assessments->hasPages())
            <div class="mt-4">
                {{ $assessments->links() }}
            </div>
            @endif

        </div>

    </div>

</div>

@endsection