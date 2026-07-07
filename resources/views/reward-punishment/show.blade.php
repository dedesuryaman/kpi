@extends('layouts.admin.app')

@section('title','Reward Recommendation Detail')

@push('styles')

<style>
    .hero-card {

        border: none;

        overflow: hidden;

        border-radius: 22px;

        background: linear-gradient(135deg, #2563eb, #3b82f6, #6366f1);

        color: #fff;

    }

    .metric-card {

        border: none;

        border-radius: 18px;

        transition: .25s;

    }

    .metric-card:hover {

        transform: translateY(-6px);

        box-shadow: 0 20px 40px rgba(0, 0, 0, .12);

    }

    .metric-icon {

        width: 58px;

        height: 58px;

        border-radius: 16px;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 24px;

    }

    .avatar-xl {

        width: 95px;

        height: 95px;

        border-radius: 50%;

        background: #fff;

        color: #2563eb;

        font-size: 42px;

        font-weight: 700;

        display: flex;

        align-items: center;

        justify-content: center;

    }

    .info-item {

        border-bottom: 1px dashed #ececec;

        padding: 10px 0;

    }

    .info-item:last-child {

        border-bottom: none;

    }
</style>

@endpush

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="fa fa-award text-warning me-2"></i>

                Reward Recommendation

            </h2>

            <div class="text-muted">

                Executive Decision Dashboard

            </div>

        </div>

        <div>

            <a href="{{ route('reward-punishment.reward') }}" class="btn btn-light border">

                <i class="fa fa-arrow-left me-2"></i>

                Back

            </a>

            <a href="{{ route('reward-punishment.print',$result) }}" target="_blank" class="btn btn-dark">

                <i class="fa fa-print me-2"></i>

                Print

            </a>


            @php
            $recommendation = $result->latestRewardRecommendation;
            @endphp

            @if(!$recommendation)

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                <i class="fa fa-check me-2"></i>
                Approve Reward
            </button>

            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="fa fa-ban me-2"></i>
                Reject Recommendation
            </button>

            @elseif($recommendation->status == 'Approved')

            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="fa fa-ban me-2"></i>
                Reject Recommendation
            </button>

            @elseif($recommendation->status == 'Rejected')

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                <i class="fa fa-rotate-left me-2"></i>
                Approve Again
            </button>



            @endif

        </div>

    </div>
    <div class="card hero-card shadow-lg mb-4">

        <div class="card-body p-5">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <div class="d-flex align-items-center">

                        <div class="avatar-xl">

                            {{ strtoupper(substr($result->employee->name,0,1)) }}

                        </div>

                        <div class="ms-4">

                            <h2 class="fw-bold mb-1">

                                {{ $result->employee->name }}

                            </h2>

                            <div class="opacity-75">

                                {{ $result->employee->employee_code }}

                            </div>

                            <div class="mt-3">

                                <span class="badge bg-light text-dark">

                                    {{ $result->employee->department->name ?? '-'}}

                                </span>

                                <span class="badge bg-warning text-dark">

                                    Grade {{ $result->grade }}

                                </span>

                                <span class="badge bg-success">

                                    Rank #{{ $result->rank }}

                                </span>



                                @php
                                $recommendation = $result->latestRewardRecommendation;
                                @endphp

                                @if(!$recommendation)

                                <div
                                    class="badge bg-warning-subtle text-warning-emphasis border border-warning px-3 py-2 rounded-pill">
                                    <i class="fa fa-hourglass-half me-2"></i>
                                    Waiting for HR Approval
                                </div>

                                @elseif($recommendation->status == 'Approved')

                                <div
                                    class="badge bg-success-subtle text-success-emphasis border border-success px-3 py-2 rounded-pill">
                                    <i class="fa fa-circle-check me-2"></i>
                                    Approved by HR
                                </div>

                                @elseif($recommendation->status == 'Rejected')

                                <div
                                    class="badge bg-danger-subtle text-danger-emphasis border border-danger px-3 py-2 rounded-pill">
                                    <i class="fa fa-circle-xmark me-2"></i>
                                    Recommendation Rejected
                                </div>

                                @else

                                <div
                                    class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary px-3 py-2 rounded-pill">
                                    <i class="fa fa-clock me-2"></i>
                                    Under Review
                                </div>

                                @endif

                            </div>



                        </div>

                    </div>

                </div>

                <div class="col-lg-4 text-end">

                    <div class="display-3 fw-bold">

                        {{ number_format($result->final_score,2) }}

                    </div>

                    <div class="opacity-75">

                        Final KPI Score

                    </div>

                    <div class="mt-3">

                        <span class="badge bg-success px-4 py-2">

                            READY FOR REWARD

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card metric-card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Final Score

                            </small>

                            <h2 class="fw-bold mt-2">

                                {{ number_format($result->final_score,2) }}

                            </h2>

                        </div>

                        <div class="metric-icon bg-primary text-white">

                            <i class="fa fa-chart-line"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card metric-card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Average KPI

                            </small>

                            <h2 class="fw-bold text-success mt-2">

                                {{ number_format($result->average_score,2) }}

                            </h2>

                        </div>

                        <div class="metric-icon bg-success text-white">

                            <i class="fa fa-chart-bar"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card metric-card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Performance Grade

                            </small>

                            <h2 class="fw-bold text-warning mt-2">

                                {{ $result->grade }}

                            </h2>

                        </div>

                        <div class="metric-icon bg-warning text-dark">

                            <i class="fa fa-star"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card metric-card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Ranking

                            </small>

                            <h2 class="fw-bold text-danger mt-2">

                                #{{ $result->rank }}

                            </h2>

                        </div>

                        <div class="metric-icon bg-danger text-white">

                            <i class="fa fa-trophy"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="approveModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-success text-white">

                    <h5>

                        <i class="fa fa-award me-2"></i>

                        Reward Approval

                    </h5>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal">

                    </button>

                </div>

                <form method="POST" action="{{ route('reward-punishment.approve',$result) }}">

                    @csrf

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-lg-6">

                                <label class="form-label">

                                    Reward Type

                                </label>

                                <select name="reward_type" class="form-select" required>

                                    <option value="Promotion">

                                        Promotion

                                    </option>

                                    <option value="Salary Increase">

                                        Salary Increase

                                    </option>

                                    <option value="Performance Bonus">

                                        Performance Bonus

                                    </option>

                                    <option value="Certificate">

                                        Certificate

                                    </option>

                                </select>

                            </div>

                            <div class="col-lg-6">

                                <label class="form-label">

                                    Effective Date

                                </label>

                                <input type="date" name="effective_date" class="form-control"
                                    value="{{ now()->toDateString() }}">

                            </div>

                        </div>

                        <div class="mt-3">

                            <label class="form-label">

                                HR Notes

                            </label>

                            <textarea class="form-control" rows="5" name="approval_notes"></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit" class="btn btn-success">

                            <i class="fa fa-check me-2"></i>

                            Approve Reward

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div class="modal fade" id="rejectModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-danger text-white">

                    <h5>

                        Reject Recommendation

                    </h5>

                </div>

                <form method="POST" action="{{ route('reward-punishment.reject', $result) }}">

                    @csrf

                    <div class="modal-body">

                        <label>

                            Reason

                        </label>

                        <textarea required name="approval_notes" rows="6" class="form-control"></textarea>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button class="btn btn-danger">

                            Reject

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    @php

    $recommendation = $suggestedReward ?? 'No Recommendation' ;

    // match(true){

    // $result->final_score >=95 => 'Promotion',

    // $result->final_score >=90 => 'Salary Increase',

    // $result->final_score >=85 => 'Performance Bonus',

    // $result->final_score >=80 => 'Certificate',

    // default => 'Need Coaching'

    // };

    @endphp

    <div class="row mb-4">

        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        Employee Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="info-item d-flex justify-content-between">

                        <span class="text-muted">

                            Employee Code

                        </span>

                        <strong>

                            {{ $result->employee->employee_code }}

                        </strong>

                    </div>

                    <div class="info-item d-flex justify-content-between">

                        <span class="text-muted">

                            Department

                        </span>

                        <strong>

                            {{ $result->employee->department->name }}

                        </strong>

                    </div>

                    <div class="info-item d-flex justify-content-between">

                        <span class="text-muted">

                            Evaluation Period

                        </span>

                        <strong>

                            {{ $result->period->name }}

                        </strong>

                    </div>

                    <div class="info-item d-flex justify-content-between">

                        <span class="text-muted">

                            Performance Grade

                        </span>

                        <strong>

                            {{ $result->grade }}

                        </strong>

                    </div>

                    <div class="info-item d-flex justify-content-between">

                        <span class="text-muted">

                            Current Rank

                        </span>

                        <strong>

                            #{{ $result->rank }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0">

                        <i class="fa fa-lightbulb me-2"></i>

                        System Recommendation

                    </h5>

                </div>

                <div class="card-body">

                    <h2 class="fw-bold text-success">

                        {{ $recommendation }}

                    </h2>

                    <p class="text-muted">

                        The recommendation is automatically generated based on the final KPI score, weighted KPI
                        calculation, employee ranking, and overall performance evaluation for the selected period.

                    </p>

                    <div class="progress mb-3" style="height:10px;">

                        <div class="progress-bar bg-success" style="width:{{ min($result->final_score,100) }}%">

                        </div>

                    </div>


                    @php
                    $recommendation = $result->latestRewardRecommendation;
                    @endphp

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block">
                                Performance Score
                            </small>
                            <h4 class="fw-bold mb-0">
                                {{ number_format($result->final_score, 2) }}
                            </h4>
                        </div>

                        <div class="text-end">
                            <small class="text-muted d-block">
                                Reward Approval
                            </small>

                            @if(!$recommendation)
                            <span class="badge bg-secondary px-3 py-2">
                                <i class="fas fa-hourglass-half me-1"></i>
                                Not Submitted
                            </span>

                            @elseif($recommendation->status == \App\Models\RewardRecommendation::STATUS_PENDING)
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="fas fa-clock me-1"></i>
                                Waiting for Approval
                            </span>

                            @elseif($recommendation->status == \App\Models\RewardRecommendation::STATUS_APPROVED)
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>
                                Approved
                            </span>

                            @elseif($recommendation->status == \App\Models\RewardRecommendation::STATUS_REJECTED)
                            <span class="badge bg-danger px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>
                                Rejected
                            </span>

                            @else
                            <span class="badge bg-secondary px-3 py-2">
                                {{ $recommendation->status }}
                            </span>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection