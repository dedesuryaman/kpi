@extends('layouts.admin.app')

@section('content')

<section class="content-header">

    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Role Management</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active">Update Role</li>
            </ol>
        </div>

    </div>


</section>
<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-6">


            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Edit Role</h3>
                </div>

                <form method="POST" action="{{ route('roles.update',$role) }}">
                    @csrf @method('PUT')

                    <div class="card-body">

                        {{-- ROLE NAME --}}
                        <div class="form-group">
                            <label>Nama Role</label>
                            <input type="text" name="name" value="{{ $role->name }}" class="form-control" required>
                        </div>

                        <hr>

                        {{-- PERMISSIONS --}}
                        @foreach($permissions as $module => $perms)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong class="text-capitalize">
                                    {{ str_replace('-', ' ', $module) }}
                                </strong>
                            </div>

                            <div class="card-body row">

                                @foreach($perms as $permission)
                                <div class="col-md-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="perm_{{ $permission->id }}" name="permissions[]"
                                            value="{{ $permission->name }}" {{
                                            in_array($permission->name,$rolePermissions) ? 'checked' : '' }}>

                                        <label class="custom-control-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        @endforeach

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-warning">Update</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>

    @endsection