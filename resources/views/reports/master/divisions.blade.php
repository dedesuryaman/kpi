@extends('layouts.admin.app')

@section('title', 'Division Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-diagram-2-fill text-primary me-2"></i>
                Division Report
            </h4>

            <p class="text-muted mb-0">
                Division master data report.
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

                    <input type="text" class="form-control" placeholder="Search division...">

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">#</th>
                            <th>Division Code</th>
                            <th>Division Name</th>
                            <th>Description</th>
                            <th>Total Employees</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($divisions as $division)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($divisions->firstItem() - 1) }}
                            </td>

                            <td>
                                {{ $division->code }}
                            </td>

                            <td>
                                {{ $division->name }}
                            </td>

                            <td>
                                {{ $division->description ?? '-' }}
                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $division->employees_count }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <i class="bi bi-inbox display-6 text-muted"></i>

                                <div class="mt-2">
                                    No division data found.
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $divisions->links() }}

            </div>

        </div>

    </div>

</div>

@endsection