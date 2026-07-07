@extends('layouts.admin.app')

@section('title','Edit KPI Master')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb mb-2">

                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('kpi.master.index') }}">
                            KPI Master
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Edit
                    </li>

                </ol>

            </nav>

            <h3 class="fw-bold mb-1">

                <i class="fas fa-pen text-warning me-2"></i>

                Edit KPI Master

            </h3>

            <p class="text-muted mb-0">

                Update KPI master information.

            </p>

        </div>

        <a href="{{ route('kpi.master.index') }}" class="btn btn-light border shadow-sm">

            <i class="fas fa-arrow-left me-2"></i>

            Back

        </a>

    </div>

    <form id="kpiForm" method="POST" action="{{ route('kpi.master.update',$kpi->id) }}">

        @csrf
        @method('PUT')

        <div class="row">

            {{-- LEFT --}}
            <div class="col-xl-8">

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-warning bg-opacity-10
                                d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px">

                                <i class="fas fa-chart-line text-warning"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-1">

                                    KPI Information

                                </h5>

                                <small class="text-muted">

                                    Update KPI information.

                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body p-4">

                        {{-- KPI NAME --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                KPI Name

                                <span class="text-danger">*</span>

                            </label>

                            <input id="name" name="name" type="text" autocomplete="off"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name',$kpi->name) }}" placeholder="Example : Sales Performance KPI">

                            @error('name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                        {{-- DESCRIPTION --}}
                        <div>

                            <label class="form-label fw-semibold">

                                Description

                            </label>

                            <textarea id="description" name="description" rows="8"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe KPI...">{{ old('description',$kpi->description) }}</textarea>

                            @error('description')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-xl-4">

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-success bg-opacity-10
                                d-flex align-items-center justify-content-center me-3" style="width:45px;height:45px">

                                <i class="fas fa-cog text-success"></i>

                            </div>

                            <div>

                                <h6 class="fw-bold mb-0">

                                    Configuration

                                </h6>

                                <small class="text-muted">

                                    KPI Settings

                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

                        {{-- Status --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold d-block">
                                Status
                            </label>

                            <div class="form-check form-switch">

                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{
                                    old('status', $kpi->status) ? 'checked' : '' }}>

                                <label class="form-check-label" for="status">
                                    Active KPI
                                </label>

                            </div>

                            <small class="text-muted">
                                Inactive KPI will not appear in KPI Assessment.
                            </small>

                        </div>

                    </div>

                </div>

                {{-- Information Card --}}
                <div class="card border-0 bg-light shadow-sm">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3">

                            <i class="fas fa-lightbulb text-warning me-2"></i>

                            Best Practice

                        </h6>

                        <ul class="small text-muted mb-0">

                            <li>Use a KPI name that is easy to understand.</li>


                            <li>Disable KPIs that are no longer used.</li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        {{-- Footer --}}
        <div class="card border-0 shadow-sm mt-4">

            <div class="card-body">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('kpi.master.index') }}" class="btn btn-light border">

                        Cancel

                    </a>

                    <button id="saveBtn" type="submit" class="btn btn-warning px-5">

                        <i class="fas fa-save me-2"></i>

                        Update KPI Master

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function(){
                                            
                                                const form = document.getElementById('kpiForm');
                                            
                                                const saveBtn = document.getElementById('saveBtn');
                                            
                                                form.addEventListener('submit', function(e){
                                            
                                                    e.preventDefault();
                                            
                                                    document.querySelectorAll('.is-invalid').forEach(function(el){
                                            
                                                        el.classList.remove('is-invalid');
                                            
                                                    });
                                            
                                                    let valid = true;
                                            
                                                    if(document.getElementById('name').value.trim() === ''){
                                            
                                                        document.getElementById('name').classList.add('is-invalid');
                                            
                                                        valid = false;
                                            
                                                    }
                                            
                                                    
                                            
                                            
                                                    if(!valid){
                                            
                                                        Swal.fire({
                                            
                                                            icon:'warning',
                                            
                                                            title:'Validation',
                                            
                                                            text:'Please complete all required fields.',
                                            
                                                            confirmButtonColor:'#0d6efd'
                                            
                                                        });
                                            
                                                        return;
                                            
                                                    }
                                            
                                                    Swal.fire({
                                            
                                                        title:'Update KPI Master?',
                                            
                                                        text:'Changes will be saved.',
                                            
                                                        icon:'question',
                                            
                                                        showCancelButton:true,
                                            
                                                        confirmButtonText:'Yes, Update',
                                            
                                                        cancelButtonText:'Cancel',
                                            
                                                        confirmButtonColor:'#f59e0b',
                                            
                                                        cancelButtonColor:'#6c757d',
                                            
                                                        reverseButtons:true
                                            
                                                    }).then((result)=>{
                                            
                                                        if(result.isConfirmed){
                                            
                                                            saveBtn.disabled = true;
                                            
                                                            saveBtn.innerHTML =
                                                                '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
                                            
                                                            form.submit();
                                            
                                                        }
                                            
                                                    });
                                            
                                                });
                                            
                                            });
                                            
</script>

@if(session('success'))

<script>
    Swal.fire({
                                            
                                                icon:'success',
                                            
                                                title:'Success',
                                            
                                                text:'{{ session("success") }}',
                                            
                                                timer:2000,
                                            
                                                showConfirmButton:false
                                            
                                            });
                                            
</script>

@endif

@if($errors->any())

<script>
    Swal.fire({
                                            
                                                icon:'warning',
                                            
                                                title:'Validation Failed',
                                            
                                                text:'Please check the highlighted fields.'
                                            
                                            });
                                            
</script>

@endif

@endpush


@push('styles')

<style>
    .card {

        border-radius: 14px;

    }

    .card-header {

        border-bottom: 1px solid #edf2f7;

    }

    .form-control,
    .form-select {

        min-height: 48px;

        border-radius: 10px;

    }

    .form-control:focus,
    .form-select:focus {

        box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .15);

    }

    .btn {

        border-radius: 10px;

    }

    .btn-warning {

        color: #fff;

    }

    .form-check-input {

        width: 3rem;

        height: 1.5rem;

    }
</style>

@endpush