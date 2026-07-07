@extends('layouts.admin.app')

@push('title', 'Laporan Pengawasan')
@push('styles')
<style>
    .filter-card {
        border: 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .04);
    }

    .table thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .badge-status {
        padding: 6px 10px;
        font-size: 11px;
        border-radius: 20px;
    }

    .thumb-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eee;
        transition: .2s;
    }

    .thumb-img:hover {
        transform: scale(1.05);
    }

    .empty-state {
        padding: 40px 0;
        opacity: .6;
    }
</style>
@endpush
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Laporan Pengawasan</h4>

            <div class="page-title-right">
                <div class="d-flex justify-content-end gap-2 mb-2">

                    <a href="{{ route('laporan.pengawasan.export-data', request()->query()) }}"
                        class="btn btn-success btn-sm">
                        <i class="bx bx-file"></i> Export Excel
                    </a>

                    <a href="{{ route('laporan.pengawasan.print-data', request()->query()) }}"
                        class="btn btn-danger btn-sm" target="_blank">
                        <i class="bx bx-printer"></i> Print PDF
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
<div class="card filter-card mb-4">
    <div class="card-body">
        <form method="GET">
            <div class="row g-3 align-items-end">

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
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="deviasi" {{ request('status')=='deviasi' ?'selected':'' }}>Deviasi</option>
                        <option value="kritikal" {{ request('status')=='kritikal' ?'selected':'' }}>Kritikal</option>
                        <option value="normal" {{ request('status')=='normal' ?'selected':'' }}>Normal</option>
                        <option value="selesai" {{ request('status')=='selesai' ?'selected':'' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> Tampilkan Data
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h6 class="mb-0 fw-semibold">Laporan Pengawasan Lapangan</h6>
    </div>
    <div class="row g-3 mx-3 my-2">

        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Total Laporan</div>
                    <h4 class="mb-0 fw-bold">{{ $summary['total'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="row">

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-danger-subtle">
                        <div class="card-body">
                            <div class="text-muted">Normal</div>
                            <h4 class="mb-0 fw-bold text-primary">{{ $summary['normal'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-danger-subtle">
                        <div class="card-body">
                            <div class="text-muted">Kritikal</div>
                            <h4 class="mb-0 fw-bold text-danger">{{ $summary['kritikal'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-warning-subtle">
                        <div class="card-body">
                            <div class="text-muted">Deviasi</div>
                            <h4 class="mb-0 fw-bold text-warning">{{ $summary['deviasi'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-success-subtle">
                        <div class="card-body">
                            <div class="text-muted">Selesai</div>
                            <h4 class="mb-0 fw-bold text-success">{{ $summary['selesai'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-sm table-hover align-middle">
            <thead class="table-info">
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal</th>
                    <th>Pekerjaan</th>
                    <th class="text-center">Progress</th>
                    <th>Status</th>
                    <th>Petugas</th>
                    <th width="90">Foto</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $row)
                <tr>
                    <td>{{ $data->firstItem() + $loop->index }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($row->waktu_pengawasan)->translatedFormat('d M Y') }}
                    </td>

                    <td style="min-width:320px">

                        <div class="fw-semibold text-dark mb-2">
                            {{ $row->pekerjaan->nm_pekerjaan ?? '-' }}
                        </div>

                        <div class="small text-muted mb-1">
                            <span class="fw-semibold">Kegiatan:</span>
                            {{ $row->pekerjaan?->subKegiatan?->nm_kegiatan ?? '-' }}
                        </div>

                        <div class="small text-muted mb-1">
                            <span class="fw-semibold">Sub Kegiatan:</span>
                            {{ $row->pekerjaan?->subKegiatan?->nm_sub_kegiatan ?? '-' }}
                        </div>

                        <div class="small text-muted mb-1">
                            <span class="fw-semibold">Lokasi:</span>
                            {{ $row->alamat ?? '-' }}
                        </div>

                        @if($row->catatan)
                        <div class="small text-muted mt-2">
                            <span class="fw-semibold">Catatan:</span><br>
                            <span class="text-dark">
                                {{ Str::limit($row->catatan, 120) }}
                            </span>
                        </div>
                        @endif

                    </td>
                    <td class="text-center">{{ $row->progres_persentase ?? 0 }} %</td>
                    <td>
                        @php
                        $badge = match($row->status ?? 'normal'){
                        'kritikal' => 'danger',
                        'deviasi' => 'warning',
                        'selesai' => 'success',
                        default => 'secondary'
                        };
                        @endphp

                        <span class="badge bg-{{ $badge }} badge-status">
                            {{ strtoupper(str_replace('_',' ',( $row->status ?? 'normal'))) }}
                        </span>
                    </td>

                    <td>{{ $row->pengawas?->name ?? '-' }}</td>

                    <td class="text-center">
                        @if($row->foto_path && Storage::disk('public')->exists($row->foto_path))
                        <img src="{{ asset('storage/'.$row->foto_path) }}" class="thumb-img preview-image"
                            data-img="{{ asset('storage/'.$row->foto_path) }}" style="cursor:pointer;">
                        @else
                        -
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="text-center empty-state">
                            <i class="bx bx-folder-open font-size-24 mb-2"></i>
                            <div>Tidak ada data pengawasan</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $data->appends(request()->query())->links() }}
        </div>

    </div>
</div>

<!-- Modal Preview Foto -->
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Preview Foto Pengawasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid rounded">
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.preview-image').forEach(img => {
        img.addEventListener('click', function () {

            let imageUrl = this.getAttribute('data-img');
            document.getElementById('modalImage').src = imageUrl;

            let modal = new bootstrap.Modal(document.getElementById('fotoModal'));
            modal.show();
        });
    });

});
</script>
@endpush