@extends('layouts.admin.app')
@push('title', "Settings")
@section('content')
<div class="container">
    <h4>Pengaturan Aplikasi</h4>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('settings.update') }}">
        @csrf

        @foreach($settings as $group => $items)
        <div class="card mb-3">
            <div class="card-header fw-bold text-capitalize">
                {{ str_replace('_',' ', $group) }}
            </div>

            <div class="card-body">
                @foreach($items as $setting)
                <div class="mb-3">
                    <label class="form-label">
                        {{ ucfirst(str_replace('_',' ', $setting->setting_key)) }}
                    </label>

                    @include('settings.partials.input', ['setting' => $setting])
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <button class="btn btn-primary">
            Simpan Pengaturan
        </button>
    </form>
</div>
@endsection