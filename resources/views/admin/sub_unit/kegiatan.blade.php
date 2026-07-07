@extends('layouts.admin.app')
@push('title' , 'Data Kegiatan')
@push('css')

<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
	type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
	type="text/css" />

<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
	type="text/css" />

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
						Sub Kegiatan {{ $dinas->nm_sub_unit ?? '' }}
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

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-12">
						@if(request('search') != "" && $kegiatans->isEmpty() )
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							Data tidak ditemukan ! <a href="javascript:history.back()">← Kembali</a>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
						@else
						@if ($kegiatans->isEmpty() )
						<div class="card">
							<div class="card-body">

								<h4 class="card-title">Belum ada data sub kegiatan untuk dinas {{ $dinas->nm_sub_unit }}
								</h4>
								<p class="card-title-desc">Klik tombol tarik data untuk mengunduh atau mengambil data
									dari sistem .</p>

								<div class="">
									<div id="liveAlertPlaceholder"></div>
									<a href="#" id="dialog-tarik" class="btn btn-primary" id="liveAlertBtn"><i
											class="fa fa-download"></i> Tarik
										Data</a>
								</div>
							</div>
						</div>

						@else
						<div class="row">
							<div class="col-md-9 mb-3">
								<a class="btn btn-outline-primary waves-effect waves-light btn-sm" href="#"
									id="dialog-tarik"><i class="fa fa-cloud"></i>
									Sync data</a>
							</div>
							<div class="col-md-3 mb-3 text-end">
								<form method="GET" action="{{ url()->current() }}" class="mb-3">

									{{-- Hidden input untuk mempertahankan semua parameter --}}
									<input type="hidden" name="id" value="{{ request('id') }}">
									<input type="hidden" name="urusan" value="{{ request('urusan') }}">
									<input type="hidden" name="bidang" value="{{ request('bidang') }}">
									<input type="hidden" name="unit" value="{{ request('unit') }}">
									<input type="hidden" name="sub" value="{{ request('sub') }}">

									<div class="input-group input-sm">
										<input type="text" name="search" value="{{ request('search') }}"
											class="form-control form-control-sm" placeholder="Cari sub kegiatan...">

										<button class="btn btn-outline-secondary waves-effect waves-light btn-sm"><i
												class="fa fa-search"></i>
											Cari</button>

										@if(request('search'))
										<a href="{{ url()->current() }}?id={{ request('id') }}
											   &urusan={{ request('urusan') }}
											   &bidang={{ request('bidang') }}
											   &unit={{ request('unit') }}
											   &sub={{ request('sub') }}" class="btn btn-outline-secondary btn-sm">
											Reset
										</a>
										@endif
									</div>
								</form>

							</div>
						</div>
						@endif
						@endif
						@if ($kegiatans)

						@php
						$lastProgram=null; $lastKegiatan = null;
						@endphp
					</div>

				</div>
				<div class="table-responsive">
					<table class="table table-sm table-hover">
						<thead class="table-dark">
							<tr>
								<th>#</th>
								<th>Kode</th>
								<th>Sub Kegiatan</th>
								<th class="text-end">Pagu</th>
								<th class="text-end">Anggaran</th>
								<th class="text-end">Realisasi</th>
								<th class="text-center d-none">Create</th>
								<th class="text-center d-none">Update</th>
								<th class="text-center">Sync</th>
							</tr>
						</thead>
						<tbody>
							<?php $n = 1 ?>
							@foreach($kegiatans as $row)

							@if ($lastProgram !== $row->nm_program)
							<tr style="background:#e1e1e1;">

								<td colspan="9" class="text-info"><strong>{{ $row->nm_program }}</strong></td>
							</tr>

							@php
							$lastProgram = $row->nm_program;
							@endphp
							@endif

							{{-- Tampilkan header hanya jika nm_kegiatan berubah --}}
							@if ($lastKegiatan !== $row->nm_kegiatan)
							<tr style="background:#f0f0f0;">
								<td class="text-end"><i class="fa fa-plus"></i></td>
								<td colspan="8" class="text-info"><strong>{{ $row->nm_kegiatan }}</strong></td>
							</tr>

							@php
							$lastKegiatan = $row->nm_kegiatan;
							@endphp
							@endif

							{{-- Detail baris --}}
							<tr>
								<td>
									<!--div class="btn-group">
									<button class="btn btn-sm btn-info"><i class="fa fa-search"></i></button>
									<button class="btn btn-sm btn-primary"><i class="fa fa-share"></i></button>
								</div-->
								</td>

								<td>{{ str_pad($row->kd_kegiatan90, 2, '0', STR_PAD_LEFT) }}.{{
									str_pad($row->kd_sub_kegiatan, 2, '0', STR_PAD_LEFT) }}</td>
								<td><a
										href="{{ route('kegiatan.pekerjaan') . '?id=' . $row->id . '&urusan=' . $row->kd_urusan . '&bidang=' . $row->kd_bidang . '&unit=' . $row->kd_unit . '&sub='. $row->kd_sub . '&=program=' . $row->kd_program90 . '&id_prog=' . $row->kd_kegiatan90  . '&kegiatan=' . $row->kd_sub_kegiatan  }}">{{
										$row->nm_sub_kegiatan }}</a></td>
								<td class="text-end">{{ rupiah(($row->pagu_anggaran ?? 0), false ,",") }}</td>
								<td class="text-end">{{ rupiah(($row->pagu_anggaran ?? 0), false,",")}}</td>
								<td class="text-end">{{ rupiah(($row->realisasi ?? 0), false,",")}}</td>
								<td class="text-center d-none" width="150px;">{{ $row->created_at }}</td>
								<td class="text-center d-none" width="150px;">{{ $row->updated_at }}</td>
								<td class="text-center" width="150px;">{{ $row->last_sync}}</td>
							</tr>

							@endforeach
							</body>
					</table>
				</div>
				<hr>
				{{ $kegiatans->links('vendor.pagination.bootstrap-first-last') }}

				@endif
			</div>
		</div>
	</div>
</div>

<!-- Modal Tarik Data -->
<div class="modal fade" id="modalTarik" tabindex="-1" aria-labelledby="modalTarikLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTarikLabel">Sinkronisasi Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="avatar-md mx-auto mb-4">
					<div class="avatar-title bg-light rounded-circle text-primary h1">
						<i class="mdi mdi-cloud-download"></i>
					</div>
				</div>
				<div class="row justify-content-center">
					Apakah Anda yakin ingin melakukan penarikan data dari server?
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

				<button type="button" class="btn btn-primary" id="btnTarikData" data-url="{{ route('kegiatan.sync') }}"
					data-kd_urusan="{{ $payloads['kd_urusan'] ?? 0 }}"
					data-kd_bidang="{{ $payloads['kd_bidang'] ?? 0 }}" data-kd_unit="{{ $payloads['kd_unit'] ?? 0 }}"
					data-kd_sub="{{ $payloads['kd_sub'] ?? 0 }}" data-tahun="{{ $payloads['tahun'] ?? 0 }}">
					Ya, Tarik Data
				</button>
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

@endpush
@push('scripts')
<script>
	$(document).ready(function(){
		$("#datatable").DataTable(),
		$("#datatable-buttons").DataTable({
			lengthChange:!1,
			buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),$(".dataTables_length select").addClass("form-select form-select-sm")});
	
    document.getElementById('dialog-tarik').addEventListener('click', function(e) {
        e.preventDefault();
        var modal = new bootstrap.Modal(document.getElementById('modalTarik'));
        modal.show();
    });
	
	
	
	$('#btnTarikData').on('click', function () {
    let url = $(this).data('url');
	let kd_urusan = $(this).data('kd_urusan');
	let kd_bidang = $(this).data('kd_bidang');
	let kd_unit = $(this).data('kd_unit');
	let kd_sub = $(this).data('kd_sub');
	let tahun = $(this).data('tahun');
	
    let button = $(this);

    // Tampilkan loading
    button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');;

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
			'kd_urusan' : kd_urusan,
			'kd_bidang' : kd_bidang,
			'kd_unit' : kd_unit,
			'kd_sub' : kd_sub,
			'tahun' : tahun
        },
        success: function (res) {
            button.prop('disabled', false).text('Ya, Tarik Data');


			if (res.status == true) {
				// Tampilkan status sukses
				// Tutup modal
				$('#modalTarik').modal('hide');
				Swal.fire({
					icon: 'success',
					title: 'Berhasil',
					text: 'Data berhasil disinkronkan!'
				}).then(() => {
					location.reload();   // 🔄 Reload halaman
				});
			}else{

				Swal.fire({
					icon: 'error',
					title: 'Gagal',
					text: res.message
				}).then(() => {
				//
				});
			}
        },
        error: function (xhr) {
            button.prop('disabled', false).text('Ya, Tarik Data');

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat sinkronisasi.'
            });
        }
    });
});


</script>


@endpush