@extends('layouts.admin.app')


@section('title','MDP Summary Report')


@section('content')


<div class="container-fluid">


    <div class="d-flex justify-content-between align-items-center mb-4">


        <div>

            <h4 class="fw-bold">

                <i class="bi bi-diagram-2-fill text-primary me-2"></i>

                MDP Summary Report

            </h4>


            <p class="text-muted mb-0">

                Markov Decision Process analysis summary and decision results.

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


            <button class="btn btn-secondary" onclick="window.print()">

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


                        <select name="period_id" class="form-select">


                            @foreach($periods as $period)


                            <option value="{{ $period->id }}" @selected($selectedPeriod==$period->id)>


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




    <div class="row mb-4">


        <div class="col-md-3">


            <div class="card border-start border-primary border-4">


                <div class="card-body">


                    <small class="text-muted">

                        Total States

                    </small>


                    <h3>

                        {{ $summary['states'] }}

                    </h3>


                </div>


            </div>


        </div>




        <div class="col-md-3">


            <div class="card border-start border-success border-4">


                <div class="card-body">


                    <small class="text-muted">

                        Total Actions

                    </small>


                    <h3>

                        {{ $summary['actions'] }}

                    </h3>


                </div>


            </div>


        </div>




        <div class="col-md-3">


            <div class="card border-start border-warning border-4">


                <div class="card-body">


                    <small class="text-muted">

                        Transition

                    </small>


                    <h3>

                        {{ $summary['transitions'] }}

                    </h3>


                </div>


            </div>


        </div>




        <div class="col-md-3">


            <div class="card border-start border-danger border-4">


                <div class="card-body">


                    <small class="text-muted">

                        Average Reward

                    </small>


                    <h3>

                        {{ number_format($summary['average_reward'],2) }}

                    </h3>


                </div>


            </div>


        </div>


    </div>





    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    <i class="bi bi-diagram-3-fill text-primary me-2"></i>
                    MDP Decision Result
                </h5>
                <small class="text-muted">
                    Markov Decision Process Recommendation
                </small>
            </div>

            <span class="badge bg-primary">
                {{ $results->count() }} Employees
            </span>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Employee</th>
                            <th>Performance State</th>
                            <th>Recommended Action</th>
                            <th class="text-center">Reward</th>
                            <th class="text-center">Decision</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        @php

                        $state = is_array($result->state)
                        ? $result->state
                        : json_decode($result->state,true);

                        $action = is_array($result->action)
                        ? $result->action
                        : json_decode($result->action,true);

                        @endphp

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                <div class="fw-semibold">
                                    {{ $result->employee->name }}
                                </div>

                            </td>

                            <td>

                                @if($state)

                                <span class="badge bg-{{ $state['color'] }}">
                                    {{ $state['code'] }}
                                </span>

                                <div class="small mt-1 fw-semibold">
                                    {{ $state['name'] }}
                                </div>

                                <small class="text-muted">
                                    {{ $state['min_score'] }} -
                                    {{ $state['max_score'] }}
                                </small>

                                @else

                                -

                                @endif

                            </td>

                            <td>

                                @if($action)

                                <span class="badge bg-{{ $action['color'] }}">
                                    {{ $action['code'] }}
                                </span>

                                <div class="small mt-1 fw-semibold">
                                    {{ $action['name'] }}
                                </div>

                                @else

                                -

                                @endif

                            </td>

                            <td class="text-center">

                                @if($result->reward>=90)

                                <span class="fw-bold text-success">
                                    {{ number_format($result->reward,2) }}
                                </span>

                                @elseif($result->reward>=70)

                                <span class="fw-bold text-primary">
                                    {{ number_format($result->reward,2) }}
                                </span>

                                @else

                                <span class="fw-bold text-warning">
                                    {{ number_format($result->reward,2) }}
                                </span>

                                @endif

                            </td>

                            <td class="text-center">

                                @if($result->reward>=80)

                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Optimal
                                </span>

                                @elseif($result->reward>=60)

                                <span class="badge bg-primary">
                                    <i class="bi bi-award-fill me-1"></i>
                                    Good
                                </span>

                                @else

                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    Need Improvement
                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                <i class="bi bi-diagram-3 display-5 text-muted"></i>

                                <div class="mt-3">
                                    No MDP analysis result available.
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    @endsection