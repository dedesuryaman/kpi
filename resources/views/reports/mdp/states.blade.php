@extends('layouts.admin.app')

@section('title','MDP States Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="bi bi-diagram-2-fill text-primary me-2"></i>

                MDP States Report

            </h4>

            <p class="text-muted mb-0">

                List of Markov Decision Process states used for employee performance classification.

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

                            <i class="bi bi-search me-1"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card border-start border-primary border-4">

                <div class="card-body">

                    <small class="text-muted">Total Employee</small>

                    <h3>{{ $summary['totalEmployee'] }}</h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-start border-success border-4">

                <div class="card-body">

                    <small class="text-muted">Average Reward</small>

                    <h3>{{ number_format($summary['averageReward'],2) }}</h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-start border-warning border-4">

                <div class="card-body">

                    <small class="text-muted">Highest Reward</small>

                    <h3>{{ number_format($summary['maxReward'],2) }}</h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-start border-danger border-4">

                <div class="card-body">

                    <small class="text-muted">Lowest Reward</small>

                    <h3>{{ number_format($summary['minReward'],2) }}</h3>

                </div>

            </div>

        </div>

    </div>
    <div class="card shadow-sm">

        <div class="card-header">

            <strong>

                State List

            </strong>

        </div>

        <div class="card-body">

            <div class="table-responsive">


                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Employee</th>

                            <th>Department</th>

                            <th>Position</th>

                            <th>Current State</th>

                            <th>Reward</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

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

                            <td>

                                @php
                                $state = $result->state;
                                @endphp

                                @if($state)

                                <span class="badge bg-{{ $state->color }}">

                                    {{ $state->code }}

                                </span>

                                {{ $state->name }}

                                @else

                                -

                                @endif

                            </td>

                            <td>

                                {{ number_format($result->reward,2) }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                No state analysis available.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                {{ $results->links() }}

            </div>


        </div>

    </div>

</div>

@endsection