@extends('layouts.admin.app')
@push('title','Laporan Rekap Tahunan')
@push('styles')
<style>
    .table th {
        white-space: nowrap;
    }
</style>
@endpush

@section('content')

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4>Laporan Rekap Tahunan Pekerjaan</h4>

    <div class="page-title-right">
        <div class="d-flex justify-content-end gap-2 mb-2">
            <a href="{{ route('laporan.rekap-tahunan.export', request()->query()) }}" class="btn btn-success btn-sm">
                <i class="bx bx-file"></i> Export Excel
            </a>

            <a href="{{ route('laporan.rekap-tahunan.print', request()->query()) }}" class="btn btn-danger btn-sm"
                target="_blank">
                <i class="bx bx-printer"></i> Print PDF
            </a>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">

        {{-- FILTER --}}
        <form method="GET" class="row g-2 mb-3">

            <div class="col-md-2">
                <input type="number" name="tahun" value="{{ request('tahun') }}" class="form-control"
                    placeholder="Tahun">
            </div>

            <div class="col-md-3">
                <select name="status_progress" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="on_progress" {{ request('status_progress')=='on_progress' ?'selected':'' }}>On
                        Progress</option>
                    <option value="verifikasi" {{ request('status_progress')=='verifikasi' ?'selected':'' }}>Verifikasi
                    </option>
                    <option value="selesai" {{ request('status_progress')=='selesai' ?'selected':'' }}>Selesai</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    Filter
                </button>
            </div>

        </form>


        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Pekerjaan</th>
                        <th>Status</th>
                        <th>Progress (%)</th>
                        <th class="text-center">Sub Pekerjaan</th>
                        <th class="text-center">Pengawasan</th>
                        <th class="text-center">Foto</th>
                        <th class="text-center">Kendala</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($projects as $row)
                    <tr>
                        <td>{{ $projects->firstItem() + $loop->index }}</td>

                        <td>
                            <strong>{{ $row->nm_pekerjaan }}</strong>
                        </td>

                        <td>
                            @php
                            $warna = match($row->status_progress){
                            'on_progress' => 'primary',
                            'verifikasi' => 'warning',
                            'selesai' => 'success',
                            default => 'secondary'
                            };
                            @endphp

                            <span class="badge bg-{{ $warna }}">
                                {{ strtoupper(str_replace('_',' ',$row->status_progress)) }}
                            </span>
                        </td>
                        <td class="text-center">
                            {{ $row->progress }}
                        </td>
                        <td class="text-center">
                            {{ $row->total_sub_pekerjaan }}
                        </td>

                        <td class="text-center">
                            {{ $row->total_pengawasan }}
                        </td>

                        <td class="text-center">
                            {{ $row->total_foto }}
                        </td>

                        <td class="text-center">
                            @if($row->total_kendala > 0)
                            <span class="badge bg-danger">
                                {{ $row->total_kendala }}
                            </span>
                            @else
                            <span class="badge bg-success">0</span>
                            @endif
                        </td>

                    </tr>
                    @empty

                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Tidak ada data
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>


        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $projects->links() }}
        </div>

    </div>
</div>

@endsection