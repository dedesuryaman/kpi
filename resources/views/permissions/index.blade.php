@extends('layouts.admin.app')
@push('title' , 'Permissions')
@section('content')
<div class="container card">
    <div class='card-body'>
        <div class="d-flex justify-content-between mb-3">
            <h4>Manajemen Permission</h4>

            @can('permission.create')
            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                + Permission
            </a>
            @endcan
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="grid">
            <thead>
                <tr>
                    <th width="60px;">#</th>
                    <th>Nama Permission</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <code>{{ $permission->name }}</code>
                    </td>
                    <td>
                        @can('permission.edit')
                        <a href="{{ route('permissions.edit',$permission) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endcan

                        @can('permission.delete')
                        <form action="{{ route('permissions.destroy',$permission) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus permission?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection