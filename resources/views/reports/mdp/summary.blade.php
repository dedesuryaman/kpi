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





    <div class="card shadow-sm">


        <div class="card-header">


            <strong>

                MDP Decision Result

            </strong>


        </div>



        <div class="card-body">


            <div class="table-responsive">


                <table class="table table-bordered table-hover">


                    <thead class="table-light">


                        <tr>

                            <th>#</th>

                            <th>Employee</th>

                            <th>State</th>

                            <th>Action</th>

                            <th>Reward</th>

                            <th>Status</th>


                        </tr>


                    </thead>



                    <tbody>



                        @forelse($results as $result)



                        <tr>


                            <td>

                                {{ $loop->iteration }}

                            </td>


                            <td>

                                {{ $result->employee->name ?? '-' }}

                            </td>


                            <td>

                                {{ $result->state ?? '-' }}

                            </td>


                            <td>

                                {{ $result->action ?? '-' }}

                            </td>


                            <td>

                                {{ number_format($result->reward,2) }}

                            </td>


                            <td>


                                @if($result->reward >= 80)


                                <span class="badge bg-success">

                                    Optimal

                                </span>


                                @elseif($result->reward >= 60)


                                <span class="badge bg-primary">

                                    Good

                                </span>


                                @else


                                <span class="badge bg-warning text-dark">

                                    Need Improvement

                                </span>


                                @endif


                            </td>


                        </tr>



                        @empty


                        <tr>

                            <td colspan="6" class="text-center py-5">


                                <i class="bi bi-diagram-2 display-5 text-muted"></i>


                                <br><br>


                                No MDP analysis result available.


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