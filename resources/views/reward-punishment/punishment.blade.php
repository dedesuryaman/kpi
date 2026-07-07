@extends('layouts.admin.app')

@section('title','Punishment Recommendation')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">

                Punishment Recommendation

            </h3>

            <p class="text-muted mb-0">

                Employees recommended for corrective action based on KPI performance.

            </p>

        </div>

    </div>


    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Total Recommendation

                    </small>

                    <h2>

                        {{ $punishments->total() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Need Coaching

                    </small>

                    <h2 class="text-warning">

                        {{ $punishments->whereBetween('final_score',[60,69])->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Need Warning

                    </small>

                    <h2 class="text-danger">

                        {{ $punishments->where('final_score','<',60)->count() }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <form method="GET">

        <div class="row g-2 mb-3">

            <div class="col-lg-4">

                <input name="search" class="form-control" placeholder="Search employee..."
                    value="{{ request('search') }}">

            </div>

            <div class="col-lg-3">

                <select name="department_id" class="form-select">

                    <option value="">

                        Department

                    </option>

                    @foreach($departments as $department)

                    <option value="{{ $department->id }}" @selected(request('department_id')==$department->id)>

                        {{ $department->name }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-lg-3">

                <select name="period_id" class="form-select">

                    <option value="">

                        Period

                    </option>

                    @foreach($periods as $period)

                    <option value="{{ $period->id }}" @selected(request('period_id')==$period->id)>

                        {{ $period->name }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-lg-2">

                <button class="btn btn-primary w-100">

                    Search

                </button>

            </div>

        </div>

    </form>

    <div class="card border-0 shadow-sm">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Employee</th>

                        <th>Department</th>

                        <th>Period</th>

                        <th>Score</th>

                        <th>Recommendation</th>

                        <th></th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($punishments as $item)

                    <tr>

                        <td>

                            <strong>

                                {{ $item->employee->name }}

                            </strong>

                        </td>

                        <td>

                            {{ $item->employee->department?->name }}

                        </td>

                        <td>

                            {{ $item->period->name }}

                        </td>

                        <td>

                            <span class="fw-bold text-danger">

                                {{ number_format($item->final_score,2) }}

                            </span>

                        </td>

                        <td>

                            @if($item->final_score >=60)

                            <span class="badge bg-warning">

                                Coaching

                            </span>

                            @elseif($item->final_score >=50)

                            <span class="badge bg-danger">

                                Warning Letter

                            </span>

                            @else

                            <span class="badge bg-dark">

                                Performance Improvement Plan

                            </span>

                            @endif

                        </td>

                        <td>

                            <a href="#" class="btn btn-outline-primary btn-sm">

                                Review

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-5">

                            No punishment recommendation found.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer bg-white">

            {{ $punishments->links() }}

        </div>

    </div>

</div>

@endsection