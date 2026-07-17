@extends('layouts.admin.app')

@section('title','MDP Transition Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="bi bi-arrow-left-right text-primary me-2"></i>

                MDP Transition Probability Report

            </h4>

            <p class="text-muted">

                State transition probabilities used by the Markov Decision Process.

            </p>

        </div>

        <div class="btn-group">
            <!--
            <a href="#" class="btn btn-success">

                <i class="bi bi-file-earmark-excel"></i>

                Excel

            </a>

            <a href="#" class="btn btn-danger">

                <i class="bi bi-file-earmark-pdf"></i>

                PDF

            </a>

            <button onclick="window.print()" class="btn btn-secondary">

                <i class="bi bi-printer"></i>

                Print

            </button>
        -->

        </div>

    </div>

    <form method="GET">

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-10">

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

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>From State</th>

                            <th>Action</th>

                            <th>To State</th>

                            <th class="text-center">

                                Probability

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($transitions as $transition)

                        <tr>

                            <td>

                                {{ $transitions->firstItem() + $loop->index }}

                            </td>

                            <td>

                                <span class="badge bg-{{ $transition->fromState->color }}">

                                    {{ $transition->fromState->code }}

                                </span>

                                {{ $transition->fromState->name }}

                            </td>

                            <td>

                                {{ $transition->action->name }}

                            </td>

                            <td>

                                <span class="badge bg-{{ $transition->toState->color }}">

                                    {{ $transition->toState->code }}

                                </span>

                                {{ $transition->toState->name }}

                            </td>

                            <td class="text-center">

                                {{ number_format($transition->probability,4) }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                No transition probability available.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $transitions->links() }}

        </div>

    </div>

</div>

@endsection