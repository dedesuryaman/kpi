@extends('layouts.admin.app')

@section('title', 'Department AI Analysis')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="bi bi-building text-primary me-2"></i>

                Department AI Analysis

            </h4>

            <p class="text-muted mb-0">

                AI analysis grouped by department to identify organizational performance trends.

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

    @php

    $groups = $results->getCollection()->groupBy(function ($item) {
    return $item->employee->department->name ?? 'No Department';
    });

    @endphp


    <div class="accordion" id="departmentAccordion">

        @forelse($groups as $department => $employees)

        @php

        $avgScore = round($employees->avg('final_score'), 2);

        $completed = $employees->filter(function($item){
        return !is_null($item->latestAiAnalysis);
        })->count();

        @endphp

        <div class="accordion-item shadow-sm mb-3 border-0">

            <h2 class="accordion-header" id="heading{{ $loop->iteration }}">

                <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}">

                    <div class="w-100 d-flex justify-content-between align-items-center">

                        <div>

                            <i class="bi bi-building text-primary me-2"></i>

                            <strong>{{ $department }}</strong>

                        </div>

                        <div class="d-flex gap-2 me-3">

                            <span class="badge bg-primary">

                                {{ $employees->count() }} Employee

                            </span>

                            <span class="badge bg-success">

                                Avg {{ number_format($avgScore,2) }}

                            </span>

                            <span class="badge bg-info">

                                AI {{ $completed }}/{{ $employees->count() }}

                            </span>

                        </div>

                    </div>

                </button>

            </h2>

            <div id="collapse{{ $loop->iteration }}"
                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                data-bs-parent="#departmentAccordion">

                <div class="accordion-body">

                    <div class="table-responsive">

                        <table class="table table-hover table-bordered align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th width="60">#</th>

                                    <th>Employee</th>

                                    <th>Position</th>

                                    <th width="100">Score</th>

                                    <th>AI Summary</th>

                                    <th width="120">Status</th>

                                    <th width="120">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($employees as $employee)

                                @php
                                $analysis = $employee->latestAiAnalysis;
                                @endphp

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                        <strong>{{ $employee->employee->name }}</strong>

                                    </td>

                                    <td>

                                        {{ $employee->employee->position->name ?? '-' }}

                                    </td>

                                    <td>

                                        <span class="badge bg-dark">

                                            {{ number_format($employee->final_score,2) }}

                                        </span>

                                    </td>

                                    <td>

                                        @if($analysis)

                                        {{ \Illuminate\Support\Str::limit($analysis->summary,120) }}

                                        @else

                                        <span class="text-muted">

                                            AI analysis has not been generated.

                                        </span>

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

                                    <td class="text-start">

                                        @if($analysis)

                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#analysisModal{{ $employee->id }}">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <div class="modal fade" id="analysisModal{{ $employee->id }}" tabindex="-1"
                                            aria-hidden="true">

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
                                                                        <th width="140">Employee</th>
                                                                        <td>{{ $employee->employee->name }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Department</th>
                                                                        <td>{{ $employee->employee->department->name ??
                                                                            '-' }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Position</th>
                                                                        <td>{{ $employee->employee->position->name ??
                                                                            '-' }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Final Score</th>
                                                                        <td>
                                                                            <span class="badge bg-success fs-6">
                                                                                {{
                                                                                number_format($employee->final_score,2)
                                                                                }}
                                                                            </span>
                                                                        </td>
                                                                    </tr>

                                                                </table>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <table class="table table-sm">

                                                                    <tr>
                                                                        <th width="140">Generated</th>
                                                                        <td>

                                                                            {{
                                                                            optional($analysis->created_at)->format('d M
                                                                            Y H:i') }}

                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Status</th>
                                                                        <td>

                                                                            <span class="badge bg-success">

                                                                                Completed

                                                                            </span>

                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Model</th>
                                                                        <td>

                                                                            {{ $analysis->model ?? 'Gemini AI' }}

                                                                        </td>
                                                                    </tr>

                                                                </table>

                                                            </div>

                                                        </div>

                                                        {{-- Executive Summary --}}

                                                        @if(!empty($analysis->summary))

                                                        <div class="card mb-3 border-primary">

                                                            <div class="card-header bg-primary text-white">

                                                                Executive Summary

                                                            </div>

                                                            <div class="card-body">

                                                                {!! nl2br(e($analysis->summary)) !!}

                                                            </div>

                                                        </div>

                                                        @endif


                                                        {{-- Complete Analysis --}}

                                                        @if(!empty($analysis->analysis))

                                                        <div class="card mb-3">

                                                            <div class="card-header">

                                                                AI Analysis

                                                            </div>

                                                            <div class="card-body">

                                                                {!! nl2br(e($analysis->analysis)) !!}

                                                            </div>

                                                        </div>

                                                        @endif


                                                        {{-- Recommendation --}}

                                                        @if(!empty($analysis->recommendation))

                                                        <div class="card border-success">

                                                            <div class="card-header bg-success text-white">

                                                                Recommendation

                                                            </div>

                                                            <div class="card-body">

                                                                {!! nl2br(e($analysis->recommendation)) !!}

                                                            </div>

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


                                        @endif

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        @empty

        <div class="alert alert-light text-center py-5">

            <i class="bi bi-building display-4 text-muted"></i>

            <h5 class="mt-3">

                No department analysis available.

            </h5>

        </div>

        @endforelse

    </div>

    <div class="mt-3">

        {{ $results->links() }}

    </div>

</div>

@endsection