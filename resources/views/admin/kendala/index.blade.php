@extends('layouts.admin.app')
@push('title', 'Data Laporan Kendala')

@push('styles')
<style>
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
                <i class="bx bx-image bx-5x"></i>
            </div>
            <div
                class="page-header-title-bar w-100 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-md-0">
                    <h4 class="mb-0 text-secondary mx-3 mt-3 mt-md-0 font-size-18 fw-bold text-uppercase title-text">
                        Data Laporan Kendala Proyek , Periode Aktif Tahun {{ session('tahun_aktif') ?? '' }}
                    </h4>
                </div>

                <div class="page-header-extra ms-md-auto text-md-end mt-sm-1 mt-md-0">

                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Kendala</a></li>
                        <li class="breadcrumb-item active">Listing</li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>

@if($kendalas->isEmpty())
<div class="col-12">
    <div class="alert alert-warning text-center shadow-sm py-4">

        <div class="mb-3">
            <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size:60px;"></i>
        </div>
        <i class="bx bx-info-circle text-danger fa-5x mb-3"></i>
        <h6 class="mb-1 fw-bold">Data Tidak Ditemukan</h6>
        <div>Belum ada data laporan kendala.</div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="60">No</th>
                            <th class="text-start">Proyek</th>
                            <th width="180">Total Kendala</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kendalas as $row)
                        <tr>
                            <td class="text-center">
                                {{ $kendalas->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $row->nm_pekerjaan ?? '-' }}
                                </div>
                            </td>

                            <td class="text-center">
                                @if($row->total_kendala > 0)
                                <span class="badge rounded-pill badge-soft-danger text-danger px-3 py-2">
                                    {{ $row->total_kendala }} Kendala
                                </span>
                                @else
                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    Tidak Ada Kendala
                                </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ url('kendala/detail?id=' . $row->id ) }}"
                                    class="btn btn-sm btn-outline-primary px-3">
                                    <i class="fa fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="alert alert-warning text-center shadow-sm">

                                    <div class="mb-3">
                                        <i class="bi bi-exclamation-triangle-fill text-warning"
                                            style="font-size:60px;"></i>
                                    </div>
                                    <i class="bx bx-info-circle text-danger fa-5x mb-3"></i>
                                    <h6 class="mb-1 fw-bold">Data Tidak Ditemukan</h6>
                                    <div>Belum ada data laporan pengawasan.</div>
                                </div>

                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- PAGINATION --}}
                <div class="mt-4">
                    {{ $kendalas->links('vendor.pagination.bootstrap-first-last') }}
                </div>

            </div>
        </div>
    </div>
</div>

@endif

@endsection