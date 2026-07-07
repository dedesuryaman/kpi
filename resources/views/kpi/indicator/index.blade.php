@extends('layouts.admin.app')

@section('content')
{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">
            KPI Indicators
        </h3>
        <p class="text-muted mb-0">
            Manage KPI Parameters & Metrics
        </p>
    </div>

    <a href="{{ route('kpi.indicator.create') }}" class="btn btn-primary px-4">
        <i class="fas fa-plus"></i>
        New Indicator
    </a>
</div>


<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3 align-items-end">

                {{-- Search --}}
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <label class="form-label small fw-semibold text-muted mb-1">
                        Search Indicator
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>

                        <input type="text" name="search" class="form-control border-start-0"
                            placeholder="Search by indicator name..." value="{{ request('search') }}">

                    </div>

                </div>

                {{-- KPI Master --}}
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <label class="form-label small fw-semibold text-muted mb-1">
                        KPI Master
                    </label>

                    <select name="master" class="form-select">

                        <option value="">
                            All KPI Master
                        </option>

                        @foreach($masters as $master)

                        <option value="{{ $master->id }}" {{ request('master')==$master->id ? 'selected' : '' }}>

                            {{ $master->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                {{-- Type --}}
                <div class="col-xl-2 col-lg-6 col-md-6">

                    <label class="form-label small fw-semibold text-muted mb-1">
                        Type
                    </label>

                    <select name="type" class="form-select">

                        <option value="">
                            All Types
                        </option>

                        <option value="percentage" {{ request('type')=='percentage' ? 'selected' : '' }}>
                            Percentage
                        </option>

                        <option value="number" {{ request('type')=='number' ? 'selected' : '' }}>
                            Number
                        </option>

                        <option value="currency" {{ request('type')=='currency' ? 'selected' : '' }}>
                            Currency
                        </option>

                        <option value="boolean" {{ request('type')=='boolean' ? 'selected' : '' }}>
                            Boolean
                        </option>

                    </select>

                </div>

                {{-- Status --}}
                <div class="col-xl-2 col-lg-6 col-md-6">

                    <label class="form-label small fw-semibold text-muted mb-1">
                        Status
                    </label>

                    <select name="status" class="form-select">

                        <option value="">
                            All Status
                        </option>

                        <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <div class="col-xl-2 col-lg-12 col-md-12">

                    <label class="form-label d-block">&nbsp;</label>

                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i>
                            Search
                        </button>

                        <a href="{{ route('kpi.indicator.index') }}" class="btn btn-light border flex-fill">

                            <i class="fas fa-undo me-1"></i>
                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


<div class="card shadow-sm border-0">


    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">

                    <tr>

                        <th width="60">#</th>

                        <th>Indicator</th>

                        <th>KPI Master</th>

                        <th width="120">Weight</th>

                        <th width="140">Range</th>

                        <th width="140">Type</th>

                        <th width="120">Status</th>

                        <th width="130">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($indicators as $item)

                    <tr>

                        <td>{{ $indicators->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="fw-semibold">
                                {{ $item->name }}
                            </div>

                            <small class="text-muted">
                                {{ $item->description }}
                            </small>
                        </td>

                        <td>
                            {{ $item->master->name ?? '-' }}
                        </td>

                        <td>
                            {{ $item->weight }}%
                        </td>

                        <td>
                            {{ $item->min_score }}
                            -
                            {{ $item->max_score }}
                        </td>

                        <td>
                            <span class="badge bg-info">
                                {{ strtoupper($item->measurement_type) }}
                            </span>
                        </td>

                        <td>

                            @if($item->is_active)

                            <span class="badge bg-success">
                                Active
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                Inactive
                            </span>

                            @endif

                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('kpi.indicator.edit',$item->id) }}"
                                    class="btn btn-sm btn-light border">

                                    <i class="fas fa-pen text-warning"></i>

                                </a>
                                <form action="{{ route('kpi.indicator.destroy',$item->id) }}" method="POST"
                                    class="delete-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-light border delete-btn">

                                        <i class="fas fa-trash text-danger"></i>

                                    </button>

                                </form>
                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


    </div>

    <div class="card-footer bg-white">

        <div class="d-flex justify-content-between align-items-center">

            <div class="text-muted small">

                Showing

                <b>{{ $indicators->firstItem() ?? 0 }}</b>

                to

                <b>{{ $indicators->lastItem() ?? 0 }}</b>

                of

                <b>{{ $indicators->total() }}</b>

                entries

            </div>

            <div>

                {{ $indicators->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>


<div class="modal fade" id="crudModal">

    <div class="modal-dialog modal-lg">

        <form id="crudForm">

            <input type="hidden" id="id">

            <div class="modal-content">

                <div class="modal-header">
                    <h5>KPI Indicator</h5>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>KPI Master</label>

                            <select id="kpi_master_id" class="form-select">

                                @foreach($masters as $master)
                                <option value="{{ $master->id }}">
                                    {{ $master->name }}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Indicator Name</label>

                            <input type="text" id="name" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description</label>

                            <textarea id="description" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Weight (%)</label>

                            <input type="number" id="weight" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Min Score</label>

                            <input type="number" id="min_score" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Max Score</label>

                            <input type="number" id="max_score" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">

                            <label>
                                Measurement Type
                            </label>

                            <select id="measurement_type" class="form-select">

                                <option value="percentage">
                                    Percentage
                                </option>

                                <option value="number">
                                    Number
                                </option>

                                <option value="currency">
                                    Currency
                                </option>

                                <option value="boolean">
                                    Boolean
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Status</label>

                            <select id="is_active" class="form-select">

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">
                        Save
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-form').forEach(function(form){

        form.addEventListener('submit', function(e){

            e.preventDefault();

            const btn = form.querySelector('.delete-btn');

            Swal.fire({

                title: 'Delete KPI Indicator?',

                text: 'This action cannot be undone.',

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, Delete',

                cancelButtonText: 'Cancel',

                confirmButtonColor: '#dc3545',

                cancelButtonColor: '#6c757d',

                reverseButtons: true

            }).then((result)=>{

                if(!result.isConfirmed){
                    return;
                }

                btn.disabled = true;

                btn.innerHTML = `
                    <span class="spinner-border spinner-border-sm"></span>
                `;

                form.submit();

            });

        });

    });

});

</script>

@endpush