@extends('layouts.admin.app')

@section('title','Reward & Punishment')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Reward & Punishment

            </h2>

            <p class="text-muted mb-0">

                Performance Recommendation Dashboard

            </p>

        </div>

        <form>

            <select name="period_id" class="form-select" onchange="this.form.submit()">

                @foreach($periods as $period)

                <option value="{{ $period->id }}" {{ $periodId==$period->id?'selected':'' }}>

                    {{ $period->name }}

                </option>

                @endforeach

            </select>

        </form>
    </div>

    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Total Employee

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $summary['total_employee'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Eligible Reward

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $summary['reward'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Need Coaching

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $summary['punishment'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Average KPI

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ number_format($summary['average_score'],2) }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        {{-- Top Reward --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0">

                        <i class="fa fa-trophy me-2"></i>

                        Top Reward Candidate

                    </h5>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Score</th>
                                    <th>Recommendation</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($topReward as $employee)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                        <strong>{{ $employee->employee->name }}</strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $employee->employee->department->name ?? '-' }}

                                        </small>

                                    </td>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ number_format($employee->final_score,2) }}

                                        </span>

                                    </td>

                                    <td>

                                        Promotion

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center py-4">

                                        No data

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        {{-- Need Coaching --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-danger text-white">

                    <h5 class="mb-0">

                        <i class="fa fa-user-shield me-2"></i>

                        Need Coaching

                    </h5>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Score</th>
                                    <th>Recommendation</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($needCoaching as $employee)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                        <strong>{{ $employee->employee->name }}</strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $employee->employee->department->name ?? '-' }}

                                        </small>

                                    </td>

                                    <td>

                                        <span class="badge bg-danger">

                                            {{ number_format($employee->final_score,2) }}

                                        </span>

                                    </td>

                                    <td>

                                        Coaching

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center py-4">

                                        No data

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                Department Performance Ranking

            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>

                            <th width="70">

                                Rank

                            </th>

                            <th>

                                Department

                            </th>

                            <th width="150">

                                Employee

                            </th>

                            <th width="150">

                                Average KPI

                            </th>

                            <th width="150">

                                Status

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($divisionSummary as $division)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $division->name }}

                            </td>

                            <td>

                                {{ $division->total_employee }}

                            </td>

                            <td>

                                {{ number_format($division->average_score,2) }}

                            </td>

                            <td>

                                @if($division->average_score>=90)

                                <span class="badge bg-success">

                                    Excellent

                                </span>

                                @elseif($division->average_score>=80)

                                <span class="badge bg-primary">

                                    Very Good

                                </span>

                                @elseif($division->average_score>=70)

                                <span class="badge bg-info">

                                    Good

                                </span>

                                @elseif($division->average_score>=60)

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

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="row text-center">

                <div class="col-md-3">

                    <a href="{{ route('reward-punishment.reward') }}" class="btn btn-success w-100">

                        <i class="fa fa-award me-2"></i>

                        Reward Recommendation

                    </a>

                </div>

                <div class="col-md-3">

                    <a href="{{ route('reward-punishment.punishment') }}" class="btn btn-danger w-100">

                        <i class="fa fa-user-slash me-2"></i>

                        Punishment Recommendation

                    </a>

                </div>
                <!---
                <div class="col-md-3">

                    <a href="{{ route('reward-punishment.history') }}" class="btn btn-primary w-100">

                        <i class="fa fa-history me-2"></i>

                        History

                    </a>

                </div>

                <div class="col-md-3">

                    <button class="btn btn-dark w-100">

                        <i class="fa fa-file-excel me-2"></i>

                        Export Report

                    </button>

                </div>
            -->
            </div>

        </div>

    </div>
</div>


@endsection