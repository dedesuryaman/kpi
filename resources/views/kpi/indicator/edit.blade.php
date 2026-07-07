@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Edit KPI Indicator
            </h3>

            <p class="text-muted mb-0">
                Update KPI indicator information and measurement settings.
            </p>
        </div>

        <a href="{{ route('kpi.indicator.index') }}" class="btn btn-light border">

            <i class="fas fa-arrow-left me-1"></i>
            Back

        </a>

    </div>

    {{-- Error Summary --}}
    @if($errors->any())

    <div class="alert alert-danger border-0 shadow-sm">

        <div class="d-flex align-items-center mb-2">

            <i class="fas fa-circle-exclamation me-2"></i>

            <strong>
                Please correct the following errors:
            </strong>

        </div>

        <ul class="mb-0 ps-3">

            @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <form id="indicatorForm" action="{{ route('kpi.indicator.update',$indicator->id) }}" method="POST" novalidate>

        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="row g-4">

                    {{-- KPI Category --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            KPI Category
                            <span class="text-danger">*</span>
                        </label>

                        <select name="kpi_master_id" class="form-select @error('kpi_master_id') is-invalid @enderror">

                            <option value="">
                                -- Select KPI Category --
                            </option>

                            @foreach($masters as $master)

                            <option value="{{ $master->id }}" {{ old('kpi_master_id',$indicator->
                                kpi_master_id)==$master->id ? 'selected' : '' }}>

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

                            <span class="text-danger">*</span>

                        </label>

                        <input type="number" name="weight" min="0" max="100" step="0.01"
                            value="{{ old('weight',$indicator->weight) }}"
                            class="form-control @error('weight') is-invalid @enderror">

                        @error('weight')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                        @enderror

                        <small class="text-muted">

                            Maximum total weight for one KPI Category is 100%.

                        </small>

                    </div>

                    {{-- Indicator Name --}}
                    <div class="col-md-12">

                        <label class="form-label fw-semibold">

                            Indicator Name

                            <span class="text-danger">*</span>

                        </label>

                        <input type="text" name="name" value="{{ old('name',$indicator->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Example : Attendance">

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
                            placeholder="Write indicator description...">{{ old('description',$indicator->description) }}</textarea>

                        @error('description')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                        @enderror

                    </div>

                    {{-- Minimum Score --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Minimum Score
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number" step="0.01" name="min_score"
                            value="{{ old('min_score',$indicator->min_score) }}"
                            class="form-control @error('min_score') is-invalid @enderror">

                        @error('min_score')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <small class="text-muted">
                            Lowest allowable score.
                        </small>

                    </div>

                    {{-- Maximum Score --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Maximum Score
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number" step="0.01" name="max_score"
                            value="{{ old('max_score',$indicator->max_score) }}"
                            class="form-control @error('max_score') is-invalid @enderror">

                        @error('max_score')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <small class="text-muted">
                            Maximum achievable score.
                        </small>

                    </div>

                    {{-- Measurement Type --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Measurement Type
                            <span class="text-danger">*</span>
                        </label>

                        <select name="measurement_type"
                            class="form-select @error('measurement_type') is-invalid @enderror">

                            <option value="">-- Select Measurement --</option>

                            <option value="percentage" {{ old('measurement_type',$indicator->
                                measurement_type)=='percentage' ? 'selected' :
                                '' }}>
                                Percentage (%)
                            </option>

                            <option value="number" {{ old('measurement_type',$indicator->measurement_type)=='number' ?
                                'selected' : '' }}>
                                Number
                            </option>

                            <option value="score" {{ old('measurement_type',$indicator->measurement_type)=='score' ?
                                'selected' : '' }}>
                                Score
                            </option>

                            <option value="boolean" {{ old('measurement_type',$indicator->measurement_type)=='boolean' ?
                                'selected' : '' }}>
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

                            <option value="1" {{ old('is_active',$indicator->is_active)==1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('is_active',$indicator->is_active)==0 ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        <small class="text-muted">
                            Only active indicators can be used in KPI assessments.
                        </small>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Fields marked with
                        <span class="text-danger">*</span>
                        are required.
                    </small>

                    <div class="d-flex gap-2">

                        <a href="{{ route('kpi.indicator.index') }}" class="btn btn-light border">

                            <i class="fas fa-times me-1"></i>
                            Cancel

                        </a>

                        <button type="submit" id="btnSave" class="btn btn-primary">

                            <i class="fas fa-save me-1"></i>
                            Update Indicator

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

{{-- Success Notification --}}
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

{{-- Validation Error Notification --}}
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

$(function () {

    let firstError = $('.is-invalid').first();

    if(firstError.length){

        $('html, body').animate({
            scrollTop: firstError.offset().top - 120
        },400);

        firstError.focus();

    }

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

            title: 'Update KPI Indicator?',
            text: 'The KPI Indicator information will be updated.',
            icon: 'question',

            showCancelButton: true,

            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',

            confirmButtonText: '<i class="fas fa-save me-1"></i> Update',
            cancelButtonText: 'Cancel',

            reverseButtons: true,

        }).then((result) => {

            if(result.isConfirmed){

                $('#btnSave')
                    .prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');

                form.submit();

            }

        });

    });

});
</script>

{{-- Highlight Invalid Input --}}
<style>
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-width: 2px;
    }

    .invalid-feedback {
        display: block;
        font-size: .85rem;
    }
</style>

@endpush