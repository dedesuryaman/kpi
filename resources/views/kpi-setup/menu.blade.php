@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold mb-1">
                PERFORMANCE
            </h3>

            <p class="text-muted mb-0">
                Manage KPI configuration, employee assessments, performance scoring, rankings, and reports.
            </p>
        </div>
    </div>

    <div class="row g-4">

        <!-- KPI SETUP -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                            <i class="fas fa-cogs text-primary"></i>
                        </div>

                        <div>
                            <h5 class="mb-0 fw-bold">
                                KPI Setup
                            </h5>

                            <small class="text-muted">
                                Configure KPI master data
                            </small>
                        </div>
                    </div>

                    <div class="list-group list-group-flush">

                        <a href="{{ route('kpi.period.index') }}"
                            class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">

                            <div>
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                Performance Period
                            </div>

                            <i class="fas fa-chevron-right text-muted"></i>

                        </a>

                        <a href="{{ route('kpi.master.index') }}"
                            class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">

                            <div>
                                <i class="fas fa-layer-group text-success me-2"></i>
                                KPI Master
                            </div>

                            <i class="fas fa-chevron-right text-muted"></i>

                        </a>

                        <a href="{{ route('kpi.indicator.index') }}"
                            class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">

                            <div>
                                <i class="fas fa-chart-line text-info me-2"></i>
                                KPI Indicators
                            </div>

                            <i class="fas fa-chevron-right text-muted"></i>

                        </a>

                    </div>

                </div>

            </div>
        </div>

        <!-- KPI ASSESSMENT -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                            <i class="fas fa-user-check text-warning"></i>
                        </div>

                        <div>
                            <h5 class="mb-0 fw-bold">
                                KPI Assessment
                            </h5>

                            <small class="text-muted">
                                Employee performance evaluation
                            </small>
                        </div>
                    </div>

                    <div class="list-group list-group-flush">

                        <a href="{{ route('kpi.assessments.index') }}"
                            class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">

                            <div>
                                <i class="fas fa-users text-secondary me-2"></i>
                                Employee KPI
                            </div>

                            <i class="fas fa-chevron-right text-muted"></i>

                        </a>

                    </div>

                </div>

            </div>
        </div>

        <!-- KPI RESULTS -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                            <i class="fas fa-trophy text-success"></i>
                        </div>

                        <div>
                            <h5 class="mb-0 fw-bold">
                                KPI Results
                            </h5>

                            <small class="text-muted">
                                Reports and performance analytics
                            </small>
                        </div>
                    </div>

                    <div class="list-group list-group-flush">

                        <a href="{{ route('kpi.score.index') }}"
                            class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">

                            <div>
                                <i class="fas fa-star text-warning me-2"></i>
                                Employee Score
                            </div>

                            <i class="fas fa-chevron-right text-muted"></i>

                        </a>

                        <a href="{{ route('kpi.ranking.index') }}"
                            class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">

                            <div>
                                <i class="fas fa-medal text-danger me-2"></i>
                                KPI Ranking
                            </div>

                            <i class="fas fa-chevron-right text-muted"></i>

                        </a>

                        <a href="{{ route('kpi.report.index') }}"
                            class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">

                            <div>
                                <i class="fas fa-file-alt text-info me-2"></i>
                                KPI Reports
                            </div>

                            <i class="fas fa-chevron-right text-muted"></i>

                        </a>

                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

@endsection