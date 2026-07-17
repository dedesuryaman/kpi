@extends('layouts.admin.app')

@section('title', 'ABC Iteration Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="bi bi-arrow-repeat text-primary me-2"></i>

                ABC Iteration Report

            </h4>

            <p class="text-muted mb-0">

                Artificial Bee Colony iteration configuration and execution statistics.

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

            <button class="btn btn-secondary" onclick="window.print()">

                <i class="bi bi-printer me-1"></i>

                Print

            </button>
        -->

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>

                            <th>Period</th>

                            <th class="text-center">

                                Population

                            </th>

                            <th class="text-center">

                                Max Iteration

                            </th>

                            <th class="text-center">

                                Limit Trial

                            </th>

                            <th class="text-center">

                                Best Fitness

                            </th>

                            <th class="text-center">

                                Execution Time

                            </th>

                            <th class="text-center">

                                Status

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        <tr>

                            <td>

                                {{ $results->firstItem() + $loop->index }}

                            </td>

                            <td>

                                {{ $result->period->name ?? '-' }}

                            </td>

                            <td class="text-center">

                                {{ $result->population_size }}

                            </td>

                            <td class="text-center">

                                {{ number_format($result->max_iteration) }}

                            </td>

                            <td class="text-center">

                                {{ $result->limit_trial }}

                            </td>

                            <td class="text-center">

                                <span class="badge bg-success">

                                    {{ number_format($result->fitness,6) }}

                                </span>

                            </td>

                            <td class="text-center">

                                {{ number_format($result->execution_time,2) }} sec

                            </td>

                            <td class="text-center">

                                @if($result->is_best)

                                <span class="badge bg-primary">

                                    Best Solution

                                </span>

                                @else

                                <span class="badge bg-secondary">

                                    Archive

                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center py-5">

                                <i class="bi bi-arrow-repeat display-4 text-muted"></i>

                                <div class="mt-3">

                                    No iteration report available.

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