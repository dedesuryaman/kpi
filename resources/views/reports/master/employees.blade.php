@extends('layouts.admin.app')

@section('title', 'Employee Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-people-fill text-primary me-2"></i>
                Employee Report
            </h4>

            <p class="text-muted mb-0">
                Employee master data report.
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

                        <option>All Department</option>

                    </select>

                </div>

                <div class="col-md-3">

                    <select class="form-select">

                        <option>All Position</option>

                    </select>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>

                            <th>Employee No</th>

                            <th>Employee Name</th>

                            <th>Department</th>

                            <th>Division</th>

                            <th>Position</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($employees as $employee)

                        <tr>

                            <td>{{ $loop->iteration + ($employees->firstItem() - 1) }}</td>

                            <td>{{ $employee->employee_code ?? '' }}</td>

                            <td>{{ $employee->name }}</td>

                            <td>{{ $employee->department->name ?? '-' }}</td>

                            <td>{{ $employee->division->name ?? '-' }}</td>

                            <td>{{ $employee->position->name ?? '-' }}</td>

                            <td>

                                @if($employee->status)

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

                                <i class="bi bi-inbox display-6 text-muted"></i>

                                <div class="mt-2">
                                    No employee data found.
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $employees->links() }}

            </div>

        </div>

    </div>

</div>

@endsection