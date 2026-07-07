@extends('layouts.admin.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">

        {{-- Profile --}}
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-circle me-2"></i>
                        My Profile
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-3 text-center mb-4">

                                @if($employee?->photo)
                                <img src="{{ asset('storage/'.$employee->photo) }}"
                                    class="img-fluid rounded-circle border shadow"
                                    style="width:160px;height:160px;object-fit:cover;">
                                @else
                                <img src="{{ asset('images/avatar.png') }}"
                                    class="img-fluid rounded-circle border shadow"
                                    style="width:160px;height:160px;object-fit:cover;">
                                @endif

                            </div>

                            <div class="col-md-9">

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Name
                                        </label>

                                        <input type="text" name="name" value="{{ old('name',$user->name) }}"
                                            class="form-control @error('name') is-invalid @enderror">

                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Email
                                        </label>

                                        <input type="email" name="email" value="{{ old('email',$user->email) }}"
                                            class="form-control @error('email') is-invalid @enderror">

                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Employee Code
                                        </label>

                                        <input class="form-control" value="{{ $employee?->employee_code ?? '-' }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Role
                                        </label>

                                        <input class="form-control"
                                            value="{{ $user->roles->pluck('name')->join(', ') }}" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Department
                                        </label>

                                        <input class="form-control" value="{{ $employee?->department?->name ?? '-' }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Position
                                        </label>

                                        <input class="form-control" value="{{ $employee?->position?->name ?? '-' }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Supervisor
                                        </label>

                                        <input class="form-control" value="{{ $employee?->leader?->name ?? '-' }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Join Date
                                        </label>

                                        <input class="form-control"
                                            value="{{ $employee?->join_date?->format('d M Y') ?? '-' }}" readonly>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <button class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Save Changes
                        </button>

                    </form>

                </div>

            </div>

        </div>

        {{-- Password --}}
        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-lock me-2"></i>
                        Change Password
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
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

                            <label class="form-label fw-semibold">
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

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Confirm Password
                            </label>

                            <input type="password" name="password_confirmation" class="form-control">

                        </div>

                        <button class="btn btn-danger w-100">
                            <i class="fas fa-key me-1"></i>
                            Change Password
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection