@extends('layouts.admin.app')

@section('title', 'Top Performers Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-trophy-fill text-warning me-2"></i>
                Top Performers Report
            </h4>

            <p class="text-muted mb-0">
                Top employees with the highest KPI performance scores.
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

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="90">Rank</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th width="150">Final Score</th>
                            <th width="160">Performance</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        @php
                        $rank = $loop->iteration;
                        $score = $result->final_score;
                        @endphp

                        <tr>

                            <td class="text-center">

                                @switch($rank)

                                @case(1)
                                🥇 Gold
                                @break

                                @case(2)
                                🥈 Silver
                                @break

                                @case(3)
                                🥉 Bronze
                                @break

                                @default
                                {{ $rank }}

                                @endswitch

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

                                    {{ number_format($score,2) }}

                                </span>

                            </td>

                            <td class="text-center">

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

                                    No top performer data found.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection