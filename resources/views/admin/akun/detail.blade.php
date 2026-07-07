@extends('layouts.admin.app')

@push('title', 'Detail Akun')

@section('content')

<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0 font-size-18">Akun Pengguna</h4>

			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Akun</a></li>
					<li class="breadcrumb-item active">Detail Akun</li>
				</ol>
			</div>

		</div>
	</div>
</div>

<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">

			<div class="card shadow-sm">
				<div class="card-header bg-primary text-white d-flex align-items-center">
					<i class="bx bx-user me-2"></i>
					<h5 class="mb-0 text-light">Profile User</h5>
				</div>

				<div class="card-body text-center">
					<!-- Avatar / profile image -->
					<img src="{{ $user->avatar ?  asset('storage/'.$user->avatar) : asset('assets/images/default-avatar.png') }}"
						class="rounded-circle mb-3" width="120" height="120" alt="Avatar">

					<!-- Name -->
					<h4 class="card-title">{{ $user->name }}</h4>

					<!-- Email -->
					<p class="text-muted mb-1"><i class="bx bx-envelope me-1"></i> {{ $user->email }}</p>

					<!-- Role -->
					<p class="text-muted mb-3">
						<i class="bx bx-shield-quarter me-1"></i>
						Roles: <br>
						@foreach($user->getRoleNames() as $role)
						<span class="badge bg-success">{{ $role }}</span>
						@endforeach
					</p>

					<!-- Status -->
					<p class="mb-3">
						Status:<br>
						@if($user->status === 'active')
						<span class="badge bg-primary">Active</span>
						@else
						<span class="badge bg-secondary">Inactive</span>
						@endif
					</p>

					<!-- Optional: Edit profile button -->
					<div class="g-3">
						@can('user.edit')
						<a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
							<i class="bx bx-edit-alt me-1"></i> Edit Profile
						</a>
						<a href="{{ route('admin.akun.reset-password', $user->id) }}" class="btn btn-danger btn-sm">
							<i class="bx bx-key me-1"></i> Reset Password
						</a>
						@endcan

					</div>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection