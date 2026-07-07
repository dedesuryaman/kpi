@extends('layouts.admin.app')
@push('title', 'Tambah Kontraktor')

@section('content')

{{-- ===================== PAGE TITLE ===================== --}}
<div class="row mb-4">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<div>
				<h4 class="mb-1 fw-semibold">Tambah Data Kontraktor</h4>
				<p class="text-muted mb-0">
					Silakan lengkapi informasi perusahaan kontraktor secara lengkap dan valid.
				</p>
			</div>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="{{ route('kontraktor.index') }}">Kontraktor</a>
					</li>
					<li class="breadcrumb-item active">Tambah</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6 offset-3">
		{{-- ===================== FORM ===================== --}}
		<form method="POST" action="{{ route('kontraktor.store') }}">
			@csrf

			<div class="card border-0 shadow-sm">

				{{-- Card Header --}}
				<div class="card-header bg-light border-bottom">
					<h5 class="mb-0 fw-semibold">
						Informasi Perusahaan
					</h5>
				</div>

				{{-- Card Body --}}
				<div class="card-body">

					<div class="row g-4">

						{{-- Nama Perusahaan --}}
						<div class="col-md-6">
							<label class="form-label fw-semibold">
								Nama Perusahaan <span class="text-danger">*</span>
							</label>
							<input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
								value="{{ old('name') }}" placeholder="Masukkan nama perusahaan">
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- Nomor Telepon --}}
						<div class="col-md-6">
							<label class="form-label fw-semibold">
								Nomor Telepon
							</label>
							<input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
								value="{{ old('phone') }}" placeholder="Contoh: 0812xxxxxxx">
							@error('phone')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- Email --}}
						<div class="col-md-6">
							<label class="form-label fw-semibold">
								Email Perusahaan
							</label>
							<input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
								value="{{ old('email') }}" placeholder="email@perusahaan.com">
							@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- Website --}}
						<div class="col-md-6">
							<label class="form-label fw-semibold">
								Website
							</label>
							<input type="text" name="website"
								class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}"
								placeholder="https://www.perusahaan.com">
							@error('website')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- Alamat --}}
						<div class="col-12">
							<label class="form-label fw-semibold">
								Alamat Perusahaan
							</label>
							<textarea name="address" rows="4"
								class="form-control @error('address') is-invalid @enderror"
								placeholder="Masukkan alamat lengkap perusahaan">{{ old('address') }}</textarea>
							@error('address')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

					</div>

				</div>

				{{-- Card Footer --}}
				<div class="card-footer bg-light d-flex justify-content-end gap-2">

					<a href="{{ route('kontraktor.index') }}" class="btn btn-light px-4">
						Batal
					</a>

					<button type="submit" class="btn btn-primary px-4">
						<i class="mdi mdi-content-save-outline me-1"></i>
						Simpan Data
					</button>

				</div>

			</div>

		</form>
	</div>
</div>
@endsection