@extends('layouts.admin.app')

@section('title', 'Assessment Period Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-calendar-range-fill text-primary me-2"></i>
                Assessment Period Report
            </h4>

            <p class="text-muted mb-0">
                Assessment period master data report.
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

                    <input type="text" class="form-control" placeholder="Search period...">

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>
                            <th>Period Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Description</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($periods as $period)

                        <tr>

                            <td>

                                {{ $loop->iteration + ($periods->firstItem() - 1) }}

                            </td>

                            <td>

                                <strong>{{ $period->name }}</strong>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($period->start_date)->format('d M Y') }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($period->end_date)->format('d M Y') }}

                            </td>

                            <td>

                                @if($period->status == 'active')

                                <span class="badge bg-success">
                                    Active
                                </span>

                                @elseif($period->status == 'closed')

                                <span class="badge bg-danger">
                                    Closed
                                </span>

                                @else

                                <span class="badge bg-secondary">
                                    {{ ucfirst($period->status) }}
                                </span>

                                @endif

                            </td>

                            <td>

                                {{ $period->description ?? '-' }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                <i class="bi bi-calendar-x display-5 text-muted"></i>

                                <div class="mt-3">

                                    No assessment period found.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $periods->links() }}

            </div>

        </div>

    </div>

</div>

@endsection