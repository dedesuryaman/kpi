@extends('layouts.admin.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-5">


                    <h1 class="display-1 text-secondary mb-3">404</h1>

                    <h4 class="mb-2">Halaman Tidak Ditemukan</h4>

                    <p class="text-muted">
                        Maaf, halaman yang Anda cari tidak tersedia atau tidak dapat diakses.
                    </p>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mt-3">
                        Kembali ke Dashboard
                    </a>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection