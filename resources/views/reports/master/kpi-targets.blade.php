@extends('layouts.admin.app')

@section('title', 'KPI Target Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-bullseye text-primary me-2"></i>
                KPI Target Report
            </h4>

            <p class="text-muted mb-0">
                KPI target master data report.
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

            <div class="row mb-3">

                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search employee...">
                </div>

                <div class="col-md-3">

                    <select class="form-select">

                        <option>All Period</option>

                        @foreach($periods ?? [] as $period)

                        <option value="{{ $period->id }}">
                            {{ $period->name }}
                        </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>
                            <th>Employee</th>
                            <th>KPI Master</th>
                            <th>Indicator</th>
                            <th>Target</th>
                            <th>Weight (%)</th>
                            <th>Period</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($targets as $target)

                        <tr>

                            <td>

                                {{ $loop->iteration + ($targets->firstItem() - 1) }}

                            </td>

                            <td>

                                {{ $target->employee->name ?? '-' }}

                            </td>

                            <td>

                                {{ $target->kpiIndicator->kpiMaster->name ?? '-' }}

                            </td>

                            <td>

                                {{ $target->kpiIndicator->name ?? '-' }}

                            </td>

                            <td>

                                <span class="badge bg-info">

                                    {{ $target->target }}

                                </span>

                            </td>

                            <td>

                                {{ number_format($target->weight,2) }} %

                            </td>

                            <td>

                                {{ $target->period->name ?? '-' }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <i class="bi bi-inbox display-5 text-muted"></i>

                                <div class="mt-2">

                                    No KPI target data found.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $targets->links() }}

            </div>

        </div>

    </div>

</div>

@endsection