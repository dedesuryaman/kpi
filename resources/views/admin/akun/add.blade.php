@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Tambah Akun Pengguna</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Akun</a></li>
                    <li class="breadcrumb-item active">Tambah Akun</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="container mt-5">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-light">Tambah User</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}" autocomplete="off">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', '') }}" placeholder="Nama" autocomplete="off"
                                required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', '') }}" placeholder="Email" autocomplete="new-email"
                                required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe User</label>
                            <div>
                                <input type="radio" name="selectType" value="opd" id="typeOpd" checked> OPD
                                <input type="radio" name="selectType" value="kontraktor" id="typeKon">
                                Kontraktor/Konsultan
                            </div>
                        </div>
                        <div class="mb-3" id="opdSelectDiv">
                            <label for="ref_sub_unit_id" class="form-label">Pilih OPD</label>
                            <select name="ref_sub_unit_id" class="form-select">
                                <option value="">--All--</option>>
                                @foreach($ref_sub_units as $unit)
                                <option value="{{ $unit->id }}" {{ old('ref_sub_unit_id')==$unit->id ? 'selected' : ''
                                    }}>
                                    {{ $unit->nm_sub_unit }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="kontraktorSelectDiv" style="display:none;">
                            <label for="kontraktor_id" class="form-label">Pilih Kontraktor</label>
                            <select name="kontraktor_id" class="form-select">
                                @foreach($kontraktors as $k)
                                <option value="{{ $k->id }}" {{ old('kontraktor_id')==$k->id ? 'selected' : '' }}>
                                    {{ $k->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Role Checkbox Dinamis -->
                        <div class="mb-3">
                            <label class="form-label">Roles</label>
                            <div class="d-flex flex-wrap gap-2" id="rolesContainer">
                                @foreach($roles as $role)
                                <div class="form-check form-switch role-item"
                                    data-prefix="{{ explode('_',$role->name)[0] }}">
                                    <input class="form-check-input" type="checkbox" name="roles[]"
                                        value="{{ $role->id }}" id="role{{ $role->id }}" {{ in_array($role->id,
                                    old('roles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role{{ $role->id }}">
                                        {{ str_replace('_',' ', $role->name) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password (default: pass1234)</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password" autocomplete="new-password"
                                    value="pass1234">
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="bx bx-show"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="randomPasswordCheck">
                            <label class="form-check-label" for="randomPasswordCheck">
                                Generate random secure password
                            </label>
                        </div>


                        <hr>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-save me-1"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Show/Hide password
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bx-show');
        this.querySelector('i').classList.toggle('bx-hide');
    });

    // Random password generator
    const randomCheck = document.querySelector('#randomPasswordCheck');
    randomCheck.addEventListener('change', function () {
        if(this.checked){
            passwordInput.value = generateRandomPassword(12);
        } else {
            passwordInput.value = 'pass1234';
        }
    });

    function generateRandomPassword(length) {
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
        let password = "";
        for (let i = 0, n = charset.length; i < length; ++i) {
            password += charset.charAt(Math.floor(Math.random() * n));
        }
        return password;
    }
</script>


<script>
    const typeOpd = document.getElementById('typeOpd');
    const typeKon = document.getElementById('typeKon');
    const opdDiv = document.getElementById('opdSelectDiv');
    const kontraktorDiv = document.getElementById('kontraktorSelectDiv');
    const roleItems = document.querySelectorAll('.role-item');

    function updateForm() {
        if(typeOpd.checked){
            opdDiv.style.display = 'block';
           
            kontraktorDiv.style.display = 'none';
            // tampilkan role selain kon_
            roleItems.forEach(item=>{
                const prefix = item.dataset.prefix;
                if(prefix === 'kon'){
                    item.style.display = 'none';
                    item.querySelector('input').checked = false;
                } else {
                    item.style.display = 'block';
                }
            });
 
             
        } else {
            opdDiv.style.display = 'none';
            kontraktorDiv.style.display = 'block';
            // tampilkan role dengan prefix kon_
            roleItems.forEach(item=>{
                const prefix = item.dataset.prefix;
                if(prefix === 'kon'){
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                    item.querySelector('input').checked = false;
                }
            });
        }
    }

    typeOpd.addEventListener('change', updateForm);
    typeKon.addEventListener('change', updateForm);

    // inisialisasi saat load
    updateForm();
</script>

@endpush