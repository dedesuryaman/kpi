@extends('layouts.admin.app')
@push('title', 'Daftar Proyek')
@section('content')

<div class="container-fluid">

    <div class="page-title-box d-flex justify-content-between align-items-center">
        <h4>Daftar Proyek</h4>
        <div>
            <a href="{{ route('laporan.daftar.proyek.print', request()->query()) }}" class="btn btn-danger me-2"
                target="_blank">
                <i class="bx bx-printer"></i> Print
            </a>

            <a href="{{ route('laporan.daftar.proyek.export.excel' , request()->query() ) }}" class="btn btn-success">
                <i class="bx bx-file"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card shadow shadow-sm">
        <div class="card-body">
            <form method="GET">
                <div class="row">

                    <div class="col-md-2">
                        <label class="form-label small">Tahun</label>
                        <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">OPD</label>
                        <select name="opd_id" class="form-select">
                            <option value="">Semua OPD</option>
                            @foreach($opd as $o)
                            <option value="{{ $o->id_opd }}" {{ request('opd_id')==$o->id_opd ? 'selected':'' }}>
                                {{ $o->nm_sub_unit }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status_progress" class="form-select">
                            <option value="">Semua</option>
                            <option value="on_progress" {{ request('status_progress')=='on_progress' ? 'selected' : ''
                                }}>
                                On Progress
                            </option>
                            <option value="verifikasi" {{ request('status_progress')=='verifikasi' ? 'selected' : '' }}>
                                Verifikasi
                            </option>
                            <option value="selesai" {{ request('status_progress')=='selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="bx bx-search"></i> Filter
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>OPD</th>
                            <th>Nomor Kontrak</th>
                            <th>Tanggal Kontrak</th>
                            <th>Nilai Kontrak (Rp.)</th>

                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Kontraktor Pelakasana</th>
                            <th>Kontraktor Pengawas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $key => $project)
                        <tr>
                            <td>{{ $projects->firstItem() + $key }}</td>
                            <td>{{ $project->nm_pekerjaan }}</td>
                            <td>{{ $project->subKegiatan?->nm_unit ?? '-' }}</td>
                            <td>{{ $project->nomor_kontrak }}</td>
                            <td>{{ $project->tanggal_kontrak }}</td>
                            <td class="text-end">{{ number_format($project->pagu_anggaran,0,',','.') }}</td>
                            <td>
                                {{ $project->tanggal_mulai }}
                            </td>
                            <td>
                                {{ $project->tanggal_selesai }}
                            </td>
                            <td>{{ $project->konPelaksana?->name ?? '-' }}</td>

                            <td>{{ $project->konPengawas?->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $projects->withQueryString()->links() }}

        </div>
    </div>

</div>

@endsection