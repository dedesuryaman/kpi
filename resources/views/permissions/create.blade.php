@extends('layouts.admin.app')
@push('title' , 'Permissions')
@section('content')
<div class="container col-md-6">


    <div class="card">
        <div class="card-body">
            <h4>Tambah Permission</h4>

            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Permission</label>
                    <input type="text" name="name" class="form-control" placeholder="contoh: project.create" required>
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-primary btn-sm">Simpan</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">
                    Kembali
                </a>
            </form>
        </div>
    </div>

</div>
@endsection