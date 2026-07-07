<style>
    /* Contoh styling kustom slider */
    #progressRange {
        accent-color: #0d6efd;
        /* warna slider track / thumb */
        cursor: pointer;
        height: 8px;
    }

    #progressRange::-webkit-slider-thumb {
        width: 20px;
        height: 20px;
        background: #0d6efd;
        border-radius: 50%;
        cursor: pointer;
        border: none;
    }

    #progressRange::-moz-range-thumb {
        width: 20px;
        height: 20px;
        background: #0d6efd;
        border-radius: 50%;
        cursor: pointer;
        border: none;
    }
</style>

<input type="hidden" name="id" value="{{ $pekerjaan->id }}">
<div class="row">
    <div class="col-md-6 mb-1">
        <label for="nomor_kontrak" class="form-label">Nomor Kontrak <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nomor_kontrak" name="nomor_kontrak"
            value="{{ $pekerjaan->nomor_kontrak }}" required minlength="3">
        <div class="invalid-feedback error-nomor_kontrak" data-field="nomor_kontrak"></div>
    </div>

    <div class="col-md-6  mb-1">
        <label for="tanggal_kontrak" class="form-label">Tanggal Kontrak <span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="tanggal_kontrak" name="tanggal_kontrak"
            value="{{ $pekerjaan->tanggal_kontrak }}" required minlength="3">
        <div class="invalid-feedback error-tanggal_kontrak" data-field="tanggal_kontrak"></div>
    </div>

</div>
<div class="mb-1">
    <label for="nm_pekerjaan" class="form-label">Nama Pekerjaan/Proyek <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="nm_pekerjaan" name="nm_pekerjaan" value="{{ $pekerjaan->nm_pekerjaan }}"
        required minlength="3">
    <div class="invalid-feedback error-nm_pekerjaan" data-field="nm_pekerjaan"></div>
</div>


<!-- contoh input: deskripsi -->
<div class="mb-1">
    <label for="deskripsi" class="form-label">Deskripsi</label>
    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $pekerjaan->deskripsi }}</textarea>
    <div style="font-size:8px;"><i>Max : 500</i></div>
    <div class="invalid-feedback error-deskripsi" data-field="deskripsi"></div>
</div>

<div class="mb-1">
    <label for="lokasi" class="form-label">Alamat/Lokasi <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $pekerjaan->lokasi }}" required
        minlength="3">
    <div class="invalid-feedback error-lokasi" data-field="lokasi"></div>
</div>

<div class="row">

    <div class="col-md-4 mb-2">
        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
        <div>
            <input type="date" class="form-control" name="tanggal_mulai" value="{{ $pekerjaan->tanggal_mulai }}">
            <div class="invalid-feedback error-tanggal_mulai" data-field="deskripsi"></div>
        </div>
    </div>


    <div class="col-md-4 mb-2">
        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
        <div>
            <input type="date" class="form-control" name="tanggal_selesai" value="{{ $pekerjaan->tanggal_selesai }}">
            <div class="invalid-feedback error-tanggal_selesai" data-field="tanggal_selesai"></div>
        </div>
    </div>

    <div class="col-md-4 mb-2">
        <label for="deskripsi" class="form-label">Status</label>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="statusCheckbox" name="status" value="Active" {{
                $pekerjaan->status == 'Active' ? 'checked' : '' }}>
            <label class="form-check-label" for="statusCheckbox">
                Check to Active
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label for="pagu_anggaran" class="form-label">Pagu Anggaran</label>
        <div>
            <input type="text" id="amount" class="form-control text-start rupiah" name="pagu_anggaran" required
                value="{{ $pekerjaan->pagu_anggaran }}" data-inputmask="'alias':'numeric',
            						                        'groupSeparator':'.',
            						                        'radixPoint':',',
            						                        'digits':0,
            						                        'autoGroup':true,
            						                        'prefix':'Rp ',
            						                        'placeholder':'0',
            						                        'removeMaskOnSubmit':true" requeired>

            <div class="invalid-feedback error-pagu_anggaran" data-field="pagu_anggaran"></div>
        </div>

    </div>
    <div class="col-md-4">
        <label for="masa_pelaksanaan" class="form-label">Masa Pelaksanaan</label>
        <div>
            <input type="number" class="form-control" name="masa_pelaksanaan"
                value="{{ $pekerjaan->masa_pelaksanaan }}">
            <div class="invalid-feedback error-masa_pelaksanaan" data-field="masa_pelaksanaan"></div>

        </div>
    </div>
    <div class="col-md-4">
        <label for="jenis_masa_pelaksanaan" class="form-label">Bulan/Minggu/Hari</label>
        <div>
            <select name="jenis_masa_pelaksanaan" class="form-control">
                <option value="bulan" {{ $pekerjaan->jenis_masa_pelaksanaan == 'bulan' ? 'selected' : '' }}>Bulan
                </option>
                <option value="minggu" {{ $pekerjaan->jenis_masa_pelaksanaan == 'minggu' ? 'selected' : '' }}>Minggu
                <option value="hari" {{ $pekerjaan->jenis_masa_pelaksanaan == 'hari' ? 'selected' : '' }}>Hari</option>


            </select>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-4 mt-2">


        <label for="status_progress{{ $pekerjaan->id }}" class="form-label">
            Tahap Pekerjaan</label>

        <input type="hidden" value="{{ $pekerjaan->status_progress }}" id="cek_status_progress" name="status_progress">
        <div>{{ $pekerjaan->status_progress }}</div>
        <div class="invalid-feedback error-status_progress" data-field="status_progress"></div>
    </div>
    <div class="col-md-8 mt-2">
        <label for="deskripsi" class="form-label">Lokasi</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="latitude" id="latitude" value="{{ $pekerjaan->latitude }}"
                readonly>
            <input type="text" class="form-control" name="longitude" id="longitude" value="{{ $pekerjaan->longitude }}"
                readonly>
            <input type="number" class="form-control" name="radius" id="radius" value="{{ $pekerjaan->radius ?? 0 }}">
        </div>
    </div>
</div>

<div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" id="toggleMapLock">
    <label class="form-check-label" for="toggleMapLock" id="toggleMapLabel">
        🔒 Locked
    </label>
</div>
<div style="border: 1px solid #000; border-radius: 10px;box-shadow: 0 4px 10px rgba(0,0,0,0.2);" class="mt-2">
    <div id="map" class="" style="height:300px;width:100%;border-radius: 12px; position: relative;"></div>

</div>

<script>
    $(document).ready(function () {
      
        $('.rupiah').inputmask();

    function initProjectMap(options) {

        const config = {
            mapId: options.mapId || 'map',
            latInput: options.latInput || 'latitude',
            lngInput: options.lngInput || 'longitude',
            defaultLat: options.defaultLat || -6.84,
            defaultLng: options.defaultLng || 107.59,
            radius : options.radius,
            zoom: options.zoom || 15,
            locked: options.locked ?? true,
            projectLat: options.projectLat ?? -6.84,
            projectLng: options.projectLng ?? 107.59
        };

        let map = null;
        let marker = null;
        let circle = null; // ⬅ tambahkan ini
        let isLocked = config.locked;
        function createMap() {
            map = L.map(config.mapId, {
                attributionControl: false,
                doubleClickZoom: false // ⬅ penting
            }).setView(getCenter(), config.zoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);


            // circle dengan radius awal
            circle = L.circle(
            [config.projectLat ?? config.defaultLat, config.projectLng ?? config.defaultLng],
            {
            radius: config.radius ?? 100,
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.3
            }
            ).addTo(map);
            

            document.getElementById('radius').addEventListener('input', function () {
            let radius = parseFloat(this.value);
            
            if (!isNaN(radius)) {
            circle.setRadius(radius);
            }
            });

           
            
            toggleMap(isLocked);
        }


        

        /**
         * Get center position
         */
        function getCenter() {
            return [
                config.projectLat ?? config.defaultLat,
                config.projectLng ?? config.defaultLng
            ];
        }

        /**
         * Create marker if data exists
         */
        function createMarker(lat, lng) {

            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], {
                    draggable: false,
                    riseOnHover: true
                }).addTo(map);

                bindMarkerEvents(); // penting supaya event drag aktif
            }

            marker
                .bindPopup(`Lokasi Proyek<br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`)
                .openPopup();

            updateInputs(lat, lng);

            // ⬅ pindahkan circle mengikuti marker
            if (circle) {
                circle.setLatLng([lat, lng]);
            }
        }

        /**
         * Marker events
         */
        function bindMarkerEvents() {
            if (!marker) return;

            marker.on('dragend', function (e) {
                if (isLocked) return;

                const { lat, lng } = e.target.getLatLng();
                updateInputs(lat, lng);

                // ⬅ update circle
                if (circle) {
                circle.setLatLng([lat, lng]);
                }

                
            });
        }

        /**
         * Map click event
         */
        function bindMapDoubleClick() {
        map.on('dblclick', function (e) {
        if (isLocked) return;
        
        const { lat, lng } = e.latlng;
        createMarker(lat, lng);
        });
        }

        /**
         * Update input latitude & longitude
         */
        function updateInputs(lat, lng) {
            $('#' + config.latInput).val(lat);
            $('#' + config.lngInput).val(lng);
        }

        /**
         * Lock / Unlock map
         */
        function toggleMap(lock) {
            isLocked = lock;

            if (lock) {
                map.dragging.disable();
                //map.scrollWheelZoom.disable();
                //map.doubleClickZoom.disable();
                if (marker) marker.dragging.disable();
                $('#toggleMapLabel').html('🔒 Locked');
            } else {
                map.dragging.enable();
                //map.scrollWheelZoom.enable();
                //map.doubleClickZoom.enable();
                if (marker) marker.dragging.enable();
                $('#toggleMapLabel').html('🔓 Unlocked');
            }
        }

        /**
         * Public API
         */
        return {
            init() {
                createMap();

                if (config.projectLat !== null && config.projectLng !== null) {
                    createMarker(config.projectLat, config.projectLng, false);
                    updateInputs(config.projectLat, config.projectLng);
                }

                bindMapDoubleClick();

                // Fix map in modal
                setTimeout(() => {
                    map.invalidateSize();
                }, 300);
            },

            lock() {
                toggleMap(true);
            },

            unlock() {
                toggleMap(false);
            }

            
        };
        
    }

    // ===============================
    // 🔥 IMPLEMENTASI
    // ===============================

    const projectMap = initProjectMap({
        mapId: 'map',
        latInput: 'latitude',
        lngInput: 'longitude',
        projectLat: {{ $pekerjaan->latitude ?? -6.84 }},
        projectLng: {{ $pekerjaan->longitude ?? 107.59 }},
        radius : {{ $pekerjaan->longitude ?? 100 }},
        locked: true
    });

    projectMap.init();

    // Toggle Lock
    $('#toggleMapLock').on('change', function () {
        this.checked ? projectMap.unlock() : projectMap.lock();
    });

});
</script>

<script>
    // Progress range interaktif
// document.querySelectorAll('.progressRange').forEach(slider => {
//     const id = slider.dataset.id;
//     const rangeValue = document.getElementById('rangeValue' + id);

//     function updateSlider(value) {
//         rangeValue.textContent = value + '%';

//         let color;
//         if (value < 50) color = 'red';
//         else if (value < 80) color = 'orange';
//         else color = 'green';

//         rangeValue.style.color = color;
//     }

//     updateSlider(slider.value);

//     slider.addEventListener('input', e => updateSlider(e.target.value));
// });



</script>
<script>
    //     document.querySelectorAll('.progressRange').forEach(slider => {
//     const id = slider.dataset.id;
//     const rangeValue = document.getElementById('rangeValue' + id);

//     function updateSlider(value) {
//         rangeValue.textContent = value + '%';

//         // Tentukan warna angka
//         let color;
//         if (value < 50) color = 'red';
//         else if (value < 80) color = 'orange'; // kuning agak gelap supaya terbaca
//         else color = 'green';

//         // Ganti warna teks saja, bukan slider
//         rangeValue.style.color = color;
//     }

//     // Inisialisasi
//     updateSlider(slider.value);

//     // Event listener
//     slider.addEventListener('input', (e) => updateSlider(e.target.value));
// });
</script>