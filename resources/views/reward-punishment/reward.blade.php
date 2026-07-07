@extends('layouts.admin.app')

@section('title','Reward Recommendation')

@section('content')

<div class="container-fluid">

    {{-- =========================
    Header
    ========================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="fa fa-award text-success me-2"></i>

                Reward Recommendation

            </h2>

            <p class="text-muted mb-0">

                Performance Based Reward Recommendation

            </p>

        </div>

        <div>

            <a href="{{ route('reward-punishment.index') }}" class="btn btn-light border">

                <i class="fa fa-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div>


    {{-- =========================
    Filter
    ========================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row align-items-end">

                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Period

                        </label>

                        <select name="period_id" class="form-select">

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" {{ $periodId==$period->id?'selected':'' }}>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Department

                        </label>

                        <select name="department_id" class="form-select">

                            <option value="">

                                All Department

                            </option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}" {{ $departmentId==$department->id?'selected':'' }}>

                                {{ $department->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-6 text-end">

                        <button type="submit" class="btn btn-primary">

                            <i class="fa fa-search me-2"></i>

                            Filter

                        </button>



                        <button type="button" class="btn btn-dark">

                            <i class="fa fa-file-excel me-2"></i>

                            Export Excel

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================
    KPI Cards
    ========================== --}}

    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Promotion

                            </small>

                            <h2 class="fw-bold text-danger mt-2">

                                {{ $summary['promotion'] }}

                            </h2>

                        </div>

                        <div>

                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">

                                <i class="fa fa-arrow-up text-danger fa-lg"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Salary Increase

                            </small>

                            <h2 class="fw-bold text-success mt-2">

                                {{ $summary['salary_increase'] }}

                            </h2>

                        </div>

                        <div>

                            <div class="rounded-circle bg-success bg-opacity-10 p-3">

                                <i class="fa fa-money-bill text-success fa-lg"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Performance Bonus

                            </small>

                            <h2 class="fw-bold text-primary mt-2">

                                {{ $summary['bonus'] }}

                            </h2>

                        </div>

                        <div>

                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">

                                <i class="fa fa-gift text-primary fa-lg"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Certificate

                            </small>

                            <h2 class="fw-bold text-warning mt-2">

                                {{ $summary['certificate'] }}

                            </h2>

                        </div>

                        <div>

                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">

                                <i class="fa fa-certificate text-warning fa-lg"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
    Chart & Summary
    ========================== --}}

    <div class="row mb-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        Reward Distribution

                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="rewardChart" height="240"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        Recommendation Summary

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between py-2">

                        <span>

                            Total Recommendation

                        </span>

                        <strong>

                            {{ $summary['total'] }}

                        </strong>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between py-2">

                        <span>

                            Promotion

                        </span>

                        <span class="badge bg-danger">

                            {{ $summary['promotion'] }}

                        </span>

                    </div>

                    <div class="d-flex justify-content-between py-2">

                        <span>

                            Salary Increase

                        </span>

                        <span class="badge bg-success">

                            {{ $summary['salary_increase'] }}

                        </span>

                    </div>

                    <div class="d-flex justify-content-between py-2">

                        <span>

                            Performance Bonus

                        </span>

                        <span class="badge bg-primary">

                            {{ $summary['bonus'] }}

                        </span>

                    </div>

                    <div class="d-flex justify-content-between py-2">

                        <span>

                            Certificate

                        </span>

                        <span class="badge bg-warning text-dark">

                            {{ $summary['certificate'] }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ==========================================================
    Reward Recommendation List
    =========================================================== --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-0">

                    <i class="fa fa-list-check text-primary me-2"></i>

                    Reward Recommendation List

                </h5>

                <small class="text-muted">

                    Employee performance recommendation based on KPI evaluation.

                </small>

            </div>

            <div>

                <span class="badge bg-primary">

                    {{ $rewards->count() }} Employee(s)

                </span>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table id="rewardTable" class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">

                                Rank

                            </th>

                            <th>

                                Employee

                            </th>

                            <th width="180">

                                Department

                            </th>

                            <th width="110" class="text-center">

                                Score

                            </th>

                            <th width="90" class="text-center">

                                Grade

                            </th>

                            <th width="190">

                                Recommendation

                            </th>

                            <th>

                                Reason

                            </th>

                            <th width="110" class="text-center">

                                Status

                            </th>

                            <th width="180" class="text-center">

                                Action

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($rewards as $reward)

                        @php


                        switch($reward->recommendation){

                        case 'Promotion':

                        $rewardColor='danger';

                        break;

                        case 'Salary Increase':

                        $rewardColor='success';

                        break;

                        case 'Performance Bonus':

                        $rewardColor='primary';

                        break;

                        default:

                        $rewardColor='warning';

                        }

                        @endphp

                        <tr>

                            <td>

                                <span class="badge bg-dark">

                                    #{{ $reward->rank }}

                                </span>

                            </td>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center"
                                        style="width:45px;height:45px;">

                                        {{ strtoupper(substr($reward->employee->name,0,1)) }}

                                    </div>

                                    <div class="ms-3">

                                        <div class="fw-semibold">

                                            {{ $reward->employee->name }}

                                        </div>

                                        <small class="text-muted">

                                            {{ $reward->employee->employee_code }}

                                        </small>

                                    </div>

                                </div>

                            </td>

                            <td>

                                {{ $reward->employee->department->name ?? '-' }}

                            </td>

                            <td class="text-center">

                                <span class="fw-bold text-primary">

                                    {{ number_format($reward->final_score,2) }}

                                </span>

                            </td>

                            <td class="text-center">

                                @if($reward->grade=='A')

                                <span class="badge bg-success">

                                    {{ $reward->grade }}

                                </span>

                                @elseif($reward->grade=='B')

                                <span class="badge bg-primary">

                                    {{ $reward->grade }}

                                </span>

                                @elseif($reward->grade=='C')

                                <span class="badge bg-warning text-dark">

                                    {{ $reward->grade }}

                                </span>

                                @else

                                <span class="badge bg-danger">

                                    {{ $reward->grade }}

                                </span>

                                @endif

                            </td>

                            <td>

                                <span class="badge bg-{{ $rewardColor }} px-3 py-2">

                                    {{ $reward->recommendation }}

                                </span>

                            </td>

                            <td>

                                <small>

                                    {{ $reward->reason }}

                                </small>

                            </td>
                            <td class="text-center">

                                @php
                                $status = $reward->latestRewardRecommendation?->status ?? 'Draft';
                                @endphp

                                @switch($status)

                                @case('Approved')

                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Approved
                                </span>

                                @break


                                @case('Rejected')

                                <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Rejected
                                </span>

                                @break


                                @case('Pending')

                                <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>
                                    Pending
                                </span>

                                @break


                                @default

                                <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Draft
                                </span>

                                @endswitch

                            </td>

                            <td class="text-center">

                                <div class="btn-group">

                                    <a href="{{ route('reward-punishment.show',$reward) }}"
                                        class="btn btn-outline-primary btn-sm">

                                        <i class="fa fa-eye"></i>

                                    </a>


                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="9" class="text-center py-5">

                                <i class="fa fa-inbox fa-3x text-muted mb-3">

                                </i>

                                <h5 class="text-muted">

                                    No Reward Recommendation

                                </h5>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- ==========================================================
    Employee Reward Detail
    ========================================================== --}}
    <div class="modal fade" id="detailModal" tabindex="-1">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">

            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">

                        <i class="fa fa-user me-2"></i>

                        Employee Reward Recommendation

                    </h5>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        {{-- Left --}}
                        <div class="col-lg-4">

                            <div class="text-center">

                                <img src="{{ asset('images/avatar.png') }}" class="rounded-circle shadow" width="120">

                                <h4 id="employee_name" class="mt-3 fw-bold">

                                    -

                                </h4>

                                <div id="employee_code" class="text-muted">

                                    -

                                </div>

                            </div>

                            <hr>

                            <table class="table table-sm">

                                <tr>

                                    <th width="120">

                                        Department

                                    </th>

                                    <td id="department">

                                        -

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        Position

                                    </th>

                                    <td id="position">

                                        -

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        Join Date

                                    </th>

                                    <td id="join_date">

                                        -

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        Grade

                                    </th>

                                    <td id="grade">

                                        -

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        Rank

                                    </th>

                                    <td id="rank">

                                        -

                                    </td>

                                </tr>

                            </table>

                        </div>

                        {{-- Right --}}
                        <div class="col-lg-8">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="card bg-success text-white">

                                        <div class="card-body text-center">

                                            <small>

                                                Final KPI

                                            </small>

                                            <h2 id="final_score">

                                                -

                                            </h2>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="card bg-primary text-white">

                                        <div class="card-body text-center">

                                            <small>

                                                Recommendation

                                            </small>

                                            <h5 id="recommendation" class="mt-2">

                                                -

                                            </h5>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="card bg-warning">

                                        <div class="card-body text-center">

                                            <small>

                                                Status

                                            </small>

                                            <h5 id="status" class="mt-2">

                                                Draft

                                            </h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <hr>

                            <h6 class="fw-bold">

                                KPI Category Score

                            </h6>

                            <canvas id="employeeRadarChart" height="180">

                            </canvas>

                            <hr>

                            <h6 class="fw-bold">

                                Performance Detail

                            </h6>

                            <table class="table table-bordered">

                                <thead>

                                    <tr>

                                        <th>KPI</th>

                                        <th>Score</th>

                                        <th>Weight</th>

                                        <th>Weighted Score</th>

                                    </tr>

                                </thead>

                                <tbody id="detailTable">

                                </tbody>

                            </table>

                            <h6 class="fw-bold">

                                Recommendation Reason

                            </h6>

                            <div id="recommendation_reason" class="alert alert-light border">

                                -

                            </div>

                            <h6 class="fw-bold">

                                HR Notes

                            </h6>

                            <textarea class="form-control" rows="4" placeholder="Write HR notes here...">

                            </textarea>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-outline-danger">

                        <i class="fa fa-times me-2"></i>

                        Reject

                    </button>

                    <button class="btn btn-success">

                        <i class="fa fa-check me-2"></i>

                        Approve Recommendation

                    </button>

                </div>

            </div>

        </div>

    </div>


</div>
@endsection
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(function () {

    /*
    |--------------------------------------------------------------------------
    | DataTable
    |--------------------------------------------------------------------------
    */

    @if($rewards->isNotEmpty())
        $('#rewardTable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            autoWidth: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search employee..."
            }
        });
    

    @endif

// $('#rewardTable').DataTable({

// responsive: true,

// pageLength: 10,

// ordering: true,

// autoWidth: false,

// language: {

// search: "_INPUT_",

// searchPlaceholder: "Search employee..."

// }

// });


/*
|--------------------------------------------------------------------------
| Reward Distribution Chart
|--------------------------------------------------------------------------
*/

const rewardCtx = document.getElementById('rewardChart');

if (rewardCtx) {

new Chart(rewardCtx, {

type: 'doughnut',

data: {

labels: [

'Promotion',

'Salary Increase',

'Performance Bonus',

'Certificate'

],

datasets: [{

data: [

{{ $summary['promotion'] }},

{{ $summary['salary_increase'] }},

{{ $summary['bonus'] }},

{{ $summary['certificate'] }}

]

}]

},

options: {

responsive: true,

maintainAspectRatio: false,

cutout: '65%',

plugins: {

legend: {

position: 'bottom'

}

}

}

});

}


/*
|--------------------------------------------------------------------------
| Approve
|--------------------------------------------------------------------------
*/

$('.btn-approve').click(function () {

if(confirm('Approve this recommendation?')){

// submit form nanti

}

});


/*
|--------------------------------------------------------------------------
| Reject
|--------------------------------------------------------------------------
*/

$('.btn-reject').click(function () {

if(confirm('Reject this recommendation?')){

// submit form nanti

}

});


/*
|--------------------------------------------------------------------------
| Print
|--------------------------------------------------------------------------
*/

$('.btn-print').click(function(){

window.print();

});

});
</script>
@endpush