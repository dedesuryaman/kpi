@extends('layouts.admin.app')
@push('title' , 'Data Pengawasan')
@push('styles')
<style>
    .card-hover {
        transition: all 0.25s ease-in-out;
        cursor: pointer;
    }


    .card-hover:hover {
        transform: translateY(-6px);
        /* naik */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        /* bayangan */
    }

    .page-header-container {
        border-radius: 6px;
        overflow: hidden;
        background-color: #e5e9f0;

    }

    .page-header-number {
        font-size: 26px;
        font-weight: 700;
        background-color: #acb2bb;
        color: #070d16;
        padding: 15px 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
        border-right: 1px solid #acb2bb;
    }
</style>
@endpush

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row shadow-sm page-header-container">
            <div class="page-header-number flex-shrink-0">
                <i class="bx bx-camera bx-5x text-primary"></i>
            </div>
            <div
                class="page-header-title-bar w-100 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-md-0">
                    <h4 class="mb-0 text-secondary mx-3 mt-3 mt-md-0 font-size-18 fw-bold text-uppercase title-text">
                        Data Pengawasan Proyek , Periode Aktif Tahun {{ session('tahun_aktif') ?? '' }}
                    </h4>
                </div>

                <div class="page-header-extra ms-md-auto text-md-end mt-sm-1 mt-md-0">

                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pengawasan</a></li>
                        <li class="breadcrumb-item active">Listing</li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>

@if($pengawasanhistories->isEmpty())
<div class="col-12">
    <div class="alert alert-warning text-center shadow-sm py-4">

        <div class="mb-3">
            <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size:60px;"></i>
        </div>
        <i class="bx bx-info-circle fa-5x mb-3 text-danger"></i>
        <h6 class="mb-1 fw-bold">Data Tidak Ditemukan</h6>
        <div>Belum ada data pengawasan atau pekerjaan.</div>
    </div>
</div>
@else
<div class="row align-items-stretch">
    @forelse($pengawasanhistories as $row)
    <div class="col-sm-12 col-md-6 col-lg-4 d-flex">
        <div class="card shadow sahadow-sm flex-fill position-relative card-hover">

            <div class="card-body d-flex flex-column">

                {{-- klik seluruh card --}}
                <a href="{{ url('pengawasan/detail?id=' . $row->id ) }}" class="stretched-link"></a>

                {{-- Judul --}}
                <div class="mb-2">
                    <h5 class="mb-1 text-primary">{{ $row->nm_pekerjaan }}</h5>
                    <small class="text-muted">
                        Total Pengawasan
                    </small>
                    <h3 class="mt-1">{{ $row->total_pengawasan }}</h3>
                </div>

                <hr class="my-2">

                {{-- Ringkasan status --}}
                <div class="row text-center">
                    <div class="col">
                        <div class="text-warning fw-bold">{{ $row->total_waitlist }}</div>
                        <small class="text-muted">Wait</small>
                    </div>
                    <div class="col">
                        <div class="text-info fw-bold">{{ $row->total_verified }}</div>
                        <small class="text-muted">Verify</small>
                    </div>
                    <div class="col">
                        <div class="text-success fw-bold">{{ $row->total_approved }}</div>
                        <small class="text-muted">Approve</small>
                    </div>
                    <div class="col">
                        <div class="text-danger fw-bold">{{ $row->total_rejected }}</div>
                        <small class="text-muted">Reject</small>
                    </div>
                </div>

                {{-- Spacer --}}
                <div class="mt-auto">

                    {{-- progress approved --}}
                    <div class="mt-3">
                        <small class="text-muted">
                            Approved {{ $row->persen_approved ?? 0 }}%
                        </small>
                        <div class="progress" style="height:7px;">
                            <div class="progress-bar bg-success" style="width: {{ $row->persen_approved ?? 0 }}%">
                            </div>
                        </div>
                    </div>

                    {{-- status confirm --}}
                    <div class="mt-3 text-end">
                        @if($row->status_confirm == '100% Confirm')
                        <span class="badge bg-success">✔ Confirm</span>
                        @else
                        <span class="badge bg-warning">Belum Confirm</span>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>


    @empty
    <div class="col-12">
        <div class="alert alert-warning text-center shadow-sm py-4">

            <div class="mb-3">
                <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size:60px;"></i>
            </div>
            <i class="bx bx-info-circle text-danger fa-5x mb-3"></i>
            <h6 class="mb-1 fw-bold">Data Tidak Ditemukan</h6>
            <div>Belum ada data laporan pengawasan.</div>
        </div>
    </div>
    @endforelse

    @endif

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $pengawasanhistories->links('vendor.pagination.bootstrap-first-last') }}
    </div>
</div>

@endsection