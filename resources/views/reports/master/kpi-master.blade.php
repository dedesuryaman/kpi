@extends('layouts.admin.app')

@section('title', 'KPI Master Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-bar-chart-fill text-primary me-2"></i>
                KPI Master Report
            </h4>

            <p class="text-muted mb-0">
                KPI master data report.
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

                    <input type="text" class="form-control" placeholder="Search KPI master...">

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">#</th>
                            <th>KPI Code</th>
                            <th>KPI Name</th>
                            <th>Weight (%)</th>
                            <th>Total Indicators</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($masters as $master)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($masters->firstItem() - 1) }}
                            </td>

                            <td>
                                {{ $master->code }}
                            </td>

                            <td>
                                {{ $master->name }}
                            </td>

                            <td>
                                {{ number_format($master->weight,2) }} %
                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $master->indicators_count }}

                                </span>

                            </td>

                            <td>

                                @if($master->status)

                                <span class="badge bg-success">
                                    Active
                                </span>

                                @else

                                <span class="badge bg-secondary">
                                    Inactive
                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                <i class="bi bi-inbox display-6 text-muted"></i>

                                <div class="mt-2">
                                    No KPI master data found.
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $masters->links() }}

            </div>

        </div>

    </div>

</div>

@endsection