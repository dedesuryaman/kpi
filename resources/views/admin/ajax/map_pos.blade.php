<style>
    #mapModalContainer {
        height: 70vh;
        width: 100%;
    }

    .controls input,
    .controls button,
    .controls select {
        padding: 6px 8px;
    }

    .controls {
        gap: 10px;
    }
</style>

<!-- KONTROL -->
<div class="controls d-flex flex-wrap mb-3">

    <label>Radius (m):
        <input class="form-control" id="radiusInput" type="number" value="50" min="1" style="width:90px;">
    </label>

    <button id="btnBuffer" class="btn btn-sm btn-warning">Buffer</button>
    <button id="btnClearBuffer" class="btn btn-sm btn-secondary">Hapus</button>

    <label>Lat:
        <input id="latInput" type="text" style="width:110px;">
    </label>
    <label>Lng:
        <input id="lngInput" type="text" style="width:110px;">
    </label>

    <button id="btnPlacePoint" class="btn btn-sm btn-info">Titik</button>
    <button id="btnCheck" class="btn btn-sm btn-success">Check</button>

    <button id="btnSendPolyline" class="btn btn-sm btn-dark">Kirim Polyline</button>
</div>

<div id="statusx" class="mb-2">Status: Ready</div>

<!-- MAP -->
<div id="mapModalContainer" style="height:400px;"></div>






<script>
    let mapPosPengawas, drawnItems, currentPolyline, bufferLayer, pointMarker;

        
            if (mapPosPengawas) {
				setTimeout(() => mapPosPengawas.invalidateSize(), 300);
			}
		 
        function initMapPosX() {
             

           // mapPosPengawas = L.map("mapModalContainer").setView([-6.914744, 107.609810], 13);
			
			mapPosPengawas = L.map("mapModalContainer", {
				dragging: true,
				zoomControl: true,
				scrollWheelZoom: true,
			}).setView([-6.914744, 107.609810], 13);
			
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(mapPosPengawas); 

            drawnItems = new L.FeatureGroup().addTo(mapPosPengawas);
            currentPolyline = null;
            bufferLayer = null;

            // DRAW CONTROL
            const drawControl = new L.Control.Draw({
                draw: { polyline: true },
                edit: { featureGroup: drawnItems }
            });
            mapPosPengawas.addControl(drawControl);

            mapPosPengawas.on(L.Draw.Event.CREATED, function (e) {
                drawnItems.clearLayers();
                if (bufferLayer) { mapPosPengawas.removeLayer(bufferLayer); bufferLayer = null; }
                currentPolyline = e.layer;
                drawnItems.addLayer(e.layer);
                updateStatus("Polyline dibuat");
            });

            mapPosPengawas.on("click", function(e){
                let lat = e.latlng.lat.toFixed(6);
                let lng = e.latlng.lng.toFixed(6);
                document.getElementById("latInput").value = lat;
                document.getElementById("lngInput").value = lng;
                placeMarker(lat, lng);
            });

            mapPosPengawas.invalidateSize();
        }

        function placeMarker(lat, lng){
            if (pointMarker) mapPosPengawas.removeLayer(pointMarker);
            pointMarker = L.marker([lat, lng]).addTo(mapPosPengawas);
        }

        function updateStatus(text){
            document.getElementById("statusx").textContent = "Status: " + text;
        }

        // BUFFER
        document.getElementById("btnBuffer").onclick = () => {
            if (!currentPolyline) return updateStatus("Buat polyline dulu");

            let radius = Number(document.getElementById("radiusInput").value);

            let coords = currentPolyline.getLatLngs().map(pt => [pt.lng, pt.lat]);
            let buff = turf.buffer(turf.lineString(coords), radius, { units:"meters" });

            if (bufferLayer) mapPosPengawas.removeLayer(bufferLayer);

            bufferLayer = L.geoJSON(buff, {
                style:{ color:"orange", weight:2, fillOpacity:.2 }
            }).addTo(mapPosPengawas);

            mapPosPengawas.fitBounds(bufferLayer.getBounds());
        };

        document.getElementById("btnClearBuffer").onclick = () => {
            if (bufferLayer) mapPosPengawas.removeLayer(bufferLayer);
            bufferLayer = null;
        };

        // PLACE MANUAL POINT
        document.getElementById("btnPlacePoint").onclick = () => {
            let lat = document.getElementById("latInput").value;
            let lng = document.getElementById("lngInput").value;
            if (!lat || !lng) return;
            placeMarker(lat, lng);
        };

        // CHECK POINT IN BUFFER
        document.getElementById("btnCheck").onclick = () => {
            if (!bufferLayer) return updateStatus("Buat buffer dulu");

            let lat = parseFloat(document.getElementById("latInput").value);
            let lng = parseFloat(document.getElementById("lngInput").value);

            let pt = turf.point([lng, lat]);
            let geo = bufferLayer.toGeoJSON();

            let inside = turf.booleanPointInPolygon(pt, geo.features ? geo.features[0] : geo);

            updateStatus(inside ? "Titik VALID (di dalam)" : "Titik TIDAK VALID");

            if (pointMarker)
                pointMarker.bindPopup(inside ? "Dalam Buffer" : "Luar Buffer").openPopup();
        };

        // SEND POLYLINE
        document.getElementById("btnSendPolyline").onclick = () => {
            if (!currentPolyline) return updateStatus("Poly belum ada");

            let latlngs = currentPolyline.getLatLngs().map(p => [p.lat, p.lng]);
            console.log("Polyline to backend:", latlngs);

            updateStatus("Poly siap dikirim (lihat console)");
        };
</script>