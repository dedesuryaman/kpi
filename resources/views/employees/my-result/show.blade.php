@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Employee</h6>

                    <h4>{{ $employee->name }}</h4>

                    <hr>

                    <h6>Period</h6>

                    <h5>{{ $period->name }}</h5>

                    <hr>

                    <h6>Final Score</h6>

                    <h2 class="text-success">

                        {{ number_format($finalScore,2) }}

                    </h2>

                    <span class="badge bg-success">

                        {{ $rating }}

                    </span>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-header">

                    Performance Detail

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered mb-0">

                        <thead>

                            <tr>

                                <th>KPI</th>
                                <th>Indicator</th>
                                <th>Weight</th>
                                <th>Score</th>
                                <th>Final Score</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($scores as $score)

                            <tr>

                                <td>

                                    {{ $score->indicator->master->name ?? '-' }}

                                </td>

                                <td>

                                    {{ $score->indicator->name ?? '-'}}

                                </td>

                                <td>

                                    {{ number_format($score->indicator->weight ?? 0 ,2) }}

                                </td>

                                <td>

                                    {{ number_format($score->score,2) }}

                                </td>

                                <td>

                                    {{ number_format($score->final_score,2) }}

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr>

                                <th colspan="2">

                                    Average

                                </th>

                                <th>

                                    {{ number_format($averageScore,2) }}

                                </th>

                                <th>

                                    {{ number_format($finalScore,2) }}

                                </th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection