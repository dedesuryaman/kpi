@extends('layouts.admin.app')
@push('title','Laporan Sub Pekerjaan')
@push('styles')

@endpush
@section('content')
<!-- PAGE HEADER -->
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4>Laporan Progress Sub-Proyek</h4>

    <div class="page-title-right">
        <div class="d-flex justify-content-end gap-2 mb-2">
            <a href="{{ route('laporan.terlambat.export', request()->query()) }}" class="btn btn-success btn-sm"><i
                    class="bx bx-file"></i> Export Excel</a>
            <a href="{{ route('laporan.terlambat.print', request()->query()) }}" class="btn btn-danger btn-sm"
                target="_blank"><i class="bx bx-printer"></i> Print PDF</a>
        </div>
    </div>
</div>

<div class="card shadow shadow-sm filter-card mb-3">
    <div class="card-body">
        <form method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label>Tahun Proyek</label>
                    <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                </div>
                <div class="col-md-3">
                    <label>OPD</label>
                    <select name="opd_id" id="opd_id" class="form-select">
                        <option value="">Semua OPD</option>
                        @foreach($opd as $o)
                        <option value="{{ $o->id_opd }}" {{ request('opd_id')==$o->id_opd ? 'selected':'' }}>
                            {{ $o->nm_sub_unit }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Proyek</label>
                    <select name="proyek_id" id="proyek_id" class="form-select">
                        <option value="">Semua Proyek</option>
                        @foreach($proyek as $p)
                        <option value="{{ $p->id }}" {{ request('proyek_id')==$p->id ? 'selected':'' }}>
                            {{ $p->nm_pekerjaan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small">Status Sub Proyek</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="proses_pengerjaan" {{ request('status')=='proses_pengerjaan' ? 'selected' :'' }}>
                            On Progress
                        </option>
                        <option value="menunggu_verifikasi" {{ request('status')=='menunggu_verifikasi' ? 'selected' :''
                            }}>
                            Verifikasi
                        </option>
                        <option value="selesai_pengerjaan" {{ request('status')=='selesai_pengerjaan' ? 'selected' :''
                            }}>Selesai</option>
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


<div class="card shadow shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-sm table-hover align-middle">
            <thead class="table-info">
                <tr>
                    <th>No</th>
                    <th colspan="2">Proyek</th>

                    <th>Anggaran</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Progress (%)</th>
                    <th>Proses</th>
                </tr>
            </thead>

            <tbody>
                @php
                $lastOpd = null;
                $opdIndex = 0;
                $pekerjaanIndex = 0;
                $lastPekerjaanKey = null;
                @endphp

                @forelse($data as $row)

                {{-- OPD Header --}}
                @if($lastOpd != $row->subKegiatan?->nm_sub_unit)
                @php
                $opdIndex++;
                $lastOpd = $row->subKegiatan?->nm_sub_unit;
                $pekerjaanIndex = 0;
                @endphp
                <tr class="table-secondary">
                    <td>{{ $opdIndex }}</td>
                    <td colspan="7"><strong>{{ $lastOpd }}</strong></td>
                </tr>
                @endif

                {{-- Pekerjaan Header --}}
                @php
                $pekerjaanId = $row->id;
                $pekerjaanKey = $opdIndex.'-'.$pekerjaanId;
                @endphp

                @if($lastPekerjaanKey != $pekerjaanKey)
                @php
                $pekerjaanIndex++;
                $lastPekerjaanKey = $pekerjaanKey;
                @endphp

                @php
                $isTerlambat = $row->tanggal_selesai
                ? \Carbon\Carbon::parse($row->tanggal_selesai)->lt(now())
                : false;
                @endphp

                <tr class="{{ $isTerlambat ? 'table-warning' : 'table-primary' }}">
                    <td></td>
                    <td colspan="2"><strong>{{ $row->nm_pekerjaan ?? '-' }}</strong></td>
                    <td class="text-end"><strong>{{ number_format($row->pagu_anggaran ?? 0) }}</strong></td>
                    <td><strong>{{ $row->tanggal_mulai
                            ? \Carbon\Carbon::parse($row->tanggal_mulai)->translatedFormat('d M Y')
                            : '-' }}</strong></td>
                    <td><strong>{{ $row->tanggal_mulai
                            ? \Carbon\Carbon::parse($row->tanggal_selesai)->translatedFormat('d M Y')
                            : '-' }}</strong></td>
                    <td class="text-center"><strong>{{ $row->progress ?? '0' }} %</td>
                    <td>
                        @php
                        $status = [
                        'on_progress' => '<span class="text-primary">ON PROGRESS</span>',
                        'draft' => '<span class="text-secondary">DRAFT</span>',
                        'verifikasi' => '<span class="text-warning">VERIFIKASI</span>',
                        'selesai' => '<span class="text-success">SELESAI DISETUJUI</span>'
                        ];
                        @endphp
                        <strong>
                            {!! $status[$row->status_progress] ?? '-' !!}
                        </strong>
                    </td>

                </tr>
                @endif

                @php
                $totalAnggaran = 0;
                $totalProgress = 0;
                $jumlahSub = $row->subPekerjaan->count();
                @endphp

                {{-- Sub Pekerjaan --}}
                <tr>
                    <td></td>
                    <td colspan="7"><strong>Sub Pekerjaan :</strong></td>
                </tr>
                @forelse($row->subPekerjaan as $sub)

                @php
                $totalAnggaran += $sub->anggaran ?? 0;
                $totalProgress += $sub->persentase_progress ?? 0;
                @endphp

                <tr>
                    <td></td>
                    <td></td>
                    <td>{{ $sub->judul ?? '-' }}</td>

                    <td class="text-end">{{ number_format($sub->anggaran ?? 0) }}</td>

                    <td>
                        {{ $sub->tanggal_mulai
                        ? \Carbon\Carbon::parse($sub->tanggal_mulai)->translatedFormat('d M Y')
                        : '-' }}
                    </td>

                    <td>
                        {{ $sub->tanggal_selesai
                        ? \Carbon\Carbon::parse($sub->tanggal_selesai)->translatedFormat('d M Y')
                        : '-' }}
                    </td>

                    <td class="text-center">{{ $sub->persentase_progress ?? 0 }}</td>

                    <td>
                        <span class="badge bg-{{
                        match($sub->status_progress){
                            'proses_pengerjaan' => 'info',
                            'verifikasi' => 'warning',
                            'selesai_disetujui' => 'success',
                            'selesai_pengerjaan' => 'primary',
                            default => 'secondary'
                        }
                    }}">
                            {{ strtoupper(str_replace('_', ' ', $row->status_progress ?? '-')) }}
                        </span>
                    </td>
                </tr>

                @empty
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="6" class="text-muted">Tidak ada sub pekerjaan</td>
                </tr>
                @endforelse


                {{-- TOTAL --}}
                @if($jumlahSub > 0)
                <tr class="table-light fw-bold">
                    <td></td>
                    <td></td>
                    <td class="text-end">TOTAL</td>

                    <td class="text-end">{{ number_format($totalAnggaran) }}</td>

                    <td colspan="2"></td>

                    <td class="text-center">
                        {{ number_format($totalProgress / $jumlahSub, 2) }} %
                    </td>

                    <td></td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse

            </tbody>
        </table>
        <div class="mt-3">
            {{ $data->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() 
    {

            const opdSelect = document.getElementById('opd_id');
            const proyekSelect = document.getElementById('proyek_id');
            const tahunInput = document.querySelector('input[name="tahun"]');

            opdSelect.addEventListener('change', function() {

            let opdId = this.value;
            let tahun = tahunInput.value;

            proyekSelect.innerHTML = '<option value="">Loading...</option>';

                if(opdId) {

                fetch(`/laporan/proyek-terlambat/get-proyek-by-opd/${opdId}?tahun=${tahun}`)
                    .then(res => res.json())
                    .then(data => {

                    let options = '<option value="">Semua Proyek</option>';

                    data.forEach(item => {
                    options += `<option value="${item.id}">${item.nm_pekerjaan}</option>`;
                });

                    proyekSelect.innerHTML = options;
                })
                .catch(err => {
                    console.error(err);
                    proyekSelect.innerHTML = '<option value="">Error loading</option>';
                });

            } else {

            proyekSelect.innerHTML = '<option value="">Semua Proyek</option>';

        }

    });

});
</script>
@endpush