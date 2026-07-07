@extends('layouts.admin.app')
@push('title' , 'Data Pekerjaan')
@push('styles')
<style>
    body,
    html {
        height: 100%;
        margin: 0;
    }

    #map {
        width: 100%;
        height: 100vh;
    }

    .info-box {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1000;
        background: white;
        padding: 8px 12px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .user-item {
        cursor: pointer;
        /* ubah kursor menjadi hand */
        transition: background-color 0.3s;
        /* animasi halus saat hover */
    }

    .user-item:hover {
        background-color: #f0f0f0;
        /* ganti warna sesuai selera */
    }
</style>
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<style>
    .select2-container {
        width: 100% !important;
    }

    .select2-container {
        z-index: 99999 !important;
    }

    .select2-dropdown {
        z-index: 999999 !important;
        /* di atas modal */
    }
</style>
@endpush
@push('styles')
<style>
    .page-header-container {
        border-radius: 6px;
        overflow: hidden;
        background-color: #e5e9f0;

    }

    .page-header-number {
        font-size: 26px;
        font-weight: 700;
        background-color: #acb2bb;
        color: #070d16;
        padding: 15px 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
        border-right: 1px solid #acb2bb;
    }
</style>
@endpush

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">
@endpush
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row shadow-sm page-header-container">
            <div class="page-header-number flex-shrink-0">
                <i class="bx bx-camera bx-5x text-primary"></i>
            </div>
            <div
                class="page-header-title-bar w-100 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-md-0">
                    <h4 class="mb-0 text-secondary mx-3 mt-3 mt-md-0 font-size-18 fw-bold text-uppercase title-text">
                        Sub Kegiatan {{ $dinas->nm_sub_unit ?? '-' }}
                    </h4>
                </div>

                <div class="page-header-extra ms-md-auto text-md-end mt-sm-1 mt-md-0">

                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sub Kegiatan</a></li>
                        <li class="breadcrumb-item active">Listing</li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">

        <!-- PROGRAM -->
        <div class="row align-items-start mb-2">
            <div class="col-12 col-md-2 text-muted small fw-semibold">
                PROGRAM
            </div>
            <div class="col-12 col-md-10 fw-bold">
                {{ $kegiatan->nm_program ?? '-' }}
            </div>
        </div>

        <!-- KEGIATAN -->
        <div class="row align-items-start mb-2">
            <div class="col-12 col-md-2 text-muted small fw-semibold">
                KEGIATAN
            </div>
            <div class="col-12 col-md-10 fw-bold">
                {{ $kegiatan->nm_kegiatan ?? '-' }}
            </div>
        </div>

        <!-- SUB KEGIATAN -->
        <div class="row align-items-start mb-3">
            <div class="col-12 col-md-2 text-muted small fw-semibold">
                SUB KEGIATAN
            </div>
            <div class="col-12 col-md-10 fw-bold">
                <a class="text-decoration-none" href="{{ url('/sub-kegiatan/pekerjaan?id=' . $kegiatan->id . 
                        '&urusan=' . $kegiatan->kd_urusan . 
                        '&bidang=' . $kegiatan->kd_bidang . 
                        '&unit=' . $kegiatan->kd_unit . 
                        '&sub=' . $kegiatan->kd_sub . 
                        '&program=' . $kegiatan->kd_program90 . 
                        '&id_prog=' . $kegiatan->kd_kegiatan90 . 
                        '&kegiatan=' . $kegiatan->kd_sub_kegiatan ) }}">
                    {{ $kegiatan->nm_sub_kegiatan ?? '-' }}
                </a>
            </div>
        </div>

        <hr class="my-3">

        <!-- FINANCIAL SUMMARY -->
        <div class="row text-center g-3">

            <div class="col-12 col-md-4">
                <div class="p-3 rounded-3 bg-light h-100">
                    <div class="text-muted small fw-semibold">ANGGARAN</div>
                    <div class="fw-bold text-danger">
                        {{ rupiah($kegiatan->pagu_anggaran ?? 0) }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="p-3 rounded-3 bg-light h-100">
                    <div class="text-muted small fw-semibold">REALISASI UANG</div>
                    <div class="fw-bold text-danger">
                        {{ rupiah($kegiatan->realisasi ?? 0) }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="p-3 rounded-3 bg-light h-100">
                    <div class="text-muted small fw-semibold">REALISASI FISIK</div>
                    <div class="fw-bold text-danger">
                        {{ rupiah(0) }}
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<div class="card shadow shadow-sm" style="min-height:500px;">
    <div class="card-body position-relative" id="load_content" style="min-height:150px;">

        <!-- Loading Overlay -->
        <div id="loading_spinner" class="d-flex flex-column justify-content-center align-items-center 
                position-absolute top-0 start-0 w-100 h-100 bg-white" style="z-index: 10; padding: 20px;">

            <div class="spinner-border mb-3" role="status"></div>
            <div class="fw-bold">Memuat data ...</div>
        </div>

    </div>
</div>

<!--modal-->
<?php 
//<select id="mySelect" style="width:100%;" data-id="{{ $pekerjaan->id }}"></select>
?>
<!-- MODAL -->
<div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Pilih OPD Pengawas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">



                <!-- Form pencarian -->
                <form id="formCariUser">
                    <div class="input-group mb-3">
                        <input type="text" id="keywordUser" class="form-control"
                            placeholder="Masukkan nama / email / username">
                        <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                    </div>
                </form>

                <!-- List hasil pencarian -->
                <div id="userList">
                    <p class="text-muted">Masukkan keyword di atas untuk mencari user...</p>
                </div>

                <input type="hidden" id="selectedPekerjaanId" name="{{ $pekerjaan->id }}">
                <input type="hidden" id="selectedUserId" name="user_id" data-id="{{$pekerjaan->id}}">
                <hr>
                <label>Selected OPD</label>
                <input type="text" id="selectedUserName" readonly class="form-control mb-2" placeholder="OPD terpilih">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" id="submitOPDPengawas" class="btn btn-primary btn-sm">
                    <span id="submitLabel">Simpan</span>
                    <span id="submitSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                        aria-hidden="true"></span>
                </button>
            </div>

        </div>
    </div>
</div>





<div class="modal fade" id="modalOrganization" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Pilih Kontraktor Pelaksana</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- SEARCH -->
                <input type="text" id="searchOrg" class="form-control mb-3" placeholder="Cari kontraktor...">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody id="org-table-body">
                            <tr id="loadingRow">
                                <td colspan="2" class="text-center py-5">
                                    <i class="fa fa-spinner fa-spin" style="font-size:40px;"></i>
                                </td>
                            </tr>
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
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<script src="https://kit.fontawesome.com/c75f60c9db.js" crossorigin="anonymous"></script>
<!-- Turf.js (untuk buffer polyline) -->
<script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
<!-- Select2 CSS & JS (v4.x) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/@googlemaps/polyline-codec"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<!-- form mask -->
<script src="{{ asset('assets/libs/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

@endpush


@push('scripts')



<script>
    let currentPage = 1;
	let map = null;
	let mapPengawas = null;
	let mapPos = null;
	let mapX = null;
	
	let drawnItems = null;
	let currentPolyline = null;
	let bufferLayer = null;
	let pointMarker = null;
	let drawControl = null;
	
	let targetField = null;
	
    //let  marker = null;

	const projectLat = {{ $pekerjaan->latitude ?? 'null' }};
	const projectLng = {{ $pekerjaan->longitude ?? 'null' }};
	const projectRad = {{ $pekerjaan->radius ?? 'null' }};
	 
	let defaultLat = -6.84;
    let defaultLng = 107.59;
	let defaultRad = 10;
	
    let centerLat = projectLat !== null ? projectLat : defaultLat;
    let centerLng = projectLng !== null ? projectLng : defaultLng;
	let centerRad = projectRad !== null ? projectRad : defaultRad;
	
	function setPosPengawasan(lat, lng) {
		document.getElementById("pos_latitude").value = lat;
		document.getElementById("pos_longitude").value = lng;

		
	}

    
		// Tampilkan spinner saat mulai
    $("#loading_spinner").removeClass("d-none");
	
	function loadData(){
		// Tampilkan spinner
		$("#loading_spinner").removeClass("d-none");

		// Bersihkan konten lama sebelum load
		$("#load_content").empty();
		
		map = null;
		mapPengawas = null;
		mapPos = null;
		mapX = null;
		
		drawnItems = null;
		currentPolyline = null;
		bufferLayer = null;
		pointMarker = null;
		drawControl = null;
		targetField = null;
		
		$("#load_content").load("/ajax/load_pekerjaan?id={{ $pekerjaan->id }}", function() {
			$("#loading_spinner").fadeOut(300);
		});	
	}
	
	window.loadData = loadData;

    loadData();
	
	 $(document).ready(function(){
		 
			
	 });
	 
	 $(document).ajaxComplete(function () {
		toastr.clear();
	});


</script>

<script>
    function loadPage(url, targetId) {
    const target = document.getElementById(targetId);

    // Tampilkan loading
    target.innerHTML = `<div class="text-center py-4">Loading...</div>`;

    fetch(url, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(response => {
        if (!response.ok) throw new Error("Gagal mengambil halaman");
        return response.text();
    })
    .then(html => {
        target.innerHTML = html;
    })
    .catch(err => {
        target.innerHTML = `<div class="alert alert-danger">Error: ${err.message}</div>`;
    });
}

function loadPageDiv(url, target = "#content") {

$.ajax({
url: url,
type: "GET",
success: function (res) {

$(target).html(res);

// Execute inline script
$(target).find("script").each(function () {
if ($(this).attr("src")) {
$.getScript($(this).attr("src"));
} else {
eval($(this).text());
}
});
}
});
}

</script>




@endpush