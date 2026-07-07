@extends('layouts.admin.app')
@push('title' , 'Tambah Proyek Baru')
@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Tambah Proyek</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('proyek.index') }}">Proyek</a></li>
                    <li class="breadcrumb-item active">Tambah Proyek</li>
                </ol>
            </div>

        </div>
    </div>
</div>
@if(session('error'))
<div class="alert alert-warning">
    {{ session('error') }}
</div>
@endif

<form id="myForm" method="POST" action="{{ route('proyek.store') }}">
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Pilih Kegiatan</h5>
                    <select class="form-control" name="kegiatan_id">
                        <option value=""></option>
                        @foreach($sub_kegiatans as $row)
                        <option value="{{ $row->id }}">{{ $row->nm_sub_kegiatan }}</option>
                        @endforeach
                    </select>

                    <h5 class="card-title">Nama Proyek</h5>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                    <h5 class="card-title mt-2">Deskripsi</h5>
                    <textarea name="deskripsi" rows="4" class="form-control mt-1">{{ old('deskripsi') }}</textarea>
                    <h5 class="card-title mt-2">Pagu Anggaran</h5>
                    <i>(Estimasi nilai kontrak)</i>
                    <input type="number" name="pagu_anggaran" class="form-control" value="{{ old('pagu_anggaran') }}">
                    <h5 class="card-title mt-2">Lokasi</h5>
                    <input type="text" name="lokasi" class="form-control mt-1" value="{{ old('lokasi') }}">
                    <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal"
                        data-bs-target="#mapModal">
                        Pilih Lokasi
                    </button>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label class="card-title mt-2">Latitude</label>
                            <input type="text" id="latitude" class="form-control" name="latitude"
                                value="{{ old('latitude') }}" readonly>

                        </div>
                        <div class="col-6">
                            <label class="card-title mt-2">Longitude</label>
                            <input type="text" id="longitude" class="form-control" name="longitude"
                                value="{{ old('longitude') }}" readonly>
                        </div>
                    </div>
                    <h5 class="card-title mt-2">Radius</h5>
                    <input type="number" name="radius" class="form-control" value="{{ old('radius', 100) }}">


                </div>
                <div class="col-md-6">
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Instansi Penanggung Jawab</label>
                        </div>
                        <div class="col-8">

                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Kontraktor Pelaksana</label>
                        </div>
                        <div class="col-8">
                            <div class="input-group">
                                <input type="text" id="organization_name" class="form-control" readonly
                                    placeholder="Pilih Kontraktor">
                                <input type="hidden" name="kontraktor_id" id="organization_id">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalOrganization">
                                    Pilih
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Kontraktor Pengawas</label>
                        </div>
                        <div class="col-8">

                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Kode/Nomor Proyek</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="kode_proyek">
                        </div>
                    </div>
                    <h5>Estimasi Waktu Pelaksanaan</h5>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Estimasi</label>
                        </div>
                        <div class="col-8">
                            <input type="number" class="form-control" name="estimasi_waktu">
                            <i>(Hari kalender)</i>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Tanggal/Bulan Mulai</label>
                        </div>
                        <div class="col-8">
                            <input type="date" class="form-control" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Tanggal/Bulan Target Selesai</label>
                        </div>
                        <div class="col-8">
                            <input type="date" class="form-control" name="tanggal_selesai"
                                value="{{ old('tanggal_selesai') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-8">

                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
<!-- MODAL -->
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Pilih Lokasi di Peta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="map" style="height:400px;width:100%;"></div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Selesai</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalOrganization" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Pilih Kontraktor/Konsultan Pengawas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- SEARCH -->
                <input type="text" id="searchOrg" class="form-control mb-3" placeholder="Cari kontraktor...">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Organization</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody id="org-table-body">
                            <!-- Data via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div id="paginationArea" class="mt-2"></div>
            </div>

        </div>
    </div>
</div>

@endsection
@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

@push('scripts')

<script>
    let currentPage = 1;

function loadOrganizations(page = 1, search = '') {
    $.ajax({
        url: "{{ route('ajax.organizations') }}",
        data: {
            page: page,
            search: search
        },
        success: function(response) {

            let rows = '';

            if (response.data.length === 0) {
                rows = `<tr><td colspan="2" class="text-center">Data tidak ditemukan</td></tr>`;
            } else {
                response.data.forEach(org => {
                    rows += `
                        <tr>
                            <td>${org.name}</td>
                            <td>
                                <button class="btn btn-success btn-sm pilih-org"
                                    data-id="${org.id}"
                                    data-name="${org.name}">Pilih</button>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#org-table-body').html(rows);
            renderPagination(response);
        }
    });
}

function renderPagination(data) {
    let pagination = '';

    if (data.last_page > 1) {
        pagination += '<ul class="pagination justify-content-center">';

        for (let i = 1; i <= data.last_page; i++) {
            pagination += `
                <li class="page-item ${i === data.current_page ? 'active' : ''}">
                    <a href="#" class="page-link" onclick="changePage(${i})">${i}</a>
                </li>
            `;
        }

        pagination += '</ul>';
    }

    $('#paginationArea').html(pagination);
}

function changePage(page) {
    currentPage = page;
    loadOrganizations(page, $('#searchOrg').val());
}

// Trigger saat modal dibuka
$('#modalOrganization').on('shown.bs.modal', function () {
    loadOrganizations();
});

// Search realtime
$('#searchOrg').on('keyup', function() {
    loadOrganizations(1, $(this).val());
});
</script>

<script>
    $(document).on('click', '.pilih-org', function() {
    let id = $(this).data('id');
    let name = $(this).data('name');

    $('#organization_id').val(id); // hidden input
    $('#organization_name').val(name); // input visible

    $('#modalOrganization').modal('hide');
});

</script>

<script>
    let map, marker;

    // Ambil data dari Laravel
    const projectLat = {{ old('latitude' , -6.84) }};
    const projectLng = {{ old('longitude' , 107.59) }};

    document.getElementById('mapModal').addEventListener('shown.bs.modal', function () {

        if (!map) {

            // Default lokasi jika belum ada data
            let defaultLat = -6.84;
            let defaultLng = 107.59;

            // Gunakan lokasi project jika ada
            let centerLat = projectLat !== null ? projectLat : defaultLat;
            let centerLng = projectLng !== null ? projectLng : defaultLng;

            map = L.map('map', {
            attributionControl: false }).setView([centerLat, centerLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap',
                
                maxZoom: 19
            }).addTo(map);

            // ✅ Jika data project sudah ada → tampilkan marker
            if (projectLat !== null && projectLng !== null) {
                marker = L.marker([projectLat, projectLng]).addTo(map)
                    .bindPopup("Lokasi Project<br>Lat: " + projectLat + "<br>Lng: " + projectLng)
                    .openPopup();

                // isi input form juga
                document.getElementById('latitude').value = projectLat;
                document.getElementById('longitude').value = projectLng;
            }

            // ✅ Klik peta untuk update koordinat
            map.on('click', function(e) {
                let lat = e.latlng.lat;
                let lng = e.latlng.lng;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup("Lat: " + lat + "<br>Lng: " + lng)
                    .openPopup();
            });
        }

        // Fix map blank di modal
        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    });
</script>
@endpush

@push('scripts')
<script>
    const form = document.getElementById('myForm');

// ❌ Disable ENTER submit
form.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        return false;
    }
});

// ✅ Intercept submit
form.addEventListener('submit', function(e) {
    e.preventDefault(); // stop default

    // HTML5 Validation check first
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    Swal.fire({
        title: 'Yakin simpan data?',
        text: 'Pastikan data sudah benar!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // ✅ submit setelah confirm
        }
    });
});
</script>
@endpush