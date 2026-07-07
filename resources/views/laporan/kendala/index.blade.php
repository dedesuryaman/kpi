@extends('layouts.admin.app')

@push('title', 'Laporan Kendala')
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
            <h4 class="mb-sm-0 font-size-18">Laporan Kendala</h4>

            <div class="page-title-right">
                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('laporan.kendala.export', request()->query()) }}" class="btn btn-success btn-sm">
                        <i class="bx bx-file"></i> Export Excel
                    </a>

                    <a href="{{ route('laporan.kendala.print', request()->query()) }}" class="btn btn-danger btn-sm"
                        target="_blank">
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
                    <label class="form-label small">Jenis Kendala</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="teknis" {{ request('status')=='teknis' ?'selected':'' }}>Masalah Teknis</option>
                        <option value="administrasi" {{ request('status')=='administrasi' ?'selected':'' }}>Administrasi
                        </option>
                        <option value="anggaran" {{ request('status')=='anggaran' ?'selected':'' }}>Anggaran</option>
                        <option value="koordinasi" {{ request('status')=='koordinasi' ?'selected':'' }}>Koordinasi
                        </option>
                        <option value="lingkungan" {{ request('status')=='lingkungan' ?'selected':'' }}>Lingkuntan
                            Sosial</option>
                        <option value="alam" {{ request('status')=='alam' ?'selected':'' }}>Kondisi Alam</option>
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
        <h6 class="mb-0 fw-semibold">Laporan Kendala Lapangan</h6>
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
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm bg-danger-subtle">
                        <div class="card-body">
                            <div class="text-muted">Kendala Teknis</div>
                            <h4 class="mb-0 fw-bold text-info">{{ $summary['teknis'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm bg-danger-subtle">
                        <div class="card-body">
                            <div class="text-muted">Kendala Administrasi</div>
                            <h4 class="mb-0 fw-bold text-info">{{ $summary['administrasi'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm bg-danger-subtle">
                        <div class="card-body">
                            <div class="text-muted">Kendala Anggaran</div>
                            <h4 class="mb-0 fw-bold text-info">{{ $summary['anggaran'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm bg-danger-subtle">
                        <div class="card-body">
                            <div class="text-muted">Kendala Koordinasi</div>
                            <h4 class="mb-0 fw-bold text-info">{{ $summary['koordinasi'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card border-0 shadow-sm bg-warning-subtle">
                        <div class="card-body">
                            <div class="text-muted">Lingkungan/Sosial</div>
                            <h4 class="mb-0 fw-bold text-info">{{ $summary['lingkungan'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card border-0 shadow-sm bg-success-subtle">
                        <div class="card-body">
                            <div class="text-muted">Kendala Kondisi Alam</div>
                            <h4 class="mb-0 fw-bold text-info">{{ $summary['alam'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-sm table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal</th>
                    <th>Pekerjaan</th>
                    <th>Permaslahan</th>
                    <th>Catatan</th>
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
                            <span class="fw-semibold">OPD:</span>
                            {{ $row->pekerjaan?->subKegiatan?->nm_unit ?? '-' }}
                        </div>
                        <div class="small text-muted mb-1">
                            <span class="fw-semibold">Kegiatan:</span>
                            {{ $row->pekerjaan?->subKegiatan?->nm_kegiatan ?? '-' }}
                        </div>

                        <div class="small text-muted mb-1">
                            <span class="fw-semibold">Sub Kegiatan:</span>
                            {{ $row->pekerjaan?->subKegiatan?->nm_sub_kegiatan ?? '-' }}
                        </div>



                    </td>
                    <td>

                        <div>

                            {{ $row->judul ?? '-' }}
                        </div>



                    </td>
                    <td>
                        @if($row->deskripsi)

                        {{ Str::limit($row->deskripsi, 120) }}

                        @endif
                    </td>
                    <td>
                        @php
                        $badge = match($row->tipe_masalah){
                        'teknis' => 'danger',
                        'anggaran' => 'warning',
                        'lingkungan' => 'primary',
                        default => 'secondary'
                        };
                        @endphp

                        <span class="badge bg-{{ $badge }} badge-status">
                            {{ strtoupper(str_replace('_',' ',$row->tipe_masalah)) }}
                        </span>
                    </td>

                    <td>{{ $row->pengawas?->name ?? '-' }}</td>

                    <td class="text-center">
                        @if($row->file_path && Storage::disk('public')->exists($row->file_path))
                        <img src="{{ asset('storage/'.$row->file_path) }}" class="thumb-img preview-image"
                            data-img="{{ asset('storage/'.$row->file_path) }}" style="cursor:pointer;">
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