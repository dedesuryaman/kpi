@extends('layouts.admin.app')

@section('title', 'Artificial Bee Colony')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-8 mx-auto">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Artificial Bee Colony (ABC)
                    </h4>
                </div>

                <div class="card-body">

                    @if(session('success'))

                    <div class="alert alert-success alert-dismissible fade show">

                        {{ session('success') }}

                        <button class="btn-close" data-bs-dismiss="alert"></button>

                    </div>

                    @endif

                    @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                    @endif

                    <form method="POST" action="{{ route('abc.run') }}">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Period
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

                        <div class="row">

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label fw-bold">

                                        Population Size

                                    </label>

                                    <input type="number" class="form-control" name="population_size"
                                        value="{{ old('population_size',20) }}" min="5" required>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label fw-bold">

                                        Max Iteration

                                    </label>

                                    <input type="number" class="form-control" name="max_iteration"
                                        value="{{ old('max_iteration',100) }}" min="1" required>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label fw-bold">

                                        Limit Trial

                                    </label>

                                    <input type="number" class="form-control" name="limit_trial"
                                        value="{{ old('limit_trial',20) }}" min="1" required>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">

                            <button type="submit" class="btn btn-primary">

                                <i class="fa fa-play me-1"></i>

                                Run Artificial Bee Colony

                            </button>

                        </div>

                    </form>

                </div>

            </div>

            @if(\App\Models\AbcResult::count())

            <div class="card shadow-sm border-0 mt-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Optimization History

                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Period</th>
                                <th>Fitness</th>

                                @php
                                $masters = \App\Models\KpiMaster::where('status',1)->orderBy('id')->get();
                                @endphp

                                @foreach($masters as $master)
                                <th>{{ $master->name }}</th>
                                @endforeach

                                <th width="100">Action</th>
                            </tr>
                        </thead>


                        <tbody>

                            @foreach($results as $item)

                            <tr>

                                <td>{{ $item->period->name }}</td>

                                <td>{{ number_format($item->fitness,6) }}</td>

                                @foreach($masters as $master)

                                @php
                                $detail = $item->details
                                ->firstWhere('kpi_master_id',$master->id);
                                @endphp

                                <td>

                                    {{ number_format($detail?->weight ?? 0,10) }}

                                </td>

                                @endforeach

                                <td>

                                    <a href="{{ route('abc.show',$item->id) }}" class="btn btn-sm btn-primary">

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

    </div>

</div>

@endsection


@push('scripts')

<script>
    $(function(){

    $('.select2').select2({

        theme:'bootstrap-5',

        width:'100%',

        placeholder:'Select Period'

    });

});

</script>

@endpush