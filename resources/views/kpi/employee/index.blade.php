@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Employee KPI Evaluation
            </h4>
            <p class="text-muted mb-0">
                Employee Performance Assessment & KPI Achievement Monitoring
            </p>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crudModal">

            <i class="fas fa-plus me-1"></i>
            Add Evaluation

        </button>

    </div>

    <!-- KPI Summary -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">

            <div class="card h-100 border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Total Evaluation
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ $values->count() }}
                            </h3>
                        </div>

                        <div>
                            <i class="fas fa-chart-line fa-2x text-primary"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card h-100 border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Excellent
                            </small>

                            <h3 class="fw-bold text-success mb-0">
                                {{ $values->where('score','>=',90)->count() }}
                            </h3>
                        </div>

                        <div>
                            <i class="fas fa-award fa-2x text-success"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card h-100 border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Average Score
                            </small>

                            <h3 class="fw-bold text-warning mb-0">
                                {{ number_format($values->avg('score'),1) }}
                            </h3>
                        </div>

                        <div>
                            <i class="fas fa-bullseye fa-2x text-warning"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card h-100 border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Need Improvement
                            </small>

                            <h3 class="fw-bold text-danger mb-0">
                                {{ $values->where('score','<',70)->count() }}
                            </h3>
                        </div>

                        <div>
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="fw-bold mb-1">
                        KPI Evaluation Records
                    </h6>

                    <small class="text-muted">
                        Detailed employee KPI assessment data
                    </small>

                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchEmployee" placeholder="Search employee...">
                    </div>

                </div>

            </div>
        </div>

        <div class="accordion" id="employeeAccordion">

            @foreach($employees as $employee)

            @php

            $avgScore = round(
            $employee->kpiIndicatorValues->avg('score'),
            1
            );

            $totalKpi = $employee->kpiIndicatorValues->count();

            $statusClass =
            $avgScore >= 90 ? 'success' :
            ($avgScore >= 70 ? 'warning' : 'danger');

            $statusText =
            $avgScore >= 90 ? 'Excellent' :
            ($avgScore >= 70 ? 'Good' : 'Need Improvement');

            @endphp

            <div class="accordion-item border-0 shadow-sm mb-3">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse"
                        data-bs-target="#employee{{ $employee->id }}">

                        <div class="w-100">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <div class="fw-bold fs-6">
                                        <i class="fas fa-user-circle text-primary me-2"></i>
                                        {{ $employee->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $totalKpi }} KPI Indicators
                                    </small>

                                </div>

                                <div class="text-end me-4">

                                    <div class="fw-bold fs-5">
                                        {{ $avgScore }}
                                    </div>

                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </button>

                </h2>

                <div id="employee{{ $employee->id }}" class="accordion-collapse collapse"
                    data-bs-parent="#employeeAccordion">

                    <div class="accordion-body">

                        <div class="table-responsive">

                            <table class="table table-sm align-middle">

                                <thead class="table-light">

                                    <tr>
                                        <th>KPI Indicator</th>
                                        <th width="100">Weight</th>
                                        <th width="100">Target</th>
                                        <th width="100">Actual</th>
                                        <th width="120">Score</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($employee->kpiIndicatorValues as $item)

                                    <tr>

                                        <td>
                                            <div class="fw-semibold">
                                                {{ $item->indicator->name }}
                                            </div>

                                            @if($item->remarks)
                                            <small class="text-muted">
                                                {{ $item->remarks }}
                                            </small>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $item->weight }}%
                                        </td>

                                        <td>
                                            {{ $item->target_value }}
                                        </td>

                                        <td>
                                            {{ $item->actual_value }}
                                        </td>

                                        <td>

                                            @if($item->score >= 90)

                                            <span class="badge bg-success">
                                                {{ $item->score }}
                                            </span>

                                            @elseif($item->score >= 70)

                                            <span class="badge bg-warning text-dark">
                                                {{ $item->score }}
                                            </span>

                                            @else

                                            <span class="badge bg-danger">
                                                {{ $item->score }}
                                            </span>

                                            @endif

                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        <div class="d-flex justify-content-end">

                            <button class="btn btn-primary btn-sm employeeDetailBtn" data-id="{{ $employee->id }}">

                                <i class="fas fa-cogs me-1"></i>
                                Manage KPI

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</div>

@include('kpi.employee.modal')

@endsection