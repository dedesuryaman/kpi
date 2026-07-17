@extends('layouts.admin.app')

@section('title','Punishment Review')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                Punishment Review
            </h3>

            <p class="text-muted mb-0">
                Review punishment recommendation before approval.
            </p>
        </div>

        <a href="{{ route('reward-punishment.punishment') }}" class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>
            Back

        </a>

    </div>

    <div class="row">

        {{-- LEFT --}}

        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Employee Information
                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%">Code</th>
                            <td>{{ $result->employee->employee_code }}</td>
                        </tr>

                        <tr>
                            <th width="40%">Employee</th>
                            <td>{{ $result->employee->name }}</td>
                        </tr>

                        <tr>
                            <th>Department</th>
                            <td>{{ $result->employee->department?->name }}</td>
                        </tr>

                        <tr>
                            <th>Period</th>
                            <td>{{ $result->period->name }}</td>
                        </tr>

                        <tr>
                            <th>Final Score</th>
                            <td>

                                <span class="badge
                                @if($result->final_score>=80)
                                    bg-success
                                @elseif($result->final_score>=70)
                                    bg-primary
                                @elseif($result->final_score>=60)
                                    bg-warning text-dark
                                @else
                                    bg-danger
                                @endif">

                                    {{ number_format($result->final_score,2) }}

                                </span>

                            </td>
                        </tr>

                    </table>

                </div>

            </div>


            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        System Recommendation
                    </h5>

                </div>

                <div class="card-body">

                    @if($result->final_score>=60)

                    <div class="alert alert-warning mb-0">

                        <i class="bi bi-person-workspace me-2"></i>

                        Coaching Recommended

                    </div>

                    @elseif($result->final_score>=50)

                    <div class="alert alert-danger mb-0">

                        <i class="bi bi-file-earmark-text me-2"></i>

                        Warning Letter Recommended

                    </div>

                    @else

                    <div class="alert alert-dark mb-0">

                        <i class="bi bi-exclamation-octagon me-2"></i>

                        Performance Improvement Plan Recommended

                    </div>

                    @endif

                </div>


            </div>

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Ai Punishment Recommendation
                    </h5>

                </div>

                <div class="card-body">

                    @if($result->aiAnalysis)

                    <div class="alert alert-info mb-0">

                        <i class="bi bi-person-workspace me-2"></i>

                        {!! $result->aiAnalysis->punishment_recommendation !!}

                    </div>

                    @else

                    <div class="alert alert-dark mb-0">

                        <i class="bi bi-exclamation-octagon me-2"></i>

                        Punishment Improvement Plan Recommended

                    </div>

                    @endif

                </div>


            </div>


        </div>

        {{-- RIGHT --}}

        <div class="col-lg-8">

            <form action="{{ route('reward-punishment.punishment.review.store',$result->id) }}" method="POST">

                @csrf

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            HR Review

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Punishment Type

                                </label>

                                <div class="mb-3">

                                    <select name="type" class="form-select" required>

                                        <option value="warning" {{ old('type', $review->type) == 'warning' ? 'selected'
                                            : '' }}>
                                            Warning
                                        </option>

                                        <option value="coaching" {{ old('type', $review->type) == 'coaching' ?
                                            'selected' : '' }}>
                                            Coaching
                                        </option>

                                        <option value="salary_cut" {{ old('type', $review->type) == 'salary_cut' ?
                                            'selected' : '' }}>
                                            Salary Cut
                                        </option>

                                        <option value="demotion" {{ old('type', $review->type) == 'demotion' ?
                                            'selected' : '' }}>
                                            Demotion
                                        </option>

                                        <option value="suspension" {{ old('type', $review->type) == 'suspension' ?
                                            'selected' : '' }}>
                                            Suspension
                                        </option>

                                        <option value="termination" {{ old('type', $review->type) == 'termination' ?
                                            'selected' : '' }}>
                                            Termination
                                        </option>

                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Severity

                                </label>

                                <select name="severity" class="form-select">

                                    <option value="Low" @selected(optional($review)->severity=="Low")>

                                        Low

                                    </option>

                                    <option value="Medium" @selected(optional($review)->severity=="Medium")>

                                        Medium

                                    </option>

                                    <option value="High" @selected(optional($review)->severity=="High")>

                                        High

                                    </option>

                                    <option value="Critical" @selected(optional($review)->severity=="Critical")>

                                        Critical

                                    </option>
                                </select>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Review Notes

                            </label>

                            <textarea name="notes" rows="7" class="form-control"
                                placeholder="Write HR review or manager notes...">{{ old('notes', $review->notes ?? '') }}</textarea>

                        </div>

                    </div>

                    <div class="card-footer bg-white d-flex justify-content-end">

                        <a href="{{ route('reward-punishment.index') }}" class="btn btn-light me-2">

                            Cancel

                        </a>

                        <button class="btn btn-danger">

                            <i class="bi bi-check-circle me-1"></i>

                            Save Review

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection