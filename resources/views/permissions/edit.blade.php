@extends('layouts.admin.app')
@push('title' , 'Permissions')
@section('content')
<div class="container col-md-6">


    <div class="card">
        <div class="card-body">

            <h4>Edit Permission</h4>

            <form action="{{ route('permissions.update',$permission) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label>Nama Permission</label>
                    <input type="text" name="name" value="{{ $permission->name }}" class="form-control" required>
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-primary btn-sm">Update</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">
                    Kembali
                </a>
            </form>
        </div>
    </div>

</div>
@endsection