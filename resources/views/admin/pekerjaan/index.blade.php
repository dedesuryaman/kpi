@extends('layouts.admin.app')
@push('title', 'Dashboard >> Pekerjaan')
@push('css')
<script src="https://code.highcharts.com/highcharts.js"></script>
@endpush
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
                <i class="bx bx-grid-alt bx-5x"></i>
            </div>
            <div
                class="page-header-title-bar w-100 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-md-0">
                    <h4 class="mb-0 text-secondary mx-3 mt-3 mt-md-0 font-size-18 fw-bold text-uppercase title-text">
                        Data Proyek Periode Aktif {{ session('tahun_aktif') ?? '' }}
                    </h4>
                </div>

                <div class="page-header-extra ms-md-auto text-md-end mt-sm-1 mt-md-0">

                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pekerjaan</a></li>
                        <li class="breadcrumb-item active">Listing</li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-12 mb-3">

        <div class="row">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <form method="GET" action="{{ route('proyek') }}" class="d-flex flex-wrap gap-2">
                    Pencarian :
                    <!-- Search -->
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nama proyek atau pekerjaan..." value="{{ request('search') }}">
                        <!-- Button Filter -->
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bx bx-search"></i> Filter
                        </button>

                        <!-- Reset -->
                        <a href="{{ route('proyek') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </a>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
<div class="row align-items-stretch">
    @forelse ($pekerjaans as $row)
    <?php 
       
       $mulai   = \Carbon\Carbon::parse($row->tanggal_mulai);
        $selesai = \Carbon\Carbon::parse($row->tanggal_selesai);
        $today   = \Carbon\Carbon::today();

        $totalHari = $mulai->diffInDays($selesai);
        $hariBerjalan = $mulai->diffInDays($today);

        $progressSeharusnya = 0;

        if ($totalHari > 0) {
            $progressSeharusnya = ($hariBerjalan / $totalHari) * 100;
        }

        $progressAktual = $row->progress; // dari laporan

        if ($today->gt($selesai) && $progressAktual < 100) { 
            $status='Terlambat' ; 
        } elseif ($progressAktual >= $progressSeharusnya) {
            $status = 'On Track';
        } else {
            $status = 'Deviasi / Perlu Perhatian';
        }
            

        if ($progressAktual == 100) {
            if ($today->lte($selesai)) {
                $status = 'Selesai Tepat Waktu';
            } else {
                $status = 'Selesai Terlambat';
            }
        }


    ?>
    <div class="col-xl-4 col-md-6 col-sm-12 d-flex">
        <div class="card mini-stats-wid shadow shadow-sm flex-fill position-relative card-hover"
            style="border:solid 1px #acb2bb;">
            <div class="card-body d-flex flex-column">

                {{-- Link menutupi seluruh card --}}
                <a href="{{ url('sub-kegiatan/pekerjaan/sub-pekerjaan/show?id=' . $row->id) }}"
                    class="stretched-link"></a>

                {{-- Judul --}}
                <div>
                    <h5 class="mb-1 text-primary">{{ $row->nm_pekerjaan ?? '' }}</h5>
                    <p class="text-muted mb-2">
                        <a href="{{ url('/sub-kegiatan/pekerjaan?id=' . $row->subKegiatan->id . '&urusan=' . 
                                                        $row->subKegiatan->kd_urusan . 
                                                        '&bidang=' . $row->subKegiatan->kd_bidang . 
                                                        '&unit=' . $row->subKegiatan->kd_unit . 
                                                        '&sub=' . $row->subKegiatan->kd_sub . 
                                                        '&=program=' . $row->subKegiatan->kd_program90 . 
                                                        '&id_prog=' . $row->subKegiatan->kd_kegiatan90 . 
                                                        '&kegiatan=' . $row->subKegiatan->kd_sub_kegiatan ) }}">{{
                            $row->subKegiatan->nm_sub_kegiatan ?? '' }} </a>
                    </p>
                </div>

                <div class="my-2"></div>

                {{-- Nilai Anggaran --}}
                <div class="row mb-1">
                    <div class="col-3 fw-bold">Pagu</div>
                    <div class="col-1">:</div>
                    <div class="col-8">Rp {{ number_format($row->pagu_anggaran,0,',','.') }}</div>
                </div>

                <div class="row mb-1">
                    <div class="col-3 fw-bold">Total</div>
                    <div class="col-1">:</div>
                    <div class="col-8">Rp {{ number_format($row->total_anggaran,0,',','.') }}</div>
                </div>

                <div class="row mb-1">
                    <div class="col-3 fw-bold">Realisasi</div>
                    <div class="col-1">:</div>
                    <div class="col-8">Rp {{ number_format($row->total_realisasi,0,',','.') }}</div>
                </div>

                {{-- Tanggal --}}
                <div class="row mb-1">
                    <div class="col-3 fw-bold">Mulai</div>
                    <div class="col-1">:</div>
                    <div class="col-8">
                        {{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M Y') }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-3 fw-bold">Selesai</div>
                    <div class="col-1">:</div>
                    <div class="col-8">
                        {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y') }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-3 fw-bold">Status</div>
                    <div class="col-1">:</div>
                    <div class="col-8">
                        {{ $status }}
                    </div>
                </div>

                {{-- Spacer --}}
                <div class="mt-auto">
                    <span class="badge 
                        @if(str_replace('_',' ', strtoupper($row->status_progress ?? '')) == 'DRAFT') bg-danger
                        @elseif(str_replace('_',' ', strtoupper($row->status_progress ?? '')) == 'ON PROGRESS') bg-warning
                        @else bg-primary
                        @endif">
                        {{ str_replace('_',' ', strtoupper($row->status_progress ?? '')) }}
                    </span>

                    <div class="progress mt-3" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $row->progress }}%">
                        </div>
                    </div>
                    <small class="text-muted">{{ $row->progress }}% selesai</small>
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
            <i class="bx bx-info-circle fa-5x mb-3 text-danger"></i>
            <h6 class="mb-1 fw-bold">Data Tidak Ditemukan</h6>
            <div>Belum ada data proyek atau pekerjaan.</div>
        </div>
    </div>


    @endforelse

    <div class="mt-3">
        {{ $pekerjaans->links('vendor.pagination.bootstrap-first-last') }}
    </div>
</div>


@endsection