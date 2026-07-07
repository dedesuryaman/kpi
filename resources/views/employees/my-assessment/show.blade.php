@extends('layouts.admin.app')

@section('title', 'My Assessment')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-chart-line text-primary"></i>
                My Assessment
            </h3>

            <small class="text-muted">
                {{ $period->name }}
            </small>
        </div>

        <a href="{{ route('my-assessment.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>

    </div>

    {{-- Summary --}}
    <div class="row mb-4">

        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">Employee</small>

                    <h5 class="fw-bold mt-2">
                        {{ $employee->name }}
                    </h5>

                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">Average Score</small>

                    <h3 class="fw-bold text-primary mt-2">
                        {{ number_format($averageScore,2) }}
                    </h3>

                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">Final Score</small>

                    <h3 class="fw-bold text-success mt-2">
                        {{ number_format($finalScore,2) }}
                    </h3>

                </div>
            </div>
        </div>

        <div class="col-lg-3">

            @php

            $rating =
            $finalScore >= 90 ? 'Excellent' :
            ($finalScore >= 80 ? 'Very Good' :
            ($finalScore >= 70 ? 'Good' :
            ($finalScore >= 60 ? 'Fair' : 'Poor')));

            $color =
            $finalScore >= 90 ? 'success' :
            ($finalScore >= 80 ? 'primary' :
            ($finalScore >= 70 ? 'info' :
            ($finalScore >= 60 ? 'warning' : 'danger')));

            @endphp

            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">Rating</small>

                    <h4 class="mt-2">
                        <span class="badge bg-{{ $color }}">
                            {{ $rating }}
                        </span>
                    </h4>

                </div>
            </div>

        </div>

    </div>

    {{-- Progress --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-2">
                <strong>Performance Score</strong>
                <strong>{{ number_format($finalScore,2) }}%</strong>
            </div>

            <div class="progress" style="height:18px;">
                <div class="progress-bar bg-{{ $color }}" style="width: {{ min($finalScore,100) }}%;">
                </div>
            </div>

        </div>

    </div>

    {{-- Detail KPI --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">
                KPI Details
            </h5>
        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th width="50">#</th>
                        <th>KPI</th>
                        <th>Indicator</th>
                        <th class="text-center">Weight</th>
                        <th class="text-center">Target</th>
                        <th class="text-center">Actual</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Final Score</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($scores as $score)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $score->indicator->master->name ?? '-' }}
                        </td>

                        <td>
                            {{ $score->indicator->name ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ $score->indicator->weight }}
                        </td>

                        <td class="text-center">
                            {{ $score->target }}
                        </td>

                        <td class="text-center">
                            {{ $score->actual }}
                        </td>

                        <td class="text-center">
                            {{ number_format($score->score,2) }}
                        </td>

                        <td class="text-center fw-bold">
                            {{ number_format($score->final_score,2) }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-5">

                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>

                            <br>

                            No KPI assessment found.

                        </td>
                    </tr>

                    @endforelse

                </tbody>

                @if($scores->count())

                <tfoot class="table-light">

                    <tr>

                        <th colspan="6" class="text-end">

                            Final Score

                        </th>

                        <th class="text-center">

                            {{ number_format($averageScore,2) }}

                        </th>

                        <th class="text-center text-success">

                            {{ number_format($finalScore,2) }}

                        </th>

                    </tr>

                </tfoot>

                @endif

            </table>

        </div>

    </div>

</div>

@endsection