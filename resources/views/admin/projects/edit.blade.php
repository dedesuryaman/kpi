@extends('layouts.admin.app')
@push('title' , 'Detail Proyek')
@push('css')


    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet.draw CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>


@endpush
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Update Proyek</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('proyek.index') }}">Proyek</a></li>
                    <li class="breadcrumb-item active">Update Proyek</li>
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
<form id="myForm" method="POST" action="{{ route('proyek.update' , $project->id) }}">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">

                    <h5 class="card-title">Nama Proyek</h5>
                    <input type="text" class="form-control" name="name" value="{{ $project->name }}">

                    <h5 class="card-title mt-2">Deskripsi</h5>
                    <textarea name="deskripsi" rows="4" name="deskripsi"
                        class="form-control mt-1">{{ $project->deskripsi }}</textarea>
                    <h5 class="card-title mt-2">Pagu Anggaran</h5>
                    <input type="text" name="pagu_anggaran" class="form-control" value="{{ $project->pagu_anggaran }}">
                    <h5 class="card-title mt-2">Lokasi</h5>
                    <input type="text" name="lokasi" class="form-control mt-1" value="{{ $project->lokasi }}">
                    <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal"
                        data-bs-target="#mapModal">
                        Pilih Lokasi
                    </button>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label class="card-title mt-2">Latitude</label>
                            <input type="text" id="latitude" class="form-control" name="latitude"
                                value="{{ $project->latitude ?? '' }}" readonly>

                        </div>
                        <div class="col-6">
                            <label class="card-title mt-2">Longitude</label>
                            <input type="text" id="longitude" class="form-control" name="longitude"
                                value="{{ $project->longitude ?? '' }}" readonly>
                        </div>
                    </div>


                    <input type="hidden" name="area" id="area">

                </div>

                <div class="col-xl-4">

                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Kontraktor</label>
                        </div>
                        <div class="col-8">
                            <label>{{ $kontraktor_proyek->name ?? '-' }}</label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Kode Proyek</label>
                        </div>
                        <div class="col-8">
                            <label>{{ $project->kode_proyek }}</label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-xl-4">
                            <label>Tanggal Mulai</label>
                        </div>
                        <div class="col-xl-8">
                            <input type="date" class="form-control" name="tanggal_mulai"
                                value="{{ $project->tanggal_mulai }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-xl-4">
                            <label>Target Selesai</label>
                        </div>
                        <div class="col-xl-8">
                            <input type="date" class="form-control" name="tanggal_selesai"
                                value="{{ $project->tanggal_selesai }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-xl-4">
                            <label>Status Proyek</label>
                        </div>
                        <div class="col-xl-8">
                            <select class="form-control select2" name="status_id">
                                @foreach($project_status as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">

                        </div>
                        <div class="col-xl-8">
                            <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save"></i>
                                Update</button>
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



@endsection
 
@push('js')

<!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet.draw -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <!-- Turf.js -->
    <script src="https://unpkg.com/@turf/turf@6.5.0/turf.min.js"></script>

@endpush

@push('scriptsx')

<script>
    let map, marker;

    // Ambil data dari Laravel
    const projectLat = {{ $project->latitude ?? 'null' }};
    const projectLng = {{ $project->longitude ?? 'null' }};

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
                
                maxZoom: 13
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
@push('scriptsxx')
<script>
    let map, marker, drawnItems;

const projectLat = {{ $project->latitude ?? 'null' }};
const projectLng = {{ $project->longitude ?? 'null' }};

document.getElementById('mapModal').addEventListener('shown.bs.modal', function () {

    if (!map) {

        let defaultLat = -6.8480;
        let defaultLng = 107.4736;

        let centerLat = projectLat !== null ? projectLat : defaultLat;
        let centerLng = projectLng !== null ? projectLng : defaultLng;

        map = L.map('map', { attributionControl: false }).setView([centerLat, centerLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
            maxZoom: 19
        }).addTo(map);

        // =====================
        // MARKER
        // =====================
        if (projectLat !== null && projectLng !== null) {
            marker = L.marker([projectLat, projectLng], { draggable: true }).addTo(map)
                .bindPopup("Lokasi Project<br>Lat: " + projectLat + "<br>Lng: " + projectLng)
                .openPopup();

            document.getElementById('latitude').value = projectLat;
            document.getElementById('longitude').value = projectLng;
        }

        map.on('click', function(e) {
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) map.removeLayer(marker);

           marker = L.marker([lat, lng], { draggable: true }).addTo(map);
		 
					
        });

        // =====================
        // POLYGON AREA
        // =====================
        drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        let drawControl = new L.Control.Draw({
            draw: {
                polygon: true,
                polyline: false,
                circle: false,
                rectangle: false,
                marker: false
            },
            edit: {
                featureGroup: drawnItems
            }
        });
        map.addControl(drawControl);

        // Simpan polygon baru
        map.on(L.Draw.Event.CREATED, function (event) {
            drawnItems.clearLayers();
            let layer = event.layer;
            drawnItems.addLayer(layer);

            let geojson = layer.toGeoJSON();
            document.getElementById('area').value = JSON.stringify(geojson.geometry);
        });

        // =====================
        // LOAD POLYGON DARI DATABASE
        // =====================
        @if($project->area)
        let area = {
            type: "Feature",
            geometry: {!! $project->area !!},
            properties: {}
        };

        let polygonLayer = L.geoJSON(area, {
            style: {
                color: 'red',
                fillColor: 'orange',
                fillOpacity: 0.4
            }
        }).addTo(map);

        polygonLayer.eachLayer(function(layer){
            drawnItems.addLayer(layer);
        });
        @endif
    }

    setTimeout(() => {
        map.invalidateSize();
    }, 300);
});
</script>
@endpush

@push('scripts')
<script>
    let map, marker, drawnItems;

const projectLat = {{ $project->latitude ?? 'null' }};
const projectLng = {{ $project->longitude ?? 'null' }};
const projectPolygon = {!! $project->area ?? 'null' !!};

document.getElementById('mapModal').addEventListener('shown.bs.modal', function () {

    if (!map) {

        let defaultLat = -6.84;
        let defaultLng = 107.59;

        let centerLat = projectLat !== null ? projectLat : defaultLat;
        let centerLng = projectLng !== null ? projectLng : defaultLng;

        map = L.map('map', { attributionControl: false })
                .setView([centerLat, centerLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 16
        }).addTo(map);

        // ================= LAYER POLYGON =================
        drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        // Jika polygon sudah ada dari database
        if (projectPolygon) {
            const polyLayer = L.geoJSON(projectPolygon);
            polyLayer.eachLayer(layer => drawnItems.addLayer(layer));
            map.fitBounds(polyLayer.getBounds());
        }

        // ================= DRAW CONTROL =================
        map.addControl(new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: true,
                polyline: false,
                rectangle: false,
                circle: false,
                marker: false
            }
        }));

        // Simpan polygon baru
        map.on(L.Draw.Event.CREATED, function (e) {
            drawnItems.clearLayers(); // hanya 1 polygon
            drawnItems.addLayer(e.layer);

            let geojson = e.layer.toGeoJSON();
            document.getElementById('area').value = JSON.stringify(geojson);
        });

        // ================= MARKER =================
        if (projectLat !== null && projectLng !== null) {
            marker = L.marker([projectLat, projectLng]).addTo(map)
                .bindPopup("Lokasi Project")
                .openPopup();

            document.getElementById('latitude').value = projectLat;
            document.getElementById('longitude').value = projectLng;
        }

        // ✅ KLIK MAP HANYA UPDATE MARKER (polygon aman)
        map.on('click', function(e) {
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) {
                marker.setLatLng([lat, lng]); // ✅ tidak remove layer
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        });
    }

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