@extends('layouts.admin.app')
@push('title', 'Update Data Kontraktor')

@section('content')

<div class="row mb-4">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<div>
				<h4 class="mb-1">Update Data Kontraktor</h4>
				<p class="text-muted mb-0">Perbarui informasi perusahaan kontraktor secara lengkap dan akurat.</p>
			</div>

			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="{{ route('kontraktor.index') }}">Kontraktor</a>
					</li>
					<li class="breadcrumb-item active">Update</li>
				</ol>
			</div>
		</div>
	</div>
</div>

@can('kontraktor.edit')
@php $lock = ""; @endphp
@else
@php $lock = "readonly disabled"; @endphp
@endcan
<div class="row">
	<div class="col-md-6 offset-3">
		<div class="card shadow-sm border-0">
			<div class="card-header bg-light">
				<h5 class="mb-0">Informasi Perusahaan</h5>
			</div>

			<div class="card-body">
				<form method="POST" action="{{ route('kontraktor.update', $kontraktor->id) }}">
					@csrf
					@method('PUT')

					<div class="row g-4">

						{{-- Nama Perusahaan --}}
						<div class="col-md-6">
							<label class="form-label fw-semibold">
								Nama Perusahaan <span class="text-danger">*</span>
							</label>
							<input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
								value="{{ old('name', $kontraktor->name) }}" placeholder="Masukkan nama perusahaan" {{
								$lock }}>
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- Phone --}}
						<div class="col-md-6">
							<label class="form-label fw-semibold">Nomor Telepon</label>
							<input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
								value="{{ old('phone', $kontraktor->phone) }}" placeholder="Contoh: 081234567890" {{
								$lock }}>
							@error('phone')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- Email --}}
						<div class="col-md-6">
							<label class="form-label fw-semibold">Email</label>
							<input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
								value="{{ old('email', $kontraktor->email) }}" placeholder="contoh@email.com" {{ $lock
								}}>
							@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- Website --}}
						<div class="col-md-6">
							<label class="form-label fw-semibold">Website</label>
							<input type="text" name="website"
								class="form-control @error('website') is-invalid @enderror"
								value="{{ old('website', $kontraktor->website) }}" placeholder="https://perusahaan.com"
								{{ $lock }}>
							@error('website')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- Alamat --}}
						<div class="col-12">
							<label class="form-label fw-semibold">Alamat Perusahaan</label>
							<textarea name="address" rows="4"
								class="form-control @error('address') is-invalid @enderror"
								placeholder="Masukkan alamat lengkap perusahaan" {{ $lock
								}}>{{ old('address', $kontraktor->address) }}</textarea>
							@error('address')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

					</div>

					@can('kontraktor.edit')
					<div class="mt-4 d-flex justify-content-end gap-2">
						<a href="{{ route('kontraktor.index') }}" class="btn btn-light">
							Batal
						</a>
						<button type="submit" class="btn btn-primary px-4">
							<i class="mdi mdi-content-save-outline me-1"></i> Update Data
						</button>
					</div>
					@endcan

				</form>
			</div>
		</div>
	</div>
</div>
@endsection