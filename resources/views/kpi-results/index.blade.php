@extends('layouts.admin.app')

@section('title','KPI Result Approval')

@push('styles')
<style>
    .avatar-circle {

        width: 42px;

        height: 42px;

        border-radius: 50%;

        background: #0d6efd;

        color: #fff;

        display: flex;

        align-items: center;

        justify-content: center;

        font-weight: 700;


    }

    .table tbody tr {

        transition: .25s;

    }

    .table tbody tr:hover {

        background: #f8fbff;

        transform: scale(1.003);

    }
</style>

@endpush

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">
            KPI Result Approval
        </h3>

        <small class="text-muted">
            Review and approve employee KPI assessment submitted by supervisors.
        </small>

    </div>

    <div>

        <span class="badge bg-warning-subtle text-warning px-3 py-2">

            Waiting :
            {{ $results->where('approval_status','Waiting')->count() }}

        </span>

    </div>

</div>


<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white border-0 py-3">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">




            <div>

                <h5 class="fw-bold mb-0">

                    <i class="fas fa-clipboard-check text-primary me-2"></i>

                    KPI Result List

                    <span class="badge bg-primary ms-2">

                        {{ $results->total() }}

                    </span>

                </h5>

            </div>

            <form method="GET">

                <div class="row g-2">

                    <div class="col-lg-3">

                        <input type="text" class="form-control" name="search" placeholder="Search employee..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-lg-2">

                        <select class="form-select" name="department_id">

                            <option value="">
                                All Department
                            </option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}" @selected(request('department_id')==$department->id)>

                                {{ $department->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <select class="form-select" name="period_id">

                            <option value="">
                                All Period
                            </option>

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected(request('period_id')==$period->id)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <select class="form-select" name="status">

                            <option value="">
                                All Status
                            </option>

                            <option value="Waiting" @selected(request('status')=='Waiting' )>
                                Waiting
                            </option>

                            <option value="Approved" @selected(request('status')=='Approved' )>
                                Approved
                            </option>

                            <option value="Rejected" @selected(request('status')=='Rejected' )>
                                Rejected
                            </option>

                        </select>

                    </div>

                    <div class="col-lg-3 d-flex gap-2">

                        <button class="btn btn-primary flex-fill">

                            <i class="fas fa-search me-1"></i>

                            Search

                        </button>

                        <a href="{{ route('kpi-results.index') }}" class="btn btn-light border">

                            <i class="fas fa-rotate-left"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Employee</th>

                    <th>Department</th>

                    <th>Period</th>

                    <th>Score</th>
                    <th></th>
                    @if(auth()->user()->hasAnyRole(['hrd', 'manager']))
                    <th class="text-center">Action</th>

                    @endif

                </tr>

            </thead>

            <tbody>
                @if($results->count())

                @foreach($results as $result)

                <tr>


                    <td>

                        <div class="d-flex align-items-center">

                            <div class="avatar-circle">

                                {{ strtoupper(substr($result->employee->name,0,1)) }}

                            </div>

                            <div class="ms-3">

                                <div class="fw-semibold">

                                    {{ $result->employee->name }}

                                </div>

                                <small class="text-muted">

                                    {{ $result->employee->employee_no }}

                                </small>

                            </div>

                        </div>

                    </td>

                    <td>

                        <div class="fw-semibold">

                            {{ $result->employee->department->name ?? '-' }}

                        </div>

                        <small class="text-muted">

                            {{ $result->employee->position->name }}

                        </small>

                    </td>

                    <td>

                        {{ $result->period->name ?? '-' }}

                    </td>

                    <td>

                        <div class="fw-bold text-primary">

                            {{ number_format($result->final_score,2) }}

                        </div>

                        <div class="progress mt-2" style="height:6px">

                            <div class="progress-bar bg-primary" style="width:{{ $result->final_score }}%">

                            </div>

                        </div>

                    </td>

                    <td class="text-center">

                        @switch($result->approval_status)

                        @case('Approved')

                        <span class="badge rounded-pill bg-success">

                            <i class="fas fa-check-circle me-1"></i>

                            Approved

                        </span>

                        @break

                        @case('Rejected')

                        <span class="badge rounded-pill bg-danger">

                            <i class="fas fa-times-circle me-1"></i>

                            Rejected

                        </span>

                        @break

                        @default

                        <span class="badge rounded-pill bg-warning text-dark">

                            <i class="fas fa-clock me-1"></i>

                            Waiting

                        </span>

                        @endswitch

                    </td>

                    @if(auth()->user()->hasAnyRole(['hrd', 'manager']))
                    <td class="text-center">

                        <a href="{{ route('kpi-results.show',$result) }}" class="btn btn-primary btn-sm rounded-pill">

                            <i class="fas fa-eye me-1"></i>

                            Review

                        </a>

                    </td>
                    @endif

                </tr>

                @endforeach

                @else

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <i class="fas fa-search fa-3x text-muted mb-3"></i>

                        <h6 class="text-muted">

                            No KPI Result found.

                        </h6>

                    </td>

                </tr>

                @endif

            </tbody>

        </table>



    </div>
    <div class="card-footer bg-white">

        {{ $results->links() }}

    </div>

</div>

</div>

@endsection