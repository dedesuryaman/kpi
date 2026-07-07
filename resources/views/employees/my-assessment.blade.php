@extends('layouts.admin.app')

@section('title', 'My Assessment')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-chart-line text-primary"></i>
                My Assessment
            </h3>
            <small class="text-muted">
                View your KPI performance for each period.
            </small>
        </div>
    </div>

    {{-- Summary --}}
    <div class="row mb-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">
                        Assessment Periods
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ count($assessments) }}
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">
                        Latest Final Score
                    </small>

                    <h2 class="fw-bold mt-2 text-primary">
                        {{ $assessments[0]['final_score'] ?? '-' }}
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <small class="text-muted">
                        Latest Rating
                    </small>

                    @php
                    $score = $assessments[0]['final_score'] ?? 0;

                    $rating =
                    $score >= 90 ? 'Excellent' :
                    ($score >= 80 ? 'Very Good' :
                    ($score >= 70 ? 'Good' :
                    ($score >= 60 ? 'Fair' : 'Poor')));
                    @endphp

                    <h4 class="mt-2">
                        {{ $rating }}
                    </h4>

                </div>
            </div>
        </div>

    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">
                Assessment History
            </h5>
        </div>

        <div class="card-body p-0">

            <table class="table table-hover mb-0 align-middle">

                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Period</th>
                        <th class="text-center">KPI</th>
                        <th class="text-center">Average Score</th>
                        <th class="text-center">Final Score</th>
                        <th class="text-center">Rating</th>
                        <th width="120"></th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($assessments as $item)

                    @php

                    $score = $item['final_score'];

                    $badge =
                    $score >= 90 ? 'success' :
                    ($score >= 80 ? 'primary' :
                    ($score >= 70 ? 'info' :
                    ($score >= 60 ? 'warning' : 'danger')));

                    $rating =
                    $score >= 90 ? 'Excellent' :
                    ($score >= 80 ? 'Very Good' :
                    ($score >= 70 ? 'Good' :
                    ($score >= 60 ? 'Fair' : 'Poor')));

                    @endphp

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $item['period']->name }}</strong>
                        </td>

                        <td class="text-center">
                            {{ $item['total_kpi'] }}
                        </td>

                        <td class="text-center">
                            {{ number_format($item['score'],2) }}
                        </td>

                        <td class="text-center fw-bold">
                            {{ number_format($item['final_score'],2) }}
                        </td>

                        <td class="text-center">

                            <span class="badge bg-{{ $badge }}">
                                {{ $rating }}
                            </span>

                        </td>

                        <td class="text-center">

                            <a href="{{ route('my-assessment.show',$item['period']->id) }}"
                                class="btn btn-sm btn-primary">

                                <i class="fas fa-eye"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center py-5 text-muted">

                            <i class="fas fa-folder-open fa-3x mb-3"></i>

                            <br>

                            No assessment data available.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection