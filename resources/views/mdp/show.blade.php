@extends('layouts.admin.app')

@section('title', 'MDP Analysis Result')
@push('styles')
@endpush
@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="row mb-3">

        <div class="col-lg-8">

            <h3 class="mb-0">

                <i class="fas fa-project-diagram text-primary"></i>

                Markov Decision Process Analysis

            </h3>

            <small class="text-muted">

                Employee Performance Decision Support System

            </small>

        </div>

        <div class="col-lg-4 text-end">

            <a href="{{ route('mdp.index') }}" class="btn btn-secondary">

                <i class="fa fa-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

    {{-- Summary Card --}}
    <div class="row">

        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Employee

                            </small>

                            <h2>

                                {{ $summary['total_employee'] }}

                            </h2>

                        </div>

                        <div>

                            <i class="fas fa-users fa-2x text-primary"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Average Reward

                            </small>

                            <h2>

                                {{ number_format($summary['average_reward'],2) }}

                            </h2>

                        </div>

                        <div>

                            <i class="fas fa-award fa-2x text-success"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Promotion

                            </small>

                            <h2>

                                {{ $summary['promotion'] }}

                            </h2>

                        </div>

                        <div>

                            <i class="fas fa-level-up-alt fa-2x text-info"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Warning

                            </small>

                            <h2>

                                {{ $summary['warning'] }}

                            </h2>

                        </div>

                        <div>

                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Chart Row --}}
    <div class="row mt-3">

        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-primary text-white">

                    State Distribution

                </div>

                <div class="card-body">

                    <canvas id="stateChart" height="200"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-success text-white">

                    Action Distribution

                </div>

                <div class="card-body">

                    <canvas id="actionChart" height="142"></canvas>

                </div>

            </div>

        </div>

    </div>


    {{-- Recommendation Table --}}
    <div class="card shadow-sm border-0 mt-4">

        <div class="card-header bg-dark text-white">

            Employee Recommendation

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle" id="recommendationTable">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>

                            <th>Employee</th>

                            <th>Department</th>

                            <th>State</th>

                            <th>Reward</th>

                            <th>Action</th>

                            <th>Recommendation</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($results as $item)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $item->employee->name }}

                            </td>

                            <td>

                                {{ optional($item->employee->department)->name }}

                            </td>

                            <td>

                                <span class="badge bg-{{ $item->state->color }}">

                                    {{ $item->state->name }}

                                </span>

                            </td>

                            <td>

                                {{ number_format($item->reward,2) }}

                            </td>

                            <td>

                                <span class="badge bg-{{ $item->action->color }}">

                                    {{ $item->action->name }}

                                </span>

                            </td>

                            <td>

                                {{ $item->recommendation }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function () {

    initDataTable();
    renderStateChart();
    renderActionChart();
    

});

/**
 * DataTable
 */
function initDataTable()
{
    $('#recommendationTable').DataTable({
        responsive: true,
        pageLength: 10,
        ordering: true,
        autoWidth: false,
    });
}

/**
 * State Distribution Chart
 */
function renderStateChart()
{
    const ctx = document.getElementById('stateChart');

    if (!ctx) return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($stateChart->keys()),
            datasets: [{
                data: @json($stateChart->values()),
                backgroundColor: [
                    '#dc3545',
                    '#ffc107',
                    '#0dcaf0',
                    '#198754'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

/**
 * Action Distribution Chart
 */
function renderActionChart()
{
    const ctx = document.getElementById('actionChart');

    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($actionChart->keys()),
            datasets: [{
                label: 'Total Employee',
                data: @json($actionChart->values()),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

</script>

@endpush