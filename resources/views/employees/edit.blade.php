@extends('layouts.admin.app')

@section('title', 'Edit Employee')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Edit Employee
            </h3>

            <p class="text-muted mb-0">
                Update employee profile, organizational assignment and employment information.
            </p>
        </div>

        <a href="{{ route('employees.index') }}" class="btn btn-light border">

            <i class="fas fa-arrow-left me-2"></i>

            Back

        </a>

    </div>

    <form action="{{ route('employees.update',$employee->id) }}" method="POST" id="employeeForm"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

            {{-- Left --}}
            <div class="col-lg-8">

                {{-- Employee Information --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <div class="d-flex align-items-center">

                            <div class="avatar-sm rounded-circle bg-primary bg-opacity-10
                                        d-flex align-items-center justify-content-center me-3">

                                <i class="fas fa-user text-primary"></i>

                            </div>

                            <div>

                                <h5 class="mb-0 fw-bold">
                                    Employee Information
                                </h5>

                                <small class="text-muted">
                                    Basic employee identity information.
                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            {{-- Employee Code --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Employee Code

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text" name="employee_code"
                                    class="form-control @error('employee_code') is-invalid @enderror"
                                    value="{{ old('employee_code',$employee->employee_code) }}" placeholder="EMP0001">

                                @error('employee_code')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>

                            {{-- Full Name --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Full Name

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name',$employee->name) }}" placeholder="Employee Name">

                                @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>

                            {{-- Birth Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Birth Date
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="date" name="birth_date"
                                    class="form-control @error('birth_date') is-invalid @enderror"
                                    value="{{ old('birth_date', $employee->birth_date) }}">

                                @error('birth_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Birth Place --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Birth Place

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text" name="birth_place"
                                    class="form-control @error('birth_place') is-invalid @enderror"
                                    value="{{ old('birth_place',$employee->birth_place) }}" placeholder="Ex: Bandung">

                                @error('birth_place')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>

                            <!---->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Religion
                                </label>

                                <select name="religion"
                                    class="form-select select2 @error('religion') is-invalid @enderror">

                                    <option value="">-- Select Religion --</option>

                                    <option value="Islam" @selected(old('religion', $employee->religion ?? '') ==
                                        'Islam')>
                                        Islam
                                    </option>

                                    <option value="Kristen" @selected(old('religion', $employee->religion ?? '') ==
                                        'Kristen')>
                                        Kristen
                                    </option>

                                    <option value="Katolik" @selected(old('religion', $employee->religion ?? '') ==
                                        'Katolik')>
                                        Katolik
                                    </option>

                                    <option value="Hindu" @selected(old('religion', $employee->religion ?? '') ==
                                        'Hindu')>
                                        Hindu
                                    </option>

                                    <option value="Buddha" @selected(old('religion', $employee->religion ?? '') ==
                                        'Buddha')>
                                        Buddha
                                    </option>

                                    <option value="Konghucu" @selected(old('religion', $employee->religion ?? '') ==
                                        'Konghucu')>
                                        Konghucu
                                    </option>

                                </select>

                                @error('religion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Email
                                </label>

                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="example@company.com"
                                    value="{{ old('email', $employee->email ?? '') }}">

                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Phone Number
                                </label>

                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" placeholder="081234567890"
                                    value="{{ old('phone', $employee->phone ?? '') }}">

                                @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Address
                                </label>

                                <textarea name="address"
                                    class="form-control @error('address') is-invalid @enderror">{{ old('address', $employee->address ?? '') }}</textarea>

                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Organization Information --}}
                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white">

                            <div class="d-flex align-items-center">

                                <div class="avatar-sm rounded-circle bg-success bg-opacity-10
                                        d-flex align-items-center justify-content-center me-3">

                                    <i class="fas fa-building text-success"></i>

                                </div>

                                <div>

                                    <h5 class="mb-0 fw-bold">
                                        Organization Information
                                    </h5>

                                    <small class="text-muted">
                                        Department, position and reporting structure.
                                    </small>

                                </div>

                            </div>

                        </div>

                        <div class="card-body">

                            <div class="row g-4">

                                {{-- Department --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">

                                        Department

                                        <span class="text-danger">*</span>

                                    </label>

                                    <select name="department_id" id="department"
                                        class="form-select select2 @error('department_id') is-invalid @enderror">

                                        <option value="">
                                            -- Select Department --
                                        </option>

                                        @foreach($departments as $department)

                                        <option value="{{ $department->id }}" @selected(old('department_id',$employee->
                                            department_id)==$department->id)>

                                            {{ $department->name }}

                                        </option>

                                        @endforeach

                                    </select>

                                    @error('department_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror

                                </div>

                                {{-- Position --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">

                                        Position

                                        <span class="text-danger">*</span>

                                    </label>

                                    <select name="position_id" id="position"
                                        class="form-select select2 @error('position_id') is-invalid @enderror">

                                        <option value="">
                                            -- Select Position --
                                        </option>

                                        @foreach($positions as $position)

                                        <option value="{{ $position->id }}" @selected(old('position_id',$employee->
                                            position_id)==$position->id)>

                                            {{ $position->name }}

                                        </option>

                                        @endforeach

                                    </select>

                                    @error('position_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                    @enderror

                                </div>

                                {{-- Role --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">

                                        System Role

                                        <span class="text-danger">*</span>

                                    </label>

                                    <select name="role" class="form-select select2 @error('role') is-invalid @enderror">

                                        <option value="">
                                            -- Select Role --
                                        </option>
                                        @foreach($roles as $role)

                                        <option value="{{ $role->name }}" @selected(old('role', $currentRole)==$role->
                                            name)>

                                            {{ $role->show_name ?? ucfirst($role->name) }}

                                        </option>

                                        @endforeach

                                    </select>

                                    @error('role')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                    @enderror

                                </div>


                                {{-- Leader --}}
                                <div class="col-md-12">

                                    <label class="form-label fw-semibold">

                                        Direct Leader

                                    </label>

                                    <select name="leader_id" id="leader" class="form-select select2">

                                        <option value="">
                                            -- No Leader --
                                        </option>

                                        @foreach($employees as $leader)

                                        @if($leader->id != $employee->id)

                                        <option value="{{ $leader->id }}" @selected(old('leader_id',$employee->
                                            leader_id)==$leader->id)>

                                            {{ $leader->employee_code }}
                                            -
                                            {{ $leader->name }}

                                        </option>

                                        @endif

                                        @endforeach

                                    </select>

                                    <small class="text-muted">

                                        Select the employee's direct supervisor.

                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Employment Information --}}
                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-header bg-white">

                        <div class="d-flex align-items-center">

                            <div
                                class="avatar-sm rounded-circle bg-warning bg-opacity-10
                                                                    d-flex align-items-center justify-content-center me-3">

                                <i class="fas fa-briefcase text-warning"></i>

                            </div>

                            <div>

                                <h5 class="mb-0 fw-bold">
                                    Employment Information
                                </h5>

                                <small class="text-muted">
                                    Employment status and compensation details.
                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            {{-- Join Date --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Join Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="join_date"
                                    class="form-control @error('join_date') is-invalid @enderror"
                                    value="{{ old('join_date', optional($employee->join_date)->format('Y-m-d')) }}">

                                @error('join_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- Employment Status --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Employment Status
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="employment_status"
                                    class="form-select @error('employment_status') is-invalid @enderror">

                                    <option value="">
                                        -- Select Status --
                                    </option>

                                    <option value="Permanent" @selected(old('employment_status',$employee->
                                        employment_status)=='permanent')>
                                        Permanent
                                    </option>

                                    <option value="Contract" @selected(old('employment_status',$employee->
                                        employment_status)=='contract')>
                                        Contract
                                    </option>

                                    <option value="Probation" @selected(old('employment_status',$employee->
                                        employment_status)=='probation')>
                                        Probation
                                    </option>

                                    <option value="Intern" @selected(old('employment_status',$employee->
                                        employment_status)=='intern')>
                                        Intern
                                    </option>

                                </select>

                                @error('employment_status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- Salary --}}
                            <div class="col-md-12">

                                <label class="form-label fw-semibold">
                                    Salary
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" id="salary" name="salary"
                                    value="{{ old('salary',$employee->salary) }}"
                                    class="form-control @error('salary') is-invalid @enderror" placeholder="0">

                                @error('salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4">

                {{-- Employee Summary --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body text-center">

                        <div class="text-center mb-4">

                            @if($employee->photo)

                            <img id="photoPreview" src="{{ asset('storage/'.$employee->photo) }}"
                                class="rounded-circle shadow border" width="140" height="140" style="object-fit:cover;">

                            @else

                            <img id="photoPreview"
                                src="https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=0D6EFD&color=fff&size=200"
                                class="rounded-circle shadow border" width="140" height="140">

                            @endif

                            <div class="mt-3">

                                <label class="btn btn-primary btn-sm">

                                    <i class="fas fa-camera me-2"></i>

                                    Change Photo

                                    <input type="file" name="photo" id="photo" hidden accept=".jpg,.jpeg,.png">

                                </label>

                            </div>

                            <small class="text-muted d-block mt-2">

                                JPG, PNG (Max 2 MB)

                            </small>

                        </div>

                        <h5 class="fw-bold mb-1">

                            {{ $employee->name }}

                        </h5>

                        <div class="text-muted">

                            {{ $employee->employee_code }}

                        </div>

                        <hr>

                        <div class="row text-center">

                            <div class="col-6">

                                <small class="text-muted d-block">
                                    Department
                                </small>

                                <div class="fw-semibold">
                                    {{ optional($employee->department)->name ?? '-' }}
                                </div>

                            </div>

                            <div class="col-6">

                                <small class="text-muted d-block">
                                    Position
                                </small>

                                <div class="fw-semibold">
                                    {{ optional($employee->position)->name ?? '-' }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Quick Information --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h6 class="fw-bold mb-0">

                            Quick Information

                        </h6>

                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">

                                Created At

                            </span>

                            <strong>

                                {{ $employee->created_at?->format('d M Y') }}

                            </strong>

                        </div>

                        <div class="d-flex justify-content-between">

                            <span class="text-muted">

                                Last Updated

                            </span>

                            <strong>

                                {{ $employee->updated_at?->format('d M Y') }}

                            </strong>

                        </div>

                    </div>

                </div>

                {{-- Action --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-grid gap-2">

                            <button type="submit" class="btn btn-primary" id="btnSave">

                                <i class="fas fa-save me-2"></i>

                                Update Employee

                            </button>

                            <button type="reset" class="btn btn-light border">

                                <i class="fas fa-rotate-left me-2"></i>

                                Reset Form

                            </button>

                            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">

                                <i class="fas fa-arrow-left me-2"></i>

                                Back to Employee List

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
@push('scripts')

<script>
    $(function () {

        $('#photo').change(function(e){
        
        const file = e.target.files[0];
        
        if(!file) return;
        
        const reader = new FileReader();
        
        reader.onload = function(ev){
        
        $('#photoPreview').attr('src', ev.target.result);
        
        }
        
        reader.readAsDataURL(file);
        
        });


    /*
    |--------------------------------------------------------------------------
    | Select2
    |--------------------------------------------------------------------------
    */

    $('.select2').select2({
        width: '100%',
        placeholder: 'Please select',
        allowClear: true
    });


    /*
    |--------------------------------------------------------------------------
    | AutoNumeric - Salary
    |--------------------------------------------------------------------------
    */

    const salary = new AutoNumeric('#salary', {

        digitGroupSeparator: ',',
        decimalCharacter: '.',
        decimalPlaces: 0,
        unformatOnSubmit: true

    });


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    $('button[type="reset"]').on('click', function () {

        setTimeout(function () {

            $('.select2').trigger('change');

        }, 100);

    });


    /*
    |--------------------------------------------------------------------------
    | Submit Confirmation
    |--------------------------------------------------------------------------
    */

    $('#employeeForm').on('submit', function (e) {

        e.preventDefault();

        let form = this;

        Swal.fire({

            title: 'Update Employee?',
            text: 'The employee information will be updated.',
            icon: 'question',

            showCancelButton: true,

            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Yes, Update',
            cancelButtonText: 'Cancel',

            reverseButtons: true

        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Loading Button
            |--------------------------------------------------------------------------
            */

            $('#btnSave')
                .prop('disabled', true)
                .html(`
                    <span class="spinner-border spinner-border-sm me-2"></span>
                    Updating...
                `);

            form.submit();

        });

    });

});

</script>


{{-- Validation Error --}}
@if($errors->any())

<script>
    Swal.fire({

    icon: 'error',

    title: 'Validation Error',

    html: `{!!
        implode('<br>', $errors->all())
    !!}`,

    confirmButtonColor: '#dc3545'

});

</script>

@endif


{{-- Success Message --}}
@if(session('success'))

<script>
    Swal.fire({

    icon: 'success',

    title: 'Success',

    text: "{{ session('success') }}",

    timer: 2500,

    showConfirmButton: false

});

</script>

@endif


{{-- Failed Message --}}
@if(session('error'))

<script>
    Swal.fire({

    icon: 'error',

    title: 'Failed',

    text: "{{ session('error') }}"

});

</script>

@endif

@endpush