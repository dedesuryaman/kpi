@extends('layouts.admin.app')
@push('title' , 'Laporan Progress')
@section('content')
<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="page-title-box d-flex justify-content-between align-items-center">
        <h4>Laporan Progress Proyek</h4>

        <div>
            <a href="{{ route('laporan.progress.proyek.print', request()->query()) }}" target="_blank"
                class="btn btn-danger me-2">
                <i class="bx bx-printer"></i> Print
            </a>

            <a href="{{ route('laporan.progress.proyek.export.excel', request()->query()) }}" class="btn btn-success">
                <i class="bx bx-file"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card">
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
                        <select name="status_progress" class="form-control">
                            <option value="">Semua</option>

                            <option value="on_progress" {{ request('status_progress')=='on_progress' ? 'selected' : ''
                                }}>
                                On Track
                            </option>

                            <option value="verifikasi" {{ request('status_progress')=='verifikasi' ? 'selected' : '' }}>
                                Verifikasi
                            </option>

                            <option value="selesai" {{ request('status_progress')=='selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="bx bx-search"></i> Tampilkan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- SUMMARY CARD -->
    <div class="row">
        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <h5>Total Proyek</h5>
                    <h3>{{ $total }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <h5>On Track</h5>
                            <h3 class="text-success">{{ $onTrack }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <h5>Verifikasi</h5>
                            <h3 class="text-danger">{{ $verifikasi }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <h5>Selesai</h5>
                            <h3 class="text-success">{{ $selesai }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <h5>Rata-rata Progress</h5>
                            <h3>{{ number_format($avgProgress,2) }}%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE DETAIL -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Detail Progress Proyek</h4>

            <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>OPD</th>
                            <th>Progress</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->nm_pekerjaan }}</td>
                            <td>{{ $project->subKegiatan->nm_unit ?? '-' }}</td>
                            <td>
                                <div class="progress" style="height:6px;">
                                    <div class="progress-bar bg-success" style="width: {{ $project->progress }}%">
                                    </div>
                                </div>
                                <small>{{ $project->progress }}%</small>
                            </td>
                            <td>
                                <span class="badge 
                                {{ $project->status_progress == 'draft' ? 'bg-secondary' : '' }}
                                {{ $project->status_progress == 'on_progress' ? 'bg-primary' : '' }}
                                {{ $project->status_progress == 'verifikasi' ? 'bg-warning text-dark' : '' }}
                                {{ $project->status_progress == 'selesai' ? 'bg-success' : '' }}">

                                    {{ ucfirst(str_replace('_',' ', $project->status_progress)) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $projects->appends(request()->query())->links() }}
            </div>

        </div>
    </div>

</div>
@endsection