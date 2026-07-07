@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Create KPI Indicator
            </h3>
            <p class="text-muted mb-0">
                Add a new KPI indicator and define its measurement settings.
            </p>
        </div>

        <a href="{{ route('kpi.indicator.index') }}" class="btn btn-light border">
            <i class="fas fa-arrow-left me-1"></i>
            Back
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <div class="d-flex align-items-center mb-2">
            <i class="fas fa-circle-exclamation me-2 fs-5"></i>
            <strong>Please correct the following errors:</strong>
        </div>

        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form id="indicatorForm" action="{{ route('kpi.indicator.store') }}" method="POST" novalidate>
        @csrf
        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="row g-4">

                    {{-- KPI Master --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            KPI Category <span class="text-danger">*</span>
                        </label>

                        <select name="kpi_master_id" class="form-select @error('kpi_master_id') is-invalid @enderror">

                            <option value="">-- Select KPI Category --</option>

                            @foreach($masters as $master)
                            <option value="{{ $master->id }}" {{ old('kpi_master_id')==$master->id ? 'selected' : '' }}>
                                {{ $master->name }}
                            </option>
                            @endforeach

                        </select>

                        @error('kpi_master_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Weight --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Weight (%)
                        </label>

                        <input type="number" step="0.01" min="0" max="100" name="weight" value="{{ old('weight') }}"
                            class="form-control @error('weight') is-invalid @enderror">

                        @error('weight')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">
                            Indicator Name <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Example: Attendance">

                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">
                            Description
                        </label>

                        <textarea rows="4" name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Write indicator description...">{{ old('description') }}</textarea>

                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Min Score --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Minimum Score
                        </label>

                        <input type="number" step="0.01" name="min_score" value="{{ old('min_score',0) }}"
                            class="form-control @error('min_score') is-invalid @enderror">

                        @error('min_score')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Max Score --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Maximum Score
                        </label>

                        <input type="number" step="0.01" name="max_score" value="{{ old('max_score',100) }}"
                            class="form-control @error('max_score') is-invalid @enderror">

                        @error('max_score')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Measurement --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Measurement Type
                        </label>

                        <select name="measurement_type"
                            class="form-select @error('measurement_type') is-invalid @enderror">

                            <option value="">-- Select --</option>

                            <option value="percentage" {{ old('measurement_type')=='percentage' ? 'selected' : '' }}>
                                Percentage (%)
                            </option>

                            <option value="number" {{ old('measurement_type')=='number' ? 'selected' : '' }}>
                                Number
                            </option>

                            <option value="score" {{ old('measurement_type')=='score' ? 'selected' : '' }}>
                                Score
                            </option>

                            <option value="boolean" {{ old('measurement_type')=='boolean' ? 'selected' : '' }}>
                                Yes / No
                            </option>

                        </select>

                        @error('measurement_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="is_active" class="form-select">

                            <option value="1" {{ old('is_active',1)==1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('is_active')=='0' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>
                    </div>

                </div>

            </div>

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('kpi.indicator.index') }}" class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit" id="btnSave" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Save Indicator
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
@push('scripts')

@if(session('success'))
<script>
    Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '{{ session('success') }}',
    confirmButtonColor: '#0d6efd'
});
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
    icon: 'error',
    title: 'Validation Failed',
    html: `
        <div class="text-start">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    `,
    confirmButtonColor: '#dc3545'
});
</script>
@endif

<script>
    $(function () {

    $('#indicatorForm').on('submit', function (e) {

        e.preventDefault();

        let form = this;

        let category = $('[name="kpi_master_id"]').val();
        let name = $('[name="name"]').val().trim();

        if(category === ''){

            Swal.fire({
                icon: 'warning',
                title: 'Validation',
                text: 'Please select a KPI Category.',
                confirmButtonColor: '#0d6efd'
            });

            return;
        }

        if(name === ''){

            Swal.fire({
                icon: 'warning',
                title: 'Validation',
                text: 'Indicator Name is required.',
                confirmButtonColor: '#0d6efd'
            });

            return;
        }

        let min = parseFloat($('[name="min_score"]').val()) || 0;
        let max = parseFloat($('[name="max_score"]').val()) || 0;

        if(min > max){

            Swal.fire({
                icon: 'error',
                title: 'Invalid Score',
                text: 'Minimum Score cannot be greater than Maximum Score.',
                confirmButtonColor: '#dc3545'
            });

            return;
        }

        let weight = parseFloat($('[name="weight"]').val()) || 0;

        if(weight < 0 || weight > 100){

            Swal.fire({
                icon: 'error',
                title: 'Invalid Weight',
                text: 'Weight must be between 0 and 100.',
                confirmButtonColor: '#dc3545'
            });

            return;
        }

        Swal.fire({

            title: 'Save KPI Indicator?',
            text: 'The new KPI Indicator will be saved into the system.',
            icon: 'question',

            showCancelButton: true,

            confirmButtonText: '<i class="fas fa-save me-1"></i> Save',
            cancelButtonText: 'Cancel',

            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',

            reverseButtons: true,

        }).then((result) => {

            if(result.isConfirmed){

                $('#btnSave')
                    .prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');

                form.submit();

            }

        });

    });

});
</script>

@endpush