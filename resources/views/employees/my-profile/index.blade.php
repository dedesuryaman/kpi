@extends('layouts.admin.app')

@section('title', 'My Profile')

@section('content')

<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}

        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">

        {{-- LEFT --}}
        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-body text-center">

                    @php
                    $photo = $employee->photo
                    ? asset('storage/'.$employee->photo)
                    : asset('images/avatar.png');
                    @endphp

                    <img src="{{ $photo }}" class="rounded-circle shadow mb-3" width="140" height="140"
                        style="object-fit:cover">

                    <h4 class="fw-bold mb-1">
                        {{ $employee->name }}
                    </h4>

                    <div class="text-muted">

                        {{ optional($employee->position)->name }}

                    </div>

                    <div class="text-muted">

                        {{ optional($employee->department)->name }}

                    </div>

                    <hr>

                    <span class="badge bg-success px-3 py-2">

                        <i class="fas fa-check-circle me-1"></i>

                        Active Employee

                    </span>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-8">

            {{-- Personal --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        <i class="fas fa-user text-primary me-2"></i>

                        Personal Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Full Name
                        </div>

                        <div class="col-md-8">
                            {{ $employee->name }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Email
                        </div>

                        <div class="col-md-8">
                            {{ $user->email }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Phone
                        </div>

                        <div class="col-md-8">
                            {{ $employee->phone ?? '-' }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Gender
                        </div>

                        <div class="col-md-8">
                            {{ $employee->gender ?? '-' }}
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4 fw-semibold">
                            Address
                        </div>

                        <div class="col-md-8">
                            {{ $employee->address ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- Employment --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        <i class="fas fa-briefcase text-success me-2"></i>

                        Employment Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Employee ID
                        </div>

                        <div class="col-md-8">
                            {{ $employee->employee_code }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Position
                        </div>

                        <div class="col-md-8">
                            {{ optional($employee->position)->name }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Department
                        </div>

                        <div class="col-md-8">
                            {{ optional($employee->department)->name }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Division
                        </div>

                        <div class="col-md-8">
                            {{ optional($employee->department->division)->name }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Supervisor
                        </div>

                        <div class="col-md-8">
                            {{ optional($employee->leader)->name ?? '-' }}
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4 fw-semibold">
                            Join Date
                        </div>

                        <div class="col-md-8">
                            {{ $employee->join_date ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- Account --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        <i class="fas fa-user-shield text-warning me-2"></i>

                        Account Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Username
                        </div>

                        <div class="col-md-8">
                            {{ $user->name }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 fw-semibold">
                            Email Login
                        </div>

                        <div class="col-md-8">
                            {{ $user->email }}
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4 fw-semibold">
                            Role
                        </div>

                        <div class="col-md-8">

                            @foreach($user->getRoleNames() as $role)

                            <span class="badge bg-primary">

                                {{ ucfirst($role) }}

                            </span>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

            {{-- Change Password --}}
            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        <i class="fas fa-lock text-danger me-2"></i>

                        Change Password

                    </h5>

                </div>

                <form method="POST" action="{{ route('my-profile.password') }}">

                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Current Password
                            </label>

                            <input type="password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror">

                            @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="mb-0">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input type="password" name="password_confirmation" class="form-control">

                        </div>

                    </div>

                    <div class="card-footer bg-white text-end">

                        <button class="btn btn-primary">

                            <i class="fas fa-save me-1"></i>

                            Update Password

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection