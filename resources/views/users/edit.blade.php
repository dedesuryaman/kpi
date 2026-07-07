@extends('layouts.admin.app')
@push('title' , 'Update Akun')
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
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0 text-light"><i class="bx bx-user me-2"></i> Edit User</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
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

                        <div class="mb-3">
                            <label class="form-label">Tipe User</label>
                            <div>
                                <input type="radio" name="selectType" value="opd" id="typeOpd" {{
                                    $user->subunits->isNotEmpty() || $user->roles() ? 'checked' : '' }}> OPD
                                <input class="ms-4 " type="radio" name="selectType" value="kontraktor" id="typeKon" {{
                                    $user->kontraktors->isNotEmpty() ? 'checked' :
                                '' }}> Kontraktor/Konsultan
                            </div>
                        </div>
                        <div class="mb-3" id="opdSelectDiv">
                            <label for="ref_sub_unit_id" class="form-label">Pilih OPD</label>
                            <select name="ref_sub_unit_id" class="form-select form-control">
                                <option value="0">
                                    --All--
                                </option>
                                @foreach($ref_sub_units as $unit)
                                @php
                                // cek apakah user punya opd ini
                                //$selected = $user->subunits->contains('id', $unit->id);
                                $selected = $user->opds->contains('id', $unit->id);
                                @endphp
                                <option value="{{ $unit->id }}" {{ old('opd_id', $selected ? $unit->id : null) ==
                                    $unit->id
                                    ? 'selected' : '' }}>
                                    {{ $unit->nm_unit /*$unit->nm_sub_unit*/ }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="kontraktorSelectDiv" style="display:none;">
                            <label for="kontraktor_id" class="form-label">Pilih Kontraktor</label>
                            <select name="kontraktor_id" class="form-select form-control">
                                @foreach($kontraktors as $k)
                                @php
                                $selected = $user->kontraktors->contains('id', $k->id);
                                @endphp
                                <option value="{{ $k->id }}" {{ old('kontraktor_id', $selected ? $k->id : null) ==
                                    $k->id ? 'selected' : '' }}>
                                    {{ $k->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Role Checkbox Dinamis -->
                        <div class="mb-3 shw" style="display:none;">
                            <label class="form-label">Roles</label>
                            <div class="px-3">
                                <!-- Feedback error -->
                                @error('roles')
                                <div class="invalid-feedback d-block alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="d-flex flex-wrap form-check form-switch" id="rolesContainer"
                                    style="display:none;">
                                    @foreach($roles as $role)
                                    @php
                                    // Ambil role ID user saat ini
                                    $userRoleIds = $user->roles->pluck('id')->toArray();
                                    @endphp
                                    <div class="form-check role-item" data-prefix="{{ explode('_',$role->name)[0] }}"
                                        style="width: 33.33%; padding: 5px;">
                                        <input class="form-check-input @error('roles') is-invalid @enderror"
                                            type="checkbox" name="roles[]" value="{{ $role->id }}"
                                            id="role{{ $role->id }}" {{ in_array($role->id, old('roles', $userRoleIds))
                                        ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role{{ $role->id }}">
                                            {{ str_replace('_',' ', $role->name) }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>

                            </div>

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

<script>

</script>

<script>
    const typeOpd = document.getElementById('typeOpd');
    const typeKon = document.getElementById('typeKon');
    const opdDiv = document.getElementById('opdSelectDiv');
    const kontraktorDiv = document.getElementById('kontraktorSelectDiv');
    const roleItems = document.querySelectorAll('.role-item');

    function updateSelectVisibility() {
        $('.shw').hide(100);
            if(typeOpd.checked){
                 opdDiv.style.display = 'block';
                kontraktorDiv.style.display = 'none';
             } else {
                 opdDiv.style.display = 'none';
                kontraktorDiv.style.display = 'block';

    
             }
             $('.shw').show(500);
    }
    
    typeOpd.addEventListener('change', updateSelectVisibility);
    typeKon.addEventListener('change', updateSelectVisibility);
    
    // Inisialisasi saat load
    updateSelectVisibility();
    
    $(document).ready(function(){
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

        $('.shw').show(500);
    }

    typeOpd.addEventListener('change', updateForm);
    typeKon.addEventListener('change', updateForm);

    // inisialisasi saat load
    updateForm();
})
</script>
@endpush