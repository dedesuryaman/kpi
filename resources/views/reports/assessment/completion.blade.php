@extends('layouts.admin.app')

@section('title', 'Assessment Completion Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-check2-square text-primary me-2"></i>
                Assessment Completion Report
            </h4>

            <p class="text-muted mb-0">
                Assessment completion status by department.
            </p>

        </div>

        <div class="btn-group">

            <a href="{{ route('reports.assessment.completion.excel', request()->query()) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export Excel
            </a>

            <a href="{{ route('reports.assessment.completion.pdf', request()->query()) }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                Export PDF
            </a>

            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-2"></i>
                Back
            </a>

        </div>

    </div>

    <form method="GET">

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">

                            Period

                        </label>

                        <select name="period_id" class="form-select">

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected($selectedPeriod==$period->id)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

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
                            <th>Department</th>
                            <th>Division</th>
                            <th>Total Employees</th>
                            <th>Completed</th>

                            <th>Not Assessed</th>
                            <th>Completion (%)</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $department)



                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                <strong>

                                    {{ $department->department_name }}

                                </strong>

                            </td>
                            <td>

                                {{ $department->division_name }}

                            </td>
                            <td>

                                {{ $department->total_employee }}

                            </td>

                            <td>


                                {{ $department->assessed_employee }}


                            </td>


                            <td>

                                {{ $department->not_assessed_employee }}

                            </td>

                            <td>

                                {{ number_format($department->completion_percentage ,2) }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <i class="bi bi-inbox display-5 text-muted"></i>

                                <div class="mt-2">

                                    No assessment completion data found.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection