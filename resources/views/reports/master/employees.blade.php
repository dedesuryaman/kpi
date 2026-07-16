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

            <a href="{{ route('reports.master.employees.excel', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i>
                Export Excel

            </a>

            <a href="{{ route('reports.master.employees.pdf', request()->query()) }}" class="btn btn-danger">


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

            <form method="GET">

                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search employee..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="department_id" class="form-select">
                            <option value="">All Department</option>

                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department_id')==$department->id ?
                                'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="position_id" class="form-select">
                            <option value="">All Position</option>

                            @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ request('position_id')==$position->id ? 'selected' :
                                '' }}>
                                {{ $position->name }}
                            </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">

                        <button class="btn btn-primary flex-fill">
                            <i class="fas fa-search"></i> Search
                        </button>

                        <a href="{{ route('reports.master.employees') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo"></i>
                        </a>

                    </div>

                </div>

            </form>
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

                            <td>{{ $employee->department->division->name ?? '-' }}</td>

                            <td>{{ $employee->position->name ?? '-' }}</td>

                            <td>

                                {{ $employee->employment_status ?? '-' }}


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