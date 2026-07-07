@extends('layouts.admin.app')
@push('title','Laporan Anggran')
@push('styles')

@endpush
@section('content')
<!-- PAGE HEADER -->
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4>Laporan Anggaran (Keuangan)</h4>

    <div class="page-title-right">
        <div class="d-flex justify-content-end gap-2 mb-2">
            <a href="{{ route('laporan.anggaran.export', request()->query()) }}" class="btn btn-success btn-sm"><i
                    class="bx bx-file"></i> Export Excel</a>
            <a href="{{ route('laporan.anggaran.print', request()->query()) }}" class="btn btn-danger btn-sm"
                target="_blank"><i class="bx bx-printer"></i> Print PDF</a>
        </div>
    </div>
</div>

<!-- FILTER -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET">
            <div class="row">

                <div class="col-md-2">
                    <label>Tahun Anggaran</label>
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

                <div class="col-md-5">
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

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary me-2">
                        Filter
                    </button>

                </div>

            </div>
    </div>
</div>

<div class="card shadow shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped table-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th width="50">No</th>
                    <th>Bulan</th>
                    <th class="text-end">Realisasi Bulan Ini</th>
                    <th class="text-end">Realisasi Kumulatif</th>
                    <th width="120">Serapan (%)</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                @endphp

                @foreach($data['labels'] as $i => $bulan)

                <tr>
                    <td class="text-center">{{ $no++ }}</td>

                    <td>{{ $bulan }}</td>

                    <td class="text-end">
                        Rp {{ number_format($data['realisasi_bulanan'][$i] ?? 0,0,',','.') }}
                    </td>

                    <td class="text-end">
                        Rp {{ number_format($data['realisasi_kumulatif'][$i] ?? 0,0,',','.') }}
                    </td>

                    <td class="text-center">
                        {{ $data['persentase'][$i] ?? 0 }} %
                    </td>

                </tr>

                @endforeach
            </tbody>

            <tfoot class="fw-bold table-light">
                <tr>
                    <td colspan="2">TOTAL</td>

                    <td class="text-end">
                        Rp {{ number_format(array_sum($data['realisasi_bulanan']),0,',','.') }}
                    </td>

                    <td class="text-end">
                        Rp {{ number_format(end($data['realisasi_kumulatif']),0,',','.') }}
                    </td>

                    <td class="text-center">
                        {{ end($data['persentase']) }} %
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

const opdSelect = document.getElementById('opd_id');
const proyekSelect = document.getElementById('proyek_id');
const tahunInput = document.querySelector('input[name="tahun"]');

opdSelect.addEventListener('change', function() {

let opdId = this.value;
let tahun = tahunInput.value;

proyekSelect.innerHTML = '<option value="">Loading...</option>';

if(opdId) {

fetch(`/laporan/anggaran/get-proyek-by-opd/${opdId}?tahun=${tahun}`)
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