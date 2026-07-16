@extends('layouts.admin.app')

@section('title', 'Department Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="fas fa-project-diagram text-primary me-2"></i>
                Department Report
            </h4>

            <p class="text-muted mb-0">
                Department master data report.
            </p>

        </div>

        <div class="btn-group">

            <a href="{{ route('reports.master.departments.excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i>
                Export Excel
            </a>

            <a href="{{ route('reports.master.departments.pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf me-1"></i>
                Export PDF
            </a>

            <a href="{{ route('reports.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">



            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">#</th>

                            <th>Department Name</th>
                            <th>Division</th>
                            <th>Total Employees</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($departments as $department)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($departments->firstItem() - 1) }}
                            </td>



                            <td>
                                {{ $department->name }}
                            </td>

                            <td>
                                {{ $department->division->name ?? '-' }}
                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $department->employees_count ?? ($department->employees->count() ?? 0) }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <i class="bi bi-inbox display-6 text-muted"></i>

                                <div class="mt-2">
                                    No department data found.
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $departments->links() }}

            </div>

        </div>

    </div>

</div>

@endsection