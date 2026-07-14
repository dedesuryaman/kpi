@extends('layouts.admin.app')

@section('title', 'Artificial Bee Colony')

@section('content')

@php
$masters = \App\Models\KpiMaster::where('status',1)
->orderBy('id')
->get();
@endphp

<div class="container-fluid">

    {{-- ================= HEADER ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Artificial Bee Colony
            </h3>

            <p class="text-muted mb-0">
                Optimize KPI weights using the Artificial Bee Colony (ABC) algorithm.
            </p>
        </div>

        <div>
            <span class="badge bg-primary fs-6 px-3 py-2">
                Optimization Module
            </span>
        </div>

    </div>

    {{-- ================= FORM ================= --}}
    @if (auth()->user()->hasRole('hrd'))
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom">

            <h5 class="mb-0 fw-semibold">
                <i class="fa-solid fa-sliders me-2 text-primary"></i>
                ABC Parameters
            </h5>

        </div>

        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

                <button class="btn-close" data-bs-dismiss="alert"></button>

            </div>
            @endif

            @if($errors->any())

            <div class="alert alert-danger">

                <div class="fw-bold mb-2">
                    Please fix the following errors:
                </div>

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

            @endif

            <form method="POST" action="{{ route('abc.run') }}">

                @csrf

                <div class="row">

                    <div class="col-lg-12 mb-3">

                        <label class="form-label fw-semibold">

                            Evaluation Period

                        </label>

                        <select name="period_id" class="form-select select2" required>

                            <option value="">
                                -- Select Period --
                            </option>

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected(old('period_id')==$period->id)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">

                        <div class="mb-3">

                            <label class="form-label fw-semibold">

                                Population Size

                            </label>

                            <input type="number" name="population_size" class="form-control"
                                value="{{ old('population_size',20) }}" min="5" required>

                            <small class="text-muted">
                                Number of food sources.
                            </small>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="mb-3">

                            <label class="form-label fw-semibold">

                                Maximum Iteration

                            </label>

                            <input type="number" name="max_iteration" class="form-control"
                                value="{{ old('max_iteration',100) }}" min="1" required>

                            <small class="text-muted">
                                Maximum optimization cycles.
                            </small>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="mb-3">

                            <label class="form-label fw-semibold">

                                Limit Trial

                            </label>

                            <input type="number" name="limit_trial" class="form-control"
                                value="{{ old('limit_trial',20) }}" min="1" required>

                            <small class="text-muted">
                                Scout bee limit.
                            </small>

                        </div>

                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-end">

                    <button type="submit" class="btn btn-primary px-4">

                        <i class="fa-solid fa-play me-2"></i>

                        Run Optimization

                    </button>

                </div>

            </form>

        </div>

    </div>

    @endif

    {{-- ================= HISTORY ================= --}}
    @if($results->count())

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-header bg-white border-bottom">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0 fw-semibold">

                    <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>

                    Optimization History

                </h5>

                <span class="badge bg-secondary">

                    {{ $results->count() }} Result(s)

                </span>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Period</th>

                        <th>Fitness</th>

                        @foreach($masters as $master)

                        <th class="text-center">

                            {{ $master->name }}

                        </th>

                        @endforeach

                        <th width="120" class="text-center">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($results as $item)

                    <tr>

                        <td>

                            <span class="fw-semibold">

                                {{ $item->period->name }}

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-success">

                                {{ number_format($item->fitness,6) }}

                            </span>

                        </td>

                        @foreach($masters as $master)

                        @php
                        $detail = $item->details
                        ->firstWhere('kpi_master_id', $master->id);
                        @endphp

                        <td class="text-center">

                            {{ number_format($detail?->weight ?? 0,10) }}

                        </td>

                        @endforeach

                        <td class="text-center">

                            <a href="{{ route('abc.show',$item->id) }}" class="btn btn-sm btn-outline-primary">

                                <i class="fa-solid fa-eye me-1"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    @endif

</div>

@endsection

@push('scripts')

<script>
    $(function () {

    $('.select2').select2({

        theme: 'bootstrap-5',

        width: '100%',

        placeholder: 'Select Period',

        allowClear: true

    });

});

</script>

@endpush