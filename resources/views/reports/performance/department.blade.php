@extends('layouts.admin.app')

@section('title','Department Performance Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">
                <i class="bi bi-building text-primary me-2"></i>
                Department Performance Report
            </h4>

            <p class="text-muted mb-0">

                Overall KPI performance by department.

            </p>

        </div>

        <div class="btn-group">

            <a href="#" class="btn btn-success">

                <i class="bi bi-file-earmark-excel"></i>

                Excel

            </a>

            <a href="#" class="btn btn-danger">

                <i class="bi bi-file-earmark-pdf"></i>

                PDF

            </a>

            <button onclick="window.print()" class="btn btn-secondary">

                <i class="bi bi-printer"></i>

                Print

            </button>

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

                        <select class="form-select" name="period_id">

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected($period->id==$selectedPeriod)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2 d-grid">

                        <label>&nbsp;</label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

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

                <table class="table table-bordered table-hover">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>

                            <th>Department</th>

                            <th>Total Employee</th>

                            <th>Average Score</th>

                            <th>Category</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($departments as $department)

                        @php

                        $score = $department->average_score ?? 0;

                        @endphp

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                <strong>

                                    {{ $department->name }}

                                </strong>

                            </td>

                            <td>

                                {{ $department->employees_count }}

                            </td>

                            <td>

                                {{ number_format($score,2) }}

                            </td>

                            <td>

                                @if($score>=90)

                                <span class="badge bg-success">

                                    Excellent

                                </span>

                                @elseif($score>=80)

                                <span class="badge bg-primary">

                                    Very Good

                                </span>

                                @elseif($score>=70)

                                <span class="badge bg-info">

                                    Good

                                </span>

                                @elseif($score>=60)

                                <span class="badge bg-warning text-dark">

                                    Fair

                                </span>

                                @else

                                <span class="badge bg-danger">

                                    Poor

                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <i class="bi bi-building display-4 text-muted"></i>

                                <br><br>

                                No department performance found.

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