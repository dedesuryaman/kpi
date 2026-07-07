@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Mobile App Config</h4>


        </div>
    </div>
</div>

<div class="container card p-3 mt-5">
    <h4>Edit App Config - {{ strtoupper($config->platform) }}</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('admin/app-config/'.$config->platform) }}">
        @csrf

        <div class="mb-3">
            <label>Current Version</label>
            <input class="form-control" name="current_version" value="{{ $config->current_version }}">
        </div>

        <div class="mb-3">
            <label>Minimum Version</label>
            <input class="form-control" name="min_version" value="{{ $config->min_version }}">
        </div>

        <div class="mb-3">
            <label>Build Number</label>
            <input class="form-control" name="build_number" value="{{ $config->build_number }}">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="force_update" {{ $config->force_update ? 'checked' :
            '' }}>
            <label class="form-check-label">Force Update</label>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="maintenance_mode" {{ $config->maintenance_mode ?
            'checked' : '' }}>
            <label class="form-check-label">Maintenance Mode</label>
        </div>

        <div class="mb-3">
            <label>Maintenance Message</label>
            <textarea class="form-control" name="maintenance_message">{{ $config->maintenance_message }}</textarea>
        </div>

        <div class="mb-3">
            <label>Update URL</label>
            <input class="form-control" name="update_url" value="{{ $config->update_url }}">
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection