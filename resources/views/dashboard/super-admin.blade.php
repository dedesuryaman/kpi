@extends('layouts.admin.app')

@section('title', 'Super Admin Dashboard')

@section('content')

<div class="container-fluid">

    {{-- ==========================
    Dashboard Style
    =========================== --}}

    <style>
        .dashboard-card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            transition: .3s;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, .15);
        }

        .glass-card {
            background: linear-gradient(135deg, #ffffff, #f8fbff);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .3);
        }

        .card-title-small {
            font-size: .80rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: .8px;
            font-weight: 600;
        }

        .card-number {
            font-size: 2rem;
            font-weight: 700;
            color: #212529;
        }

        .dashboard-header {

            background: linear-gradient(135deg, #0d6efd, #3d8bfd);

            border-radius: 20px;

            padding: 35px;

            color: white;

            overflow: hidden;

            position: relative;

        }

        .dashboard-header::after {

            content: "";

            position: absolute;

            width: 250px;

            height: 250px;

            right: -70px;

            top: -70px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .08);

        }

        .dashboard-header::before {

            content: "";

            position: absolute;

            width: 150px;

            height: 150px;

            left: -50px;

            bottom: -50px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .08);

        }

        .quick-btn {

            border-radius: 12px;

            padding: 12px 18px;

            font-weight: 600;

            transition: .25s;

        }

        .quick-btn:hover {

            transform: translateY(-2px);

        }

        .header-info {

            background: rgba(255, 255, 255, .15);

            padding: 15px 20px;

            border-radius: 15px;

        }

        .header-info small {

            color: rgba(255, 255, 255, .75);

        }

        @media(max-width:991px) {

            .dashboard-header {

                text-align: center;

            }

            .header-info {

                margin-top: 20px;

            }

            .quick-action {

                margin-top: 25px;

            }

        }
    </style>


    {{-- ==========================
    Header
    =========================== --}}

    <div class="dashboard-header mb-4">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <h2 class="fw-bold mb-2">

                    <i class="bi bi-speedometer2 me-2"></i>

                    Super Admin Dashboard

                </h2>

                <p class="mb-4">

                    Welcome back,

                    <strong>{{ auth()->user()->name }}</strong>

                    👋

                </p>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <div class="header-info">

                            <small>Active Period</small>

                            <h5 class="mb-0 mt-2 fw-bold">

                                {{ $activePeriod->name ?? '-' }}

                            </h5>

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <div class="header-info">

                            <small>Today</small>

                            <h5 class="mb-0 mt-2 fw-bold">

                                {{ now()->format('d M Y') }}

                            </h5>

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <div class="header-info">

                            <small>Current Time</small>

                            <h5 class="mb-0 mt-2 fw-bold">

                                <span id="clock">

                                    {{ now()->format('H:i:s') }}

                                </span>

                            </h5>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="quick-action">

                    <h6 class="fw-bold mb-3">

                        Quick Action

                    </h6>

                    <div class="d-grid gap-2">

                        <a href="{{ route('employees.index') }}" class="btn btn-light quick-btn">

                            <i class="bi bi-people-fill me-2"></i>

                            Employee

                        </a>

                        <a href="{{ route('kpi.master.index') }}" class="btn btn-warning quick-btn">

                            <i class="bi bi-list-check me-2"></i>

                            KPI Master

                        </a>

                        <a href="{{ route('abc.index') }}" class="btn btn-success quick-btn">

                            <i class="bi bi-cpu-fill me-2"></i>

                            Run ABC

                        </a>

                        <a href="{{ route('mdp.index') }}" class="btn btn-dark quick-btn">

                            <i class="bi bi-diagram-3-fill me-2"></i>

                            MDP Analysis

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================
    Summary Cards
    (Part 2A-2)
    =========================== --}}

    <div class="row">
        {{-- =========================================================
        Summary Card 1
        ========================================================= --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card glass-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="card-title-small">
                                Total Employee
                            </div>

                            <div class="card-number mt-2">
                                {{ number_format($employeeCount) }}
                            </div>

                            <div class="text-success mt-3">

                                <i class="bi bi-arrow-up-circle-fill"></i>

                                Active Employee

                            </div>

                        </div>

                        <div>

                            <div class="rounded-circle bg-primary bg-opacity-10
                                       d-flex align-items-center justify-content-center"
                                style="width:72px;height:72px;">

                                <i class="bi bi-people-fill
                                          text-primary fs-2"></i>

                            </div>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-primary" style="width:100%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================================
        Summary Card 2
        ========================================================= --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card glass-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="card-title-small">

                                Department

                            </div>

                            <div class="card-number mt-2">

                                {{ number_format($departmentCount) }}

                            </div>

                            <div class="text-info mt-3">

                                <i class="bi bi-diagram-3-fill"></i>

                                Active Department

                            </div>

                        </div>

                        <div>

                            <div class="rounded-circle bg-info bg-opacity-10
                                       d-flex align-items-center justify-content-center"
                                style="width:72px;height:72px;">

                                <i class="bi bi-building
                                          text-info fs-2"></i>

                            </div>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-info" style="width:100%">
                        </div>

                    </div>

                </div>

            </div>

        </div>
        {{-- =========================================================
        Summary Card 3 : Position
        ========================================================= --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card glass-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="card-title-small">
                                Position
                            </div>

                            <div class="card-number mt-2">
                                {{ number_format($positionCount) }}
                            </div>

                            <div class="text-warning mt-3">

                                <i class="bi bi-person-badge-fill me-1"></i>

                                Registered Position

                            </div>

                        </div>

                        <div>

                            <div class="rounded-circle bg-warning bg-opacity-10
                                       d-flex align-items-center justify-content-center"
                                style="width:72px;height:72px;">

                                <i class="bi bi-briefcase-fill
                                          text-warning fs-2"></i>

                            </div>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-warning" style="width:100%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================================
        Summary Card 4 : KPI Master
        ========================================================= --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card glass-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="card-title-small">
                                KPI Master
                            </div>

                            <div class="card-number mt-2">
                                {{ number_format($kpiMasterCount) }}
                            </div>

                            <div class="text-danger mt-3">

                                <i class="bi bi-clipboard2-data-fill me-1"></i>

                                KPI Categories

                            </div>

                        </div>

                        <div>

                            <div class="rounded-circle bg-danger bg-opacity-10
                                       d-flex align-items-center justify-content-center"
                                style="width:72px;height:72px;">

                                <i class="bi bi-bar-chart-fill
                                          text-danger fs-2"></i>

                            </div>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-danger" style="width:100%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
    Performance Summary
    (Part 2A-3)
    ========================================================= --}}

    <div class="row mt-2">
        {{-- =========================================================
        Performance Card 1 : Average Score
        ========================================================= --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted text-uppercase fw-semibold">
                                Average Score
                            </small>

                            <h2 class="fw-bold mt-2 text-primary">
                                {{ number_format($averageScore, 2) }}
                            </h2>

                            <span class="badge bg-primary-subtle text-primary">
                                Overall KPI
                            </span>

                        </div>

                        <div class="text-primary">

                            <i class="bi bi-speedometer2" style="font-size:55px;opacity:.18"></i>

                        </div>

                    </div>

                    @php
                    $avgWidth = min(100, max(0, $averageScore));
                    @endphp

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-primary" style="width:{{ $avgWidth }}%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================================
        Performance Card 2 : Highest Score
        ========================================================= --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted text-uppercase fw-semibold">
                                Highest Score
                            </small>

                            <h2 class="fw-bold mt-2 text-success">
                                {{ number_format($highestScore,2) }}
                            </h2>

                            <span class="badge bg-success-subtle text-success">
                                Top Performance
                            </span>

                        </div>

                        <div class="text-success">

                            <i class="bi bi-trophy-fill" style="font-size:55px;opacity:.18"></i>

                        </div>

                    </div>

                    @php
                    $highWidth = min(100, max(0, $highestScore));
                    @endphp

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-success" style="width:{{ $highWidth }}%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================================
        Performance Card 3 : Lowest Score
        ========================================================= --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted text-uppercase fw-semibold">
                                Lowest Score
                            </small>

                            <h2 class="fw-bold mt-2 text-danger">
                                {{ number_format($lowestScore,2) }}
                            </h2>

                            <span class="badge bg-danger-subtle text-danger">
                                Need Improvement
                            </span>

                        </div>

                        <div class="text-danger">

                            <i class="bi bi-graph-down-arrow" style="font-size:55px;opacity:.18"></i>

                        </div>

                    </div>

                    @php
                    $lowWidth = min(100, max(0, $lowestScore));
                    @endphp

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-danger" style="width:{{ $lowWidth }}%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =========================================================
        Performance Card 4 : Completion Rate
        ========================================================= --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted text-uppercase fw-semibold">
                                Completion Rate
                            </small>

                            <h2 class="fw-bold mt-2 text-warning">
                                {{ number_format($completionRate,1) }}%
                            </h2>

                            <span class="badge bg-warning-subtle text-warning">

                                {{ $completedAssessment }}

                                / {{ $employeeCount }} Completed

                            </span>

                        </div>

                        <div class="text-warning">

                            <i class="bi bi-check2-circle" style="font-size:55px;opacity:.18"></i>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-warning" style="width:{{ $completionRate }}%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
    Part 2B
    Approval Summary
    ========================================================= --}}
    <div class="row">

        {{-- ==========================================
        Pending
        =========================================== --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted text-uppercase fw-semibold">

                                Pending

                            </small>

                            <h2 class="fw-bold text-warning mt-2">

                                {{ number_format($pendingReward) }}

                            </h2>

                            <span class="badge bg-warning-subtle text-warning">

                                Waiting Approval

                            </span>

                        </div>

                        <div class="rounded-circle bg-warning bg-opacity-10
                                    d-flex align-items-center justify-content-center" style="width:70px;height:70px">

                            <i class="bi bi-hourglass-split
                                      text-warning fs-2"></i>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-warning" style="width:100%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ==========================================
        Approved
        =========================================== --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted text-uppercase fw-semibold">

                                Approved

                            </small>

                            <h2 class="fw-bold text-success mt-2">

                                {{ number_format($approvedReward) }}

                            </h2>

                            <span class="badge bg-success-subtle text-success">

                                Completed

                            </span>

                        </div>

                        <div class="rounded-circle bg-success bg-opacity-10
                                    d-flex align-items-center justify-content-center" style="width:70px;height:70px">

                            <i class="bi bi-check-circle-fill
                                      text-success fs-2"></i>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-success" style="width:100%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ==========================================
        Rejected
        =========================================== --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted text-uppercase fw-semibold">

                                Rejected

                            </small>

                            <h2 class="fw-bold text-danger mt-2">

                                {{ number_format($rejectedReward) }}

                            </h2>

                            <span class="badge bg-danger-subtle text-danger">

                                Need Revision

                            </span>

                        </div>

                        <div class="rounded-circle bg-danger bg-opacity-10
                                    d-flex align-items-center justify-content-center" style="width:70px;height:70px">

                            <i class="bi bi-x-circle-fill
                                      text-danger fs-2"></i>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-danger" style="width:100%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ==========================================
        Draft
        =========================================== --}}

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted text-uppercase fw-semibold">

                                Draft

                            </small>

                            <h2 class="fw-bold text-secondary mt-2">

                                {{ number_format($draftReward) }}

                            </h2>

                            <span class="badge bg-secondary-subtle text-secondary">

                                Not Submitted

                            </span>

                        </div>

                        <div class="rounded-circle bg-secondary bg-opacity-10
                                    d-flex align-items-center justify-content-center" style="width:70px;height:70px">

                            <i class="bi bi-file-earmark-text-fill
                                      text-secondary fs-2"></i>

                        </div>

                    </div>

                    <div class="progress mt-4" style="height:8px">

                        <div class="progress-bar bg-secondary" style="width:100%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
    Part 2B-2
    Top 10 Performer
    ========================================================= --}}
    <div class="row">

        <div class="col-lg-8 mb-4">

            <div class="card dashboard-card border-0">

                <div class="card-header bg-white border-0 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">

                                <i class="bi bi-trophy-fill text-warning me-2"></i>

                                Top 10 Performer

                            </h5>

                            <small class="text-muted">

                                Employee Performance Ranking

                            </small>

                        </div>

                        <span class="badge bg-primary">

                            {{ $topPerformers->count() }} Employee

                        </span>

                    </div>

                </div>

                <div class="card-body p-0">

                    @forelse($topPerformers as $index => $performer)

                    @php

                    $employee = $performer->employee;

                    $initial = strtoupper(substr($employee->name ?? 'U',0,1));

                    $score = round($performer->total_score,2);

                    $width = min(100,max(0,$score));

                    @endphp

                    <div class="px-4 py-3 border-bottom">

                        <div class="row align-items-center">

                            <div class="col-md-1 text-center">

                                @if($index==0)

                                <span class="fs-3">🥇</span>

                                @elseif($index==1)

                                <span class="fs-3">🥈</span>

                                @elseif($index==2)

                                <span class="fs-3">🥉</span>

                                @else

                                <span class="badge bg-light text-dark">

                                    #{{ $index+1 }}

                                </span>

                                @endif

                            </div>

                            <div class="col-md-1">

                                <div class="rounded-circle bg-primary text-white fw-bold
                                                d-flex align-items-center justify-content-center"
                                    style="width:48px;height:48px">

                                    {{ $initial }}

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="fw-semibold">

                                    {{ $employee->name }}

                                </div>

                                <small class="text-muted">

                                    {{ $employee->department->name ?? '-' }}

                                </small>

                            </div>

                            <div class="col-md-4">

                                <div class="progress mb-2" style="height:8px">

                                    <div class="progress-bar bg-success" style="width:{{ $width }}%">

                                    </div>

                                </div>

                                <small class="text-muted">

                                    KPI Progress

                                </small>

                            </div>

                            <div class="col-md-2 text-end">

                                <h5 class="fw-bold text-success mb-1">

                                    {{ number_format($score,2) }}

                                </h5>

                                @php

                                $badge='secondary';

                                if($performer->grade=='A') $badge='success';
                                elseif($performer->grade=='B') $badge='primary';
                                elseif($performer->grade=='C') $badge='warning';
                                elseif($performer->grade=='D') $badge='danger';

                                @endphp

                                <span class="badge bg-{{ $badge }}">

                                    Grade {{ $performer->grade }}

                                </span>

                            </div>

                        </div>

                    </div>

                    @empty

                    <div class="text-center py-5">

                        <i class="bi bi-people fs-1 text-secondary"></i>

                        <h5 class="mt-3">

                            No Performance Data

                        </h5>

                        <p class="text-muted mb-0">

                            There are no employee performance records available.

                        </p>

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

        {{-- =========================================================
        Leaderboard Summary
        ========================================================= --}}

        <div class="col-lg-4 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-award-fill text-warning me-2"></i>

                        Leaderboard Summary

                    </h5>

                </div>

                <div class="card-body">

                    @php

                    $topEmployee = $topPerformers->first();

                    $averageTop10 = $topPerformers->avg('total_score');

                    @endphp

                    {{-- Top Performer --}}

                    @if($topEmployee)

                    <div class="text-center mb-4">

                        <div class="rounded-circle bg-warning bg-opacity-10
                                                d-inline-flex align-items-center justify-content-center"
                            style="width:90px;height:90px">

                            <i class="bi bi-trophy-fill text-warning" style="font-size:42px"></i>

                        </div>

                        <h5 class="mt-3 fw-bold">

                            {{ $topEmployee->employee->name }}

                        </h5>

                        <div class="text-muted">

                            {{ $topEmployee->employee->department->name ?? '-' }}

                        </div>

                        <h2 class="fw-bold text-success mt-3">

                            {{ number_format($topEmployee->total_score,2) }}

                        </h2>

                        <span class="badge bg-success">

                            Grade {{ $topEmployee->grade }}

                        </span>

                    </div>

                    @endif

                    <hr>

                    {{-- Average Top 10 --}}

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>

                            <small class="text-muted">

                                Average Top 10

                            </small>

                            <h4 class="fw-bold text-primary mb-0">

                                {{ number_format($averageTop10,2) }}

                            </h4>

                        </div>

                        <i class="bi bi-graph-up-arrow text-primary fs-2"></i>

                    </div>

                    <div class="progress mb-4" style="height:8px">

                        <div class="progress-bar bg-primary" style="width:{{ min(100,$averageTop10) }}%">

                        </div>

                    </div>

                    {{-- Highest Score --}}

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span>

                            Highest Score

                        </span>

                        <span class="fw-bold text-success">

                            {{ number_format($highestScore,2) }}

                        </span>

                    </div>

                    {{-- Average Score --}}

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span>

                            Average Score

                        </span>

                        <span class="fw-bold text-primary">

                            {{ number_format($averageScore,2) }}

                        </span>

                    </div>

                    {{-- Completion Rate --}}

                    <div class="d-flex justify-content-between align-items-center">

                        <span>

                            Completion

                        </span>

                        <span class="badge bg-warning text-dark">

                            {{ number_format($completionRate,1) }}%

                        </span>

                    </div>

                    <div class="progress mt-3" style="height:8px">

                        <div class="progress-bar bg-warning" style="width:{{ $completionRate }}%">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
    Part 2B-3
    Recent Activity Timeline
    ========================================================= --}}

    <div class="row">

        {{-- =========================================================
        Recent Activity
        ========================================================= --}}

        <div class="col-lg-12">

            <div class="card dashboard-card border-0">

                <div class="card-header bg-white border-0 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">

                                <i class="bi bi-clock-history text-primary me-2"></i>

                                Recent Activity

                            </h5>

                            <small class="text-muted">

                                Latest Reward Recommendation Activity

                            </small>

                        </div>

                        <span class="badge bg-primary">

                            {{ $recentRewards->count() }} Activities

                        </span>

                    </div>

                </div>

                <div class="card-body">

                    @forelse($recentRewards as $reward)

                    @php

                    switch($reward->status){

                    case 'Approved':
                    $color='success';
                    $icon='check-circle-fill';
                    break;

                    case 'Rejected':
                    $color='danger';
                    $icon='x-circle-fill';
                    break;

                    case 'Pending':
                    $color='warning';
                    $icon='hourglass-split';
                    break;

                    default:
                    $color='secondary';
                    $icon='file-earmark-fill';

                    }

                    @endphp

                    <div class="d-flex mb-4">

                        {{-- Timeline Icon --}}

                        <div class="me-3">

                            <div class="rounded-circle bg-{{ $color }} bg-opacity-10
                                            d-flex align-items-center justify-content-center"
                                style="width:55px;height:55px;">

                                <i class="bi bi-{{ $icon }}
    
                                              text-{{ $color }} fs-4"></i>

                            </div>

                        </div>

                        {{-- Timeline Content --}}

                        <div class="flex-grow-1">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <h6 class="fw-bold mb-1">

                                        {{ $reward->performanceResult->employee->name ?? '-' }}

                                    </h6>

                                    <small class="text-muted">

                                        {{ $reward->performanceResult->employee->department->name ?? '-' }}

                                    </small>

                                </div>

                                <span class="badge bg-{{ $color }}">

                                    {{ $reward->status }}

                                </span>

                            </div>

                            <div class="mt-2">

                                <span class="text-muted">

                                    Reward :

                                </span>

                                <strong>

                                    {{ $reward->reward_type }}

                                </strong>

                            </div>

                            @if($reward->notes)

                            <div class="mt-2">

                                <small class="text-muted">

                                    {{ $reward->notes }}

                                </small>

                            </div>

                            @endif

                            <div class="mt-2">

                                <small class="text-secondary">

                                    <i class="bi bi-calendar-event me-1"></i>

                                    {{ $reward->created_at->format('d M Y H:i') }}

                                </small>

                            </div>

                        </div>

                    </div>

                    @if(!$loop->last)

                    <hr>

                    @endif

                    @empty

                    <div class="text-center py-5">

                        <i class="bi bi-clock-history display-3 text-secondary"></i>

                        <h5 class="mt-3">

                            No Recent Activity

                        </h5>

                        <p class="text-muted mb-0">

                            Reward recommendation activity will appear here.

                        </p>

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
    Part 2C-1
    Department Performance & ABC Summary
    ========================================================= --}}

    <div class="row">

        {{-- =====================================================
        Department Performance
        ====================================================== --}}

        <div class="col-lg-8 mb-4">

            <div class="card dashboard-card border-0">

                <div class="card-header bg-white border-0">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">

                                <i class="bi bi-building text-primary me-2"></i>

                                Department Performance

                            </h5>

                            <small class="text-muted">

                                Average KPI Score by Department

                            </small>

                        </div>

                        <span class="badge bg-primary">

                            {{ $departmentPerformance->count() }} Department

                        </span>

                    </div>

                </div>

                <div class="card-body">

                    <div style="height:350px">

                        <canvas id="departmentChart"></canvas>

                    </div>


                    @forelse($departmentPerformance as $department)

                    @php

                    $score = round($department->average_score,2);

                    $width = min(100,max(0,$score));

                    if($score >= 90){

                    $color='success';

                    }elseif($score >=80){

                    $color='primary';

                    }elseif($score >=70){

                    $color='warning';

                    }else{

                    $color='danger';

                    }

                    @endphp

                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <div>

                                <strong>

                                    {{ $department->name }}

                                </strong>

                            </div>

                            <div>

                                <span class="badge bg-{{ $color }}">

                                    {{ number_format($score,2) }}

                                </span>

                            </div>

                        </div>

                        <div class="progress" style="height:10px">

                            <div class="progress-bar bg-{{ $color }}" style="width:{{ $width }}%">

                            </div>

                        </div>

                    </div>

                    @empty

                    <div class="text-center py-5">

                        <i class="bi bi-bar-chart display-5 text-secondary"></i>

                        <h5 class="mt-3">

                            No Department Performance

                        </h5>

                    </div>

                    @endforelse


                    <div class="card dashboard-card border-0 mt-4">

                        <div class="card-header bg-white border-0">

                            <h5 class="fw-bold">

                                <i class="bi bi-graph-up-arrow text-primary me-2"></i>

                                KPI Trend

                            </h5>

                        </div>

                        <div class="card-body">

                            <div style="height:350px">

                                <canvas id="kpiTrendChart"></canvas>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- =====================================================
        ABC Optimization
        ====================================================== --}}

        <div class="col-lg-4 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold">

                        <i class="bi bi-cpu-fill text-success me-2"></i>

                        ABC Optimization

                    </h5>

                </div>

                <div class="card-body">

                    @if($latestABC)

                    <div class="text-center mb-4">

                        <div class="rounded-circle bg-success bg-opacity-10
                                        d-inline-flex
                                        align-items-center
                                        justify-content-center" style="width:90px;height:90px">

                            <i class="bi bi-cpu-fill
    
                                          text-success" style="font-size:40px"></i>

                        </div>

                    </div>

                    <table class="table table-borderless">

                        <tr>

                            <td>

                                Execution

                            </td>

                            <th class="text-end">

                                {{ $latestABC->created_at->format('d M Y') }}

                            </th>

                        </tr>

                        <tr>

                            <td>

                                Best Fitness

                            </td>

                            <th class="text-end text-success">

                                {{ number_format($latestABC->best_fitness ?? 0,4) }}

                            </th>

                        </tr>

                        <tr>

                            <td>

                                Total Employee

                            </td>

                            <th class="text-end">

                                {{ $employeeCount }}

                            </th>

                        </tr>

                        <tr>

                            <td>

                                Status

                            </td>

                            <th class="text-end">

                                <span class="badge bg-success">

                                    Completed

                                </span>

                            </th>

                        </tr>

                    </table>

                    <hr>

                    <a href="{{ route('abc.index') }}" class="btn btn-success w-100">

                        <i class="bi bi-arrow-right-circle me-2"></i>

                        View ABC Result

                    </a>

                    @else

                    <div class="text-center py-5">

                        <i class="bi bi-cpu display-4 text-secondary"></i>

                        <h5 class="mt-3">

                            No ABC Result

                        </h5>

                        <p class="text-muted">

                            Optimization has not been executed.

                        </p>

                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
    Part 2C-2
    MDP Analysis & Grade Distribution
    ========================================================= --}}
    {{-- =========================================================
    Part 2C-2
    MDP Analysis & Grade Distribution
    ========================================================= --}}

    <div class="row">

        {{-- =====================================================
        MDP Analysis
        ====================================================== --}}

        <div class="col-lg-4 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-diagram-3-fill text-primary me-2"></i>

                        MDP Analysis

                    </h5>

                </div>

                <div class="card-body">

                    @if($latestMDP)

                    <div class="text-center mb-4">

                        <div class="rounded-circle bg-primary bg-opacity-10
                                        d-inline-flex
                                        align-items-center
                                        justify-content-center" style="width:90px;height:90px">

                            <i class="bi bi-diagram-3-fill
                                          text-primary" style="font-size:40px"></i>

                        </div>

                    </div>

                    <table class="table table-borderless">

                        <tr>
                            <td>Analysis Date</td>
                            <th class="text-end">

                                {{ $latestMDP->created_at->format('d M Y') }}

                            </th>
                        </tr>

                        <tr>
                            <td>Status</td>
                            <th class="text-end">

                                <span class="badge bg-success">

                                    Completed

                                </span>

                            </th>
                        </tr>

                        <tr>
                            <td>Policy</td>
                            <th class="text-end">

                                {{ $latestMDP->optimal_policy ?? '-' }}

                            </th>
                        </tr>

                        <tr>
                            <td>Reward</td>
                            <th class="text-end text-primary">

                                {{ number_format($latestMDP->expected_reward ?? 0,2) }}

                            </th>
                        </tr>

                    </table>

                    <hr>

                    <a href="{{ route('mdp.index') }}" class="btn btn-primary w-100">

                        <i class="bi bi-arrow-right-circle me-2"></i>

                        View Analysis

                    </a>

                    @else

                    <div class="text-center py-5">

                        <i class="bi bi-diagram-3 display-4 text-secondary"></i>

                        <h5 class="mt-3">

                            No Analysis

                        </h5>

                        <p class="text-muted mb-0">

                            MDP analysis has not been executed.

                        </p>

                    </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
        Grade Distribution
        ====================================================== --}}

        <div class="col-lg-8 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-header bg-white border-0">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">

                                <i class="bi bi-pie-chart-fill text-success me-2"></i>

                                Grade Distribution

                            </h5>

                            <small class="text-muted">

                                Employee Performance Grade

                            </small>

                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-md-6">

                            <canvas id="gradeChart" height="260"></canvas>

                        </div>

                        <div class="col-md-6">

                            @php

                            $grades = ['A','B','C','D','E'];

                            $colors = [
                            'success',
                            'primary',
                            'warning',
                            'danger',
                            'secondary'
                            ];

                            @endphp

                            @foreach($grades as $i => $grade)

                            @php

                            $total = $gradeDistribution[$grade] ?? 0;

                            @endphp

                            <div class="d-flex
                                            justify-content-between
                                            align-items-center
                                            mb-3">

                                <div>

                                    <span class="badge bg-{{ $colors[$i] }} me-2">

                                        {{ $grade }}

                                    </span>

                                    Grade {{ $grade }}

                                </div>

                                <strong>

                                    {{ $total }}

                                </strong>

                            </div>

                            <div class="progress mb-4" style="height:8px">

                                <div class="progress-bar
                                                bg-{{ $colors[$i] }}" style="width:{{ min(100,$total*10) }}%">
                                </div>

                            </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
    Part 2C-3
    Reward Statistics & System Information
    ========================================================= --}}
    {{-- =========================================================
    Part 2C-3
    Reward Statistics & System Information
    ========================================================= --}}

    <div class="row">

        {{-- =====================================================
        Reward Statistics
        ====================================================== --}}

        <div class="col-lg-6 mb-4">

            <div class="card dashboard-card border-0">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-gift-fill text-danger me-2"></i>

                        Reward Statistics

                    </h5>

                </div>

                <div class="card-body">

                    @php

                    $totalReward = $approvedReward +
                    $pendingReward +
                    $draftReward +
                    $rejectedReward;

                    @endphp


                    <div style="height:300px">
                        <canvas id="rewardChart"></canvas>
                    </div>

                    <hr>

                    <div class="row text-center">

                        <div class="col-3">

                            <h5 class="fw-bold text-success">

                                {{ $approvedReward }}

                            </h5>

                            <small class="text-muted">

                                Approved

                            </small>

                        </div>

                        <div class="col-3">

                            <h5 class="fw-bold text-warning">

                                {{ $pendingReward }}

                            </h5>

                            <small class="text-muted">

                                Pending

                            </small>

                        </div>

                        <div class="col-3">

                            <h5 class="fw-bold text-danger">

                                {{ $rejectedReward }}

                            </h5>

                            <small class="text-muted">

                                Rejected

                            </small>

                        </div>

                        <div class="col-3">

                            <h5 class="fw-bold text-secondary">

                                {{ $draftReward }}

                            </h5>

                            <small class="text-muted">

                                Draft

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- =====================================================
        System Information
        ====================================================== --}}

        <div class="col-lg-6 mb-4">

            <div class="card dashboard-card border-0 h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-server text-primary me-2"></i>

                        System Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless align-middle">

                        <tr>

                            <td width="45%">

                                Laravel Version

                            </td>

                            <td class="text-end">

                                <span class="badge bg-danger">

                                    Laravel {{ app()->version() }}

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                PHP Version

                            </td>

                            <td class="text-end">

                                <span class="badge bg-primary">

                                    {{ PHP_VERSION }}

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                Server Time

                            </td>

                            <td class="text-end">

                                <span id="liveClock" class="fw-bold">

                                    {{ now()->format('H:i:s') }}

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                Current Date

                            </td>

                            <td class="text-end">

                                {{ now()->format('d M Y') }}

                            </td>

                        </tr>

                        <tr>

                            <td>

                                Active Period

                            </td>

                            <td class="text-end">

                                <span class="badge bg-success">

                                    {{ $activePeriod->name ?? '-' }}

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                Database

                            </td>

                            <td class="text-end">

                                <span class="badge bg-info">

                                    MySQL

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                System Status

                            </td>

                            <td class="text-end">

                                <span class="badge bg-success">

                                    <i class="bi bi-check-circle-fill me-1"></i>

                                    Online

                                </span>

                            </td>

                        </tr>

                    </table>

                    <hr>

                    <div class="row text-center">

                        <div class="col-4">

                            <i class="bi bi-shield-check
    
                                      text-success
    
                                      fs-3"></i>

                            <div class="small mt-2">

                                Secure

                            </div>

                        </div>

                        <div class="col-4">

                            <i class="bi bi-database-fill
    
                                      text-primary
    
                                      fs-3"></i>

                            <div class="small mt-2">

                                Database

                            </div>

                        </div>

                        <div class="col-4">

                            <i class="bi bi-cloud-check-fill
    
                                      text-info
    
                                      fs-3"></i>

                            <div class="small mt-2">

                                Connected

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @endsection

    @push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    

        /* ============================================
           Live Clock
        ============================================ */
    
        function updateClock() {
    
            const now = new Date();
    
            const h = String(now.getHours()).padStart(2,'0');
            const m = String(now.getMinutes()).padStart(2,'0');
            const s = String(now.getSeconds()).padStart(2,'0');
    
            const time = `${h}:${m}:${s}`;
    
            const clock1 = document.getElementById('clock');
            const clock2 = document.getElementById('liveClock');
    
            if(clock1) clock1.innerHTML = time;
            if(clock2) clock2.innerHTML = time;
    
        }
    
        updateClock();
    
        setInterval(updateClock,1000);
    
    
        /* ============================================
           Grade Distribution Doughnut
        ============================================ */
    
        const gradeCanvas = document.getElementById('gradeChart');
    
        if(gradeCanvas){
    
            new Chart(gradeCanvas,{
    
                type:'doughnut',
    
                data:{
    
                    labels:[
                        'Grade A',
                        'Grade B',
                        'Grade C',
                        'Grade D',
                        'Grade E'
                    ],
    
                    datasets:[{
    
                        data:[
                            {{ $gradeDistribution['A'] ?? 0 }},
                            {{ $gradeDistribution['B'] ?? 0 }},
                            {{ $gradeDistribution['C'] ?? 0 }},
                            {{ $gradeDistribution['D'] ?? 0 }},
                            {{ $gradeDistribution['E'] ?? 0 }}
                        ],
    
                        backgroundColor:[
                            '#198754',
                            '#0d6efd',
                            '#ffc107',
                            '#dc3545',
                            '#6c757d'
                        ],
    
                        borderWidth:0,
    
                        hoverOffset:15
    
                    }]
    
                },
    
                options:{
    
                    responsive:true,
    
                    maintainAspectRatio:false,
    
                    cutout:'70%',
    
                    plugins:{
    
                        legend:{
    
                            position:'bottom',
    
                            labels:{
    
                                usePointStyle:true,
    
                                padding:20
    
                            }
    
                        },
    
                        tooltip:{
    
                            callbacks:{
    
                                label:function(context){
    
                                    return context.label + ' : ' + context.raw;
    
                                }
    
                            }
    
                        }
    
                    },
    
                    animation:{
    
                        animateRotate:true,
    
                        duration:1800
    
                    }
    
                }
    
            });
    
        }
    
    

        /* ============================================
            Department Performance Bar Chart
            ============================================ */
            
            const departmentCanvas = document.getElementById('departmentChart');
            
            if (departmentCanvas) {
            
            new Chart(departmentCanvas, {
            
            type: 'bar',
            
            data: {
            
            labels: [
            
            @foreach($departmentPerformance as $department)
            "{{ $department->name }}",
            @endforeach
            
            ],
            
            datasets: [{
            
            label: 'Average KPI Score',
            
            data: [
            
            @foreach($departmentPerformance as $department)
            {{ round($department->average_score,2) }},
            @endforeach
            
            ],
            
            borderRadius: 8,
            
            borderSkipped: false,
            
            backgroundColor: [
            
            '#0d6efd',
            '#198754',
            '#ffc107',
            '#dc3545',
            '#6f42c1',
            '#20c997',
            '#fd7e14',
            '#6610f2'
            
            ]
            
            }]
            
            },
            
            options: {
            
            responsive: true,
            
            maintainAspectRatio: false,
            
            plugins: {
            
            legend: {
            
            display: false
            
            },
            
            tooltip: {
            
            callbacks: {
            
            label: function(context){
            
            return " Score : " + context.raw;
            
            }
            
            }
            
            }
            
            },
            
            scales: {
            
            y: {
            
            beginAtZero: true,
            
            max:100,
            
            ticks:{
            
            stepSize:20
            
            }
            
            }
            
            },
            
            animation:{
            
            duration:1800,
            
            easing:'easeOutQuart'
            
            }
            
            }
            
            });
            
            }
            
            
            
            /* ============================================
            KPI Trend Chart
            ============================================ */
            
            const trendCanvas = document.getElementById('kpiTrendChart');
            
            if (trendCanvas) {
            
            const ctx = trendCanvas.getContext('2d');
            
            const gradient = ctx.createLinearGradient(0,0,0,350);
            
            gradient.addColorStop(0,'rgba(13,110,253,.35)');
            gradient.addColorStop(1,'rgba(13,110,253,.02)');
            
            new Chart(ctx, {
            
            type:'line',
            
            data:{
            
            labels:[
            
            @foreach($kpiTrend as $trend)
            "{{ $trend['label'] }}",
            @endforeach
            
            ],
            
            datasets:[{
            
            label:'Average KPI',
            
            data:[
            
            @foreach($kpiTrend as $trend)
            {{ $trend['score'] }},
            @endforeach
            
            ],
            
            fill:true,
            
            backgroundColor:gradient,
            
            borderColor:'#0d6efd',
            
            borderWidth:3,
            
            pointRadius:5,
            
            pointHoverRadius:8,
            
            pointBackgroundColor:'#0d6efd',
            
            tension:.4
            
            }]
            
            },
            
            options:{
            
            responsive:true,
            
            maintainAspectRatio:false,
            
            interaction:{
            
            intersect:false,
            
            mode:'index'
            
            },
            
            plugins:{
            
            legend:{
            
            display:false
            
            }
            
            },
            
            scales:{
            
            y:{
            
            beginAtZero:true,
            
            max:100
            
            }
            
            },
            
            animation:{
            
            duration:2000,
            
            easing:'easeOutQuart'
            
            }
            
            }
            
            });
            
            }
            
            /* ============================================
                Counter Animation
                ============================================ */
                
                function animateCounter(element){
                
                if(!element) return;
                
                const target = parseFloat(element.dataset.target);
                
                if(isNaN(target)) return;
                
                let current = 0;
                
                const increment = target / 60;
                
                const timer = setInterval(function(){
                
                current += increment;
                
                if(current >= target){
                
                current = target;
                
                clearInterval(timer);
                
                }
                
                if(target % 1 === 0){
                
                element.innerHTML = Math.round(current).toLocaleString();
                
                }else{
                
                element.innerHTML = current.toFixed(2);
                
                }
                
                },20);
                
                }
                
                document.querySelectorAll('.counter').forEach(function(item){
                
                    animateCounter(item);
                
                });
                
                
                
                /* ============================================
                Progress Animation
                ============================================ */
                
                document.querySelectorAll('.progress-bar').forEach(function(bar){
                
                const width = bar.style.width;
                
                bar.style.width = '0%';
                
                setTimeout(function(){
                
                bar.style.transition = 'width 1.5s ease';
                
                bar.style.width = width;
                
                },300);
                
                });
                
                
                
                /* ============================================
                Card Hover Effect
                ============================================ */
                
                document.querySelectorAll('.dashboard-card').forEach(function(card){
                
                card.addEventListener('mouseenter',function(){
                
                this.style.transform='translateY(-6px)';
                
                this.style.transition='.3s';
                
                });
                
                card.addEventListener('mouseleave',function(){
                
                this.style.transform='translateY(0px)';
                
                });
                
                });
                
                
                
                /* ============================================
                Bootstrap Tooltip
                ============================================ */
                
                if(typeof bootstrap!=='undefined'){
                
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
                
                .forEach(function(el){
                
                    new bootstrap.Tooltip(el);
                    console.log('Tooltip Initialized for:',el);
                
                });
                
                }
                
                
                
                /* ============================================
                Auto Refresh Every 5 Minutes
                ============================================ */
                
                setInterval(function(){
                
                console.log('Dashboard Auto Refresh');
                
                // location.reload();
                
                },300000);
                
                
                
                /* ============================================
                Refresh Current Time
                ============================================ */
                
                setInterval(function(){
                
                const now=new Date();
                
                const text=now.toLocaleString('id-ID');
                
                document.querySelectorAll('.datetime-now')
                
                .forEach(function(el){
                
                    el.innerHTML=text;
                    console.log('Current Time Updated: '+text);
                
                });
                
                },1000);
                
                
                
                /* ============================================
                Loading State
                ============================================ */
                
                window.addEventListener('load',function(){
                
                    document.body.classList.add('loaded');
                
                });
                
                
                
                /* ============================================
                Notification Example
                ============================================ */
                
                function showToast(message){
                
                    console.log(message);
                
                }
                
                // showToast('Dashboard Loaded');
                
                

                
                
                console.log('===================================');
                
                console.log(' KPI Dashboard Ready');
                
                console.log(' ABC Optimization Loaded');
                
                console.log(' MDP Analysis Loaded');
                
                console.log(' Charts Initialized');
                
                console.log('===================================');

                /* ============================================
                        Reward Statistics Doughnut
                        ============================================ */
                        
                        const rewardCanvas = document.getElementById('rewardChart');
                        
                        
                        if(rewardCanvas){
                        
                            console.log("Reward Chart");
                            
                        new Chart(rewardCanvas,{
                        
                        type:'doughnut',
                        
                        data:{
                        
                        labels:[
                        'Approved',
                        'Pending',
                        'Rejected',
                        'Draft'
                        ],
                        
                        datasets:[{
                        
                        data:[
                        
                        {{ $approvedReward }},
                        
                        {{ $pendingReward }},
                        
                        {{ $rejectedReward }},
                        
                        {{ $draftReward }}
                        
                        ],
                        
                        backgroundColor:[
                        
                        '#198754',
                        
                        '#ffc107',
                        
                        '#dc3545',
                        
                        '#6c757d'
                        
                        ],
                        
                        borderWidth:0,
                        
                        hoverOffset:12
                        
                        }]
                        
                        },
                        
                        options:{
                        
                        responsive:true,
                        
                        maintainAspectRatio:false,
                        
                        cutout:'68%',
                        
                        plugins:{
                        
                        legend:{
                        
                        position:'bottom',
                        
                        labels:{
                        
                        usePointStyle:true,
                        
                        padding:20
                        
                        }
                        
                        },
                        
                        tooltip:{
                        
                        callbacks:{
                        
                        label:function(context){
                        
                        return context.label+' : '+context.raw;
                        
                        }
                        
                        }
                        
                        }
                        
                        },
                        
                        animation:{
                        
                        animateRotate:true,
                        
                        duration:1800
                        
                        }
                        
                        }
                        
                        });
                        
                        }

    });
    
    </script>

    @endpush