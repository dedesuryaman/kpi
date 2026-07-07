@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Update Akun Pengguna</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Akun</a></li>
                    <li class="breadcrumb-item active">Update Akun</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-light"><i class="bx bx-user me-2"></i> Edit User</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Avatar -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                name="avatar" accept="image/*" onchange="previewAvatar(event)">
                            @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <!-- Preview hanya jika avatar ada -->
                            @if($user->avatar)
                            <div class="mt-2 text-center mt-3">
                                <img id="avatarPreview"
                                    src="{{ $user->avatar ?  asset('storage/'.$user->avatar) : asset('assets/images/default-avatar.png') }}"
                                    alt="Avatar" class="rounded-circle" width="100" height="100">
                            </div>
                            @else
                            <div class="mt-2" style="display:none;">
                                <img id="avatarPreview" class="rounded-circle" width="100" height="100">
                            </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function previewAvatar(event) {
        const output = document.getElementById('avatarPreview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.parentElement.style.display = 'block'; // tampilkan preview jika ada file
    }
</script>
@endsection

@push('scripts')

@endpush