@extends('layouts.admin.app')
@push('title', 'Dokumentasi Proyek')
@push('styles')
<style>
    .card-hover {
        transition: all .25s;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush
@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Laporan Pengawasan (Dokumentasi)</h4>

                <div class="page-title-right">

                </div>

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

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary me-2">
                            Filter
                        </button>
                        <a href="{{ route('laporan.dokumentasi.preview', request()->query()) }}" target="_blank"
                            class="btn btn-dark me-2">
                            <i class="bx bx-show"></i> Preview
                        </a>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">

                        <a href="{{ route('laporan.dokumentasi.download.foto', request()->all()) }}"
                            class="btn btn-success {{ $data->isEmpty() ? 'disabled' : '' }}" {{ $data->isEmpty() ?
                            'onclick=return false;' : ''
                            }}>
                            Download Semua Foto
                        </a>

                        <!--a href="{{ route('laporan.dokumentasi.album', request()->all()) }}" target="_blank"
                            class="btn btn-danger me-2">
                            Print
                        </a>

                        <a href="{{ route('laporan.dokumentasi.export', request()->all()) }}" class="btn btn-success">
                            Excel
                        </a-->
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card shadow shadow-sm text-info">
                <div class="card-body">
                    Total Dokumentasi
                    <h3>{{ $totalFoto }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow shadow-sm text-primary">
                <div class="card-body">
                    Total Proyek
                    <h3>{{ $totalProyek }}</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- GALLERY -->
    <div class="row">

        @foreach($data as $row)

        @php
        $photo = ($row->foto_path && Storage::disk('public')->exists($row->foto_path))
        ? asset('storage/'.$row->foto_path)
        : asset('assets/images/no-image.png');
        @endphp

        <div class="col-md-6 col-xl-4 d-flex mb-4">

            <div class="card flex-fill position-relative card-hover shadow-sm border border-info">

                <!-- IMAGE -->
                <a href="javascript:void(0)" class="btn-show-photo" data-bs-toggle="modal" data-bs-target="#photoModal"
                    data-photo="{{ $photo }}" title="Lihat Foto">

                    <img src="{{ $photo }}" class="card-img-top" style="height:300px; object-fit:cover;">
                </a>

                <div class="card-body d-flex flex-column">

                    <!-- HEADER -->
                    <div class="mb-2">
                        <small class="text-muted">
                            {{ optional($row->waktu_pengawasan)->format('d M Y H:i') }}
                        </small><br>

                        <b>
                            {{ $row->pekerjaan->nm_pekerjaan ?? '-' }}
                        </b>
                    </div>

                    <hr class="my-2">

                    <!-- INFO -->
                    <p class="mb-1">
                        <b>Alamat:</b><br>
                        {{ $row->alamat ?? '-' }}
                    </p>

                    <p class="mb-1">
                        <b>Catatan:</b><br>
                        {{ $row->catatan ?? '-' }}
                    </p>

                    <small class="text-muted">
                        Lat: {{ $row->lat ?? '-' }} |
                        Lng: {{ $row->lng ?? '-' }}
                    </small>

                    <!-- FOOTER -->
                    <div class="mt-auto pt-3">

                        <span class="badge 
                        @if($row->status == 'selesai') bg-success
                        @elseif($row->status == 'progress') bg-primary
                        @elseif($row->status == 'pending') bg-warning
                        @else bg-secondary
                        @endif
                    ">
                            {{ ucfirst($row->status ?? 'unknown') }}
                        </span>

                        <div class="float-end">

                            <span class="small">{{ $row->created_at }}</span>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        @endforeach

    </div>
    <hr>
    <div class="mt-3">
        {{ $data->appends(request()->query())->links() }}
    </div>
</div>

<div class="modal fade" id="photoModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    $(document).on('click','.btn-show-photo',function(){
        let photo = $(this).data('photo');
        $('#modalPhoto').attr('src',photo);
    });
</script>

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

fetch(`/laporan/dokumentasi/get-proyek-by-opd/${opdId}?tahun=${tahun}`)
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