@extends('layouts.admin.app')

@section('title', 'Employee KPI Score Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-person-badge-fill text-primary me-2"></i>
                Employee KPI Score Report
            </h4>

            <p class="text-muted mb-0">
                Employee KPI assessment detail report.
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

    <form method="GET">

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-3">

                        <label class="form-label">Period</label>

                        <select name="period_id" class="form-select">

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected($selectedPeriod==$period->id)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

                        <label class="form-label">Department</label>

                        <select name="department_id" class="form-select">

                            <option value="">
                                All Department
                            </option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}" @selected($selectedDepartment==$department->id)>

                                {{ $department->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">Employee</label>

                        <input type="text" class="form-control" name="employee" value="{{ request('employee') }}"
                            placeholder="Employee name...">

                    </div>

                    <div class="col-md-2 d-grid">

                        <label class="form-label">&nbsp;</label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Score AVG</th>
                            <th>Grade</th>
                            <th>Rank</th>

                            <th>Final Score</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        <tr>

                            <td>

                                {{ $loop->iteration + ($results->firstItem()-1) }}

                            </td>

                            <td>

                                {{ $result->employee->name }}

                            </td>

                            <td>

                                {{ $result->employee->department->name ?? '-' }}

                            </td>

                            <td>

                                {{ $result->employee->position->name ?? '-' }}

                            </td>

                            <td>

                                {{ number_format($result->average_score,2) }}

                            </td>



                            <td>

                                {{ $result->grade }}

                            </td>

                            <td>

                                {{ $result->rank }}

                            </td>


                            <td>

                                <span class="badge bg-primary fs-6">

                                    {{ number_format($result->final_score,2) }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="10" class="text-center py-5">

                                <i class="bi bi-inbox display-5 text-muted"></i>

                                <div class="mt-3">

                                    No employee score data found.

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