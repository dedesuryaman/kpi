@extends('layouts.admin.app')

@section('title', 'ABC Summary Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">
                <i class="bi bi-diagram-3-fill text-warning me-2"></i>
                Artificial Bee Colony Summary
            </h4>

            <p class="text-muted mb-0">
                Summary of Artificial Bee Colony optimization results.
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

    <form method="GET">

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-10">

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

                    <div class="col-md-2 d-grid">

                        <label>&nbsp;</label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    @if($abc)

    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card border-start border-primary border-4">

                <div class="card-body">

                    <small class="text-muted">

                        Best Fitness

                    </small>

                    <h3>

                        {{ number_format($abc->fitness,6) }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-success border-4">

                <div class="card-body">

                    <small class="text-muted">

                        Population Size

                    </small>

                    <h3>

                        {{ $abc->population_size }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-warning border-4">

                <div class="card-body">

                    <small class="text-muted">

                        Max Iteration

                    </small>

                    <h3>

                        {{ $abc->max_iteration }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-danger border-4">

                <div class="card-body">

                    <small class="text-muted">

                        Execution Time

                    </small>

                    <h3>

                        {{ number_format($abc->execution_time,2) }} s

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <strong>

                Optimized KPI Weights

            </strong>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="table-light">

                        <tr>

                            <th>KPI</th>

                            <th width="180">
                                Weight (%)
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($abc->details as $detail)

                        <tr>

                            <td>

                                {{ $detail->kpiMaster->name }}

                            </td>

                            <td>

                                {{ number_format($detail->weight,2) }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-header">

            <strong>

                Optimization Parameters

            </strong>

        </div>

        <div class="card-body">

            <table class="table table-bordered mb-0">

                <tr>

                    <th width="300">

                        Population Size

                    </th>

                    <td>

                        {{ $abc->population_size }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Maximum Iteration

                    </th>

                    <td>

                        {{ $abc->max_iteration }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Limit Trial

                    </th>

                    <td>

                        {{ $abc->limit_trial }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Best Fitness

                    </th>

                    <td>

                        {{ number_format($abc->fitness,6) }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Execution Time

                    </th>

                    <td>

                        {{ number_format($abc->execution_time,2) }} Seconds

                    </td>

                </tr>

            </table>

        </div>

    </div>

    @else

    <div class="card">

        <div class="card-body text-center py-5">

            <i class="bi bi-diagram-3 display-4 text-muted"></i>

            <h5 class="mt-3">

                No ABC Optimization Result

            </h5>

            <p class="text-muted">

                ABC optimization has not been executed for the selected period.

            </p>

        </div>

    </div>

    @endif

</div>

@endsection