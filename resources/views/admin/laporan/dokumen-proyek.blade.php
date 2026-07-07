@extends('layouts.admin.app')
@push('title', 'Dashboard >> Pekerjaan')
@push('css')
<script src="https://code.highcharts.com/highcharts.js"></script>
@endpush
@push('styles')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data Laporan Dokumen Proyek</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pekerjaan</a></li>
                    <li class="breadcrumb-item active">Dokumen</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="card mt-2 p-2">

    <!-- Form Filter -->
    <form id="filterForm" class="row g-3 mb-4" method="get">
        <div class="col-md-1">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="tahun" class="form-control" name="tahun" id="tahun"
                value="{{ $tahun ?? session('tahun_aktif') }}">
        </div>
        <?php 
        /*
        <div class="col-md-1">
            <label for="bulan" class="form-label">Bulan</label>
            <select name="bulan" id="bulan" class="form-select">
                <option value="0" {{ $bulan==0 ? 'selected' : '' }}>--All--</option>
                <option value="1" {{ $bulan==1 ? 'selected' : '' }}>Januari</option>
                <option value="2" {{ $bulan==2 ? 'selected' : '' }}>Februari</option>
                <option value="3" {{ $bulan==3 ? 'selected' : '' }}>Maret</option>
                <option value="4" {{ $bulan==4 ? 'selected' : '' }}>April</option>
                <option value="5" {{ $bulan==5 ? 'selected' : '' }}>Mei</option>
                <option value="6" {{ $bulan==6 ? 'selected' : '' }}>Juni</option>
                <option value="7" {{ $bulan==7 ? 'selected' : '' }}>Juli</option>
                <option value="8" {{ $bulan==8 ? 'selected' : '' }}>Agustus</option>
                <option value="9" {{ $bulan==9 ? 'selected' : '' }}>September</option>
                <option value="10" {{ $bulan==10 ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ $bulan==11 ? 'selected' : '' }}>November</option>
                <option value="12" {{ $bulan==12 ? 'selected' : '' }}>Desember</option>
            </select>
        </div>
        */
        ?>
        <div class="col-md-4">
            <label for="opd" class="form-label">Sub Unit OPD</label>
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
            <label for="pekerjaan" class="form-label">Proyek</label>
            <select name="proyek_id" id="proyek_id" class="form-select">
                <option value="">Semua Proyek</option>
                @foreach($proyek as $p)
                <option value="{{ $p->id }}" {{ request('proyek_id')==$p->id ? 'selected':'' }}>
                    {{ $p->nm_pekerjaan }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary btn-sm">Tampilkan Laporan</button>
            <button type="reset" class="btn btn-secondary btn-sm ms-2">Reset</button>
        </div>
    </form>

    @php
    $icons = [
    'image' => 'fas fa-file-image text-success',
    'pdf' => 'fas fa-file-pdf text-danger',
    'word' => 'fas fa-file-word text-primary',
    'excel' => 'fas fa-file-excel text-success',
    'archive'=> 'fas fa-file-archive text-warning',
    'file' => 'fas fa-file text-secondary',
    ];

    function simpleType($mime){
    if(str_contains($mime,'image')) return 'image';
    if(str_contains($mime,'pdf')) return 'pdf';
    if(str_contains($mime,'word') || str_contains($mime,'doc')) return 'word';
    if(str_contains($mime,'excel') || str_contains($mime,'sheet') || str_contains($mime,'xls')) return 'excel';
    if(str_contains($mime,'zip') || str_contains($mime,'rar')) return 'archive';
    return 'file';
    }
    @endphp
    @if($rekap->isNotEmpty())

    <hr>
    <h5>Rekap Dokumen</h5>

    <table class="table table-sm table-bordered">
        <thead class="table-info">
            <tr>
                <th>Category</th>

                @foreach($mimes as $mime)
                @php
                $type = simpleType($mime);
                @endphp

                <th class="text-center">
                    <i class="{{ $icons[$type] }}"></i>
                </th>
                @endforeach

            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $row)
            <tr>
                <td>{{ $row->name }}</td>

                @foreach($mimes as $mime)
                @php
                $alias = str_replace(['/', '.', '-'], '_', $mime);
                @endphp
                <td class="text-center">{{ $row->$alias }}</td>
                @endforeach

            </tr>
            @endforeach
        </tbody>
    </table>

    @else

    <div class="alert alert-warning">
        Rekap dokumen tidak tersedia.
    </div>

    @endif

    @if($dokumens->isNotEmpty())
    <hr>
    <h5>Lisiting Dokumen</h5>
    <?php $n = 1 ;?>
    <table class="table table-sm ">
        <tbody>
            @forelse($dokumens as $doc)


            <tr>
                <td>{{ $dokumens->firstItem() + $loop->index }}</td>
                <td class="text-center">
                    <i class="{{ $doc->icon_class}} fa-2x"></i>
                </td>

                <td class="doc-title" title="{{ $doc->file_name ?? $doc->title }}">{{ $doc->title }}</td>
                <td>{{ $doc->description }}</td>
                <td>@php
                    $fileName = $doc->file_name ?? $doc->title;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                    if(strlen($fileName) > 100){
                    $fileName = substr($fileName, 0, 100) . '...' . strtoupper($ext);
                    }
                    @endphp
                    {{ $fileName }}</td>
                </td>
                <td>
                    {{ $doc->pekerjaan->nm_pekerjaan }}
                </td>
                <td>

                    {{ $doc->human_size }}

                </td>
                <td>

                    {{-- tombol actions --}}
                    <div class="mt-auto d-flex justify-content-end gap-1 doc-actions">
                        @if($doc->simple_type === 'image' || $doc->simple_type === 'pdf')
                        <button class="btn btn-sm btn-outline-primary preview-btn" data-type="{{ $doc->simple_type }}"
                            data-url="{{ $doc->file_url }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        @endif

                        <a class="btn btn-sm btn-outline-success" href="{{ $doc->file_url }}" download>
                            <i class="fas fa-download"></i>
                        </a>

                        <a class="btn btn-sm btn-outline-secondary" href="{{ $doc->file_url }}" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                        </a>

                    </div>

                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $dokumens->links('vendor.pagination.bootstrap-first-last') }}
    @else
    <div class="alert alert-info">Silahkan filter data!</div>
    @endif
</div>


{{-- Preview Modal --}}
<div class="modal fade" id="dokPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dokPreviewTitle">Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="dokPreviewBody" style="min-height:300px;"></div>
            <div class="modal-footer">
                <a id="dokPreviewDownload" class="btn btn-primary" href="#" download>
                    <i class="fas fa-download"></i> Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).off("click", ".preview-btn").on("click", ".preview-btn", function(e){

 
 
        const url = this.dataset.url;
        const type = this.dataset.type;
        const title = this.closest('.table').querySelector('.doc-title').textContent.trim();
        
        const modalEl = document.getElementById('dokPreviewModal');
        const body = modalEl.querySelector('#dokPreviewBody');
        const t = modalEl.querySelector('#dokPreviewTitle');
        const dwn = modalEl.querySelector('#dokPreviewDownload');
        
        t.textContent = title;
        dwn.href = url;
        
        if(type === 'image'){
        body.innerHTML = `<img src="${url}" alt="${title}" class="img-fluid" style="max-height:70vh;">`;
        } else if(type === 'pdf'){
        body.innerHTML = `<iframe src="${url}" frameborder="0" style="width:100%; height:70vh;"></iframe>`;
        } else {
        body.innerHTML = `<div class="p-4">Preview tidak tersedia. <a href="${url}" target="_blank">Buka di tab baru</a></div>`;
        }
        
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
 
       
      
    });
    
    
</script>
@endpush

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

                fetch(`/laporan/dokumen-proyek/get-proyek-by-opd/${opdId}?tahun=${tahun}`)
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