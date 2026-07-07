@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Mobile App Config</h4>


        </div>
    </div>
</div>

<div class="container card p-3 mt-3">

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Platform</th>
                <th>Current Version</th>
                <th>Min Version</th>
                <th>Force Update</th>
                <th>Maintenance</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($configs as $c)
            <tr>
                <td>{{ strtoupper($c->platform) }}</td>
                <td>{{ $c->current_version }}</td>
                <td>{{ $c->min_version }}</td>
                <td>
                    <span class="badge {{ $c->force_update ? 'bg-danger' : 'bg-secondary' }}">
                        {{ $c->force_update ? 'YES' : 'NO' }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $c->maintenance_mode ? 'bg-warning' : 'bg-success' }}">
                        {{ $c->maintenance_mode ? 'ON' : 'OFF' }}
                    </span>
                </td>
                <td>
                    <a href="{{ url('admin/app-config/'.$c->platform.'/edit') }}"
                        class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection