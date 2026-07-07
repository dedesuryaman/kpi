@extends('layouts.admin.app')
@push('title' , 'Data Kegiatan')

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
                        Data Sub Unit - Sub Kegiatan , Periode Aktif Tahun {{ session('tahun_aktif') ?? '' }}
                    </h4>
                </div>

                <div class="page-header-extra ms-md-auto text-md-end mt-sm-1 mt-md-0">

                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sub Unit Kegiatan</a></li>
                        <li class="breadcrumb-item active">Listing</li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-4">
        <form method="GET" action="{{ route('sub-kegiatan.sub_unit') }}">
            <div class="input-group">

                <input type="text" name="search" class="form-control" placeholder="Cari nama sub unit..."
                    value="{{ request('search') }}">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    <span class="d-none d-md-inline">Filter</span>
                </button>

                <a href="{{ route('sub-kegiatan.sub_unit') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
        </form>
    </div>
</div>


<div class="table-responsive mt-3">
    <table class="table table-hover table-sm align-middle mb-0">
        <thead class="table-dark text-uppercase small">
            <tr>
                <th class="text-center" width="60">No</th>
                <th>Kode</th>
                <th>Sub Unit</th>
                <th>Alias</th>
                <th class="text-center">Total Program</th>
                <th class="text-center">Total Sub Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sub_units as $unit)
            <tr>
                <td class="text-center">
                    {{ $sub_units->firstItem() + $loop->index }}
                </td>

                <td class="fw-semibold text-muted">
                    {{ $unit->kd_urusan . '.' . $unit->kd_bidang . '.' .
                    str_pad($unit->kd_unit, 2, '0', STR_PAD_LEFT) . '.' .
                    str_pad($unit->kd_sub, 2, '0', STR_PAD_LEFT) }}
                </td>

                <td>
                    <a href="{{ route('sub-kegiatan.sub-unit.detail', [
                                        'id' => $unit->id,
                                        'urusan' => $unit->kd_urusan,
                                        'bidang' => $unit->kd_bidang,
                                        'unit' => $unit->kd_unit,
                                        'sub' => $unit->kd_sub
                                    ]) }}" class="text-decoration-none fw-semibold text-primary">
                        {{ $unit->nm_sub_unit }}
                    </a>
                </td>

                <td>
                    <span class="text-muted">
                        {{ $unit->alias ?? '-' }}
                    </span>
                </td>

                <td class="text-center">
                    <span class="badge rounded-pill badge-soft-info text-primary px-3">
                        {{ number_format($unit->total_program) }}
                    </span>
                </td>

                <td class="text-center">
                    <span class="badge rounded-pill badge-soft-primary text-success px-3">
                        {{ number_format($unit->total_sub_kegiatan) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    Data Sub Unit belum tersedia.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($sub_units->hasPages())
<div class="mt-3">
    {{ $sub_units->links('vendor.pagination.bootstrap-first-last') }}
</div>
@endif


@endsection