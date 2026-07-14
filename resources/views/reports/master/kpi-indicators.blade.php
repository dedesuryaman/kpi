@extends('layouts.admin.app')

@section('title', 'KPI Indicator Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-list-check text-primary me-2"></i>
                KPI Indicator Report
            </h4>

            <p class="text-muted mb-0">
                KPI indicator master data report.
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

                    <input type="text" class="form-control" placeholder="Search KPI indicator...">

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>
                            <th>Indicator Code</th>
                            <th>KPI Master</th>
                            <th>Indicator Name</th>
                            <th>Weight (%)</th>
                            <th>Target</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($indicators as $indicator)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($indicators->firstItem() - 1) }}
                            </td>

                            <td>
                                {{ $indicator->code }}
                            </td>

                            <td>
                                {{ $indicator->kpiMaster->name ?? '-' }}
                            </td>

                            <td>
                                {{ $indicator->name }}
                            </td>

                            <td>
                                {{ number_format($indicator->weight,2) }} %
                            </td>

                            <td>
                                {{ $indicator->target ?? '-' }}
                            </td>

                            <td>

                                @if($indicator->status)

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

                            <td colspan="7" class="text-center py-5">

                                <i class="bi bi-inbox display-5 text-muted"></i>

                                <div class="mt-2">

                                    No KPI indicator data found.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $indicators->links() }}

            </div>

        </div>

    </div>

</div>

@endsection