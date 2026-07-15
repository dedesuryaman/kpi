@extends('layouts.admin.app')

@section('title', 'Individual AI Analysis Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="bi bi-person-badge-fill text-primary me-2"></i>

                Individual AI Analysis Report

            </h4>

            <p class="text-muted mb-0">

                Detailed AI performance analysis for each employee.

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

            <button onclick="window.print()" class="btn btn-secondary">

                <i class="bi bi-printer me-1"></i>

                Print

            </button>

        </div>

    </div>

    {{-- Filter --}}

    <form method="GET">

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">Period</label>

                        <select name="period_id" class="form-select">

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected($selectedPeriod==$period->id)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">Department</label>

                        <select name="department_id" class="form-select">

                            <option value="">All Departments</option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}" @selected($selectedDepartment==$department->id)>

                                {{ $department->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2 d-grid">

                        <label>&nbsp;</label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    {{-- Summary --}}

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-start border-primary border-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Employees

                    </small>

                    <h3>{{ $summary['totalEmployee'] }}</h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-start border-success border-4">

                <div class="card-body">

                    <small class="text-muted">

                        AI Completed

                    </small>

                    <h3>{{ $summary['analyzed'] }}</h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-start border-warning border-4">

                <div class="card-body">

                    <small class="text-muted">

                        Pending

                    </small>

                    <h3>{{ $summary['notAnalyzed'] }}</h3>

                </div>

            </div>

        </div>

    </div>

    {{-- Table --}}

    <div class="card shadow-sm">

        <div class="card-header">

            <strong>

                Individual AI Analysis

            </strong>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Employee</th>

                            <th>Department</th>

                            <th>Position</th>

                            <th>Final Score</th>

                            <th>AI Summary</th>

                            <th>Recommendation</th>

                            <th>Status</th>
                            <th>Detail</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        @php

                        $analysis = $result->latestAiAnalysis;

                        @endphp

                        <tr>

                            <td>

                                {{ $results->firstItem() + $loop->index }}

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

                                <strong>

                                    {{ number_format($result->final_score,2) }}

                                </strong>

                            </td>

                            <td style="min-width:320px">

                                @if($analysis)

                                {{ \Illuminate\Support\Str::limit($analysis->summary,150) }}

                                @else

                                <span class="text-muted">

                                    AI analysis has not been generated.

                                </span>

                                @endif

                            </td>

                            <td style="min-width:220px">

                                @if($analysis)

                                {{ $analysis->recommendation ?
                                \Illuminate\Support\Str::limit($analysis->recommendation,100) : '-' }}


                                <div class="modal fade" id="analysisModal{{ $result->id }}" tabindex="-1">

                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">

                                        <div class="modal-content">

                                            <div class="modal-header bg-primary text-white">

                                                <h5 class="modal-title">

                                                    <i class="bi bi-stars me-2"></i>

                                                    AI Performance Analysis

                                                </h5>

                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal">
                                                </button>

                                            </div>

                                            <div class="modal-body">

                                                <div class="row mb-4">

                                                    <div class="col-md-6">

                                                        <table class="table table-sm">

                                                            <tr>

                                                                <th width="150">

                                                                    Employee

                                                                </th>

                                                                <td>

                                                                    {{ $result->employee->name }}

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <th>

                                                                    Department

                                                                </th>

                                                                <td>

                                                                    {{ $result->employee->department->name ?? '-' }}

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <th>

                                                                    Position

                                                                </th>

                                                                <td>

                                                                    {{ $result->employee->position->name ?? '-' }}

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <th>

                                                                    Final Score

                                                                </th>

                                                                <td>

                                                                    <strong>

                                                                        {{ number_format($result->final_score,2) }}

                                                                    </strong>

                                                                </td>

                                                            </tr>

                                                        </table>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <table class="table table-sm">

                                                            <tr>

                                                                <th width="150">

                                                                    Generated

                                                                </th>

                                                                <td>

                                                                    {{ $analysis->created_at->format('d M Y H:i') }}

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <th>

                                                                    Model

                                                                </th>

                                                                <td>

                                                                    {{ $analysis->model ?? 'Gemini AI' }}

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <th>

                                                                    Status

                                                                </th>

                                                                <td>

                                                                    <span class="badge bg-success">

                                                                        Completed

                                                                    </span>

                                                                </td>

                                                            </tr>

                                                        </table>

                                                    </div>

                                                </div>

                                                <hr>

                                                <h6 class="fw-bold mb-3">

                                                    <i class="bi bi-stars text-primary me-2"></i>

                                                    AI Analysis

                                                </h6>

                                                <div class="border rounded p-3 bg-light">

                                                    {!! nl2br(e($analysis->summary)) !!}

                                                </div>

                                                @if(!empty($analysis->recommendation))

                                                <hr>

                                                <h6 class="fw-bold mb-3">

                                                    <i class="bi bi-lightbulb text-warning me-2"></i>

                                                    Recommendation

                                                </h6>

                                                <div class="alert alert-warning mb-0">

                                                    {!! nl2br(e($analysis->recommendation)) !!}

                                                </div>

                                                @endif

                                            </div>

                                            <div class="modal-footer">

                                                <button class="btn btn-secondary" data-bs-dismiss="modal">

                                                    Close

                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                </div>



                                @else

                                -

                                @endif

                            </td>

                            <td class="text-center">

                                @if($analysis)

                                <span class="badge bg-success">

                                    Completed

                                </span>

                                @else

                                <span class="badge bg-warning text-dark">

                                    Pending

                                </span>

                                @endif

                            </td>
                            <td>
                                @if($analysis)
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#analysisModal{{ $result->id }}">
                                    <i class="bi bi-eye me-1"></i>
                                    👁 View
                                </button>


                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>


                        </tr>



                        @empty

                        <tr>

                            <td colspan="8" class="text-center py-5">

                                <i class="bi bi-stars display-4 text-muted"></i>

                                <div class="mt-3">

                                    No AI analysis available.

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