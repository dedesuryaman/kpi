@extends('layouts.admin.app')
@push('title' , 'Data Pekerjaan')
@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">
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
						Kegiatan {{ $dinas->nm_sub_unit ?? '' }}
					</h4>
				</div>

				<div class="page-header-extra ms-md-auto text-md-end mt-sm-1 mt-md-0 my-md-0 my-2">

					@if($pekerjaan)
					@can('project.create')
					<div class="btn-group">
						<button class="btn btn-outline-primary waves-effect waves-light btn-create mx-3"
							id="openModalCreate"><i class="fa fa-plus"></i>
							Tambah Proyek (Pekerjaan)</button>
					</div>
					@endcan
					@endif

				</div>
			</div>
		</div>
	</div>
</div>

@if(!$pekerjaan)
<div class="alert alert-warning text-center shadow-sm py-4">

	<div class="mb-3">
		<i class="bx bx-info-circle text-warning" style="font-size:60px;"></i>
	</div>

	<h6 class="mb-1 fw-bold">Data Tidak Ditemukan</h6>
	<small>
		Data pekerjaan yang Anda cari tidak tersedia atau Anda tidak memiliki akses.
	</small>

</div>
@else
<div class="card shadow-sm">
	<div class="card-body container-fluid">

		<!-- PROGRAM -->
		<div class="row mb-2">
			<div class="col-12 col-md-2 fw-bold">
				PROGRAM
			</div>
			<div class="col-12 col-md-10">
				: {{ $pekerjaan->nm_program ?? '-' }}
			</div>
		</div>

		<!-- KEGIATAN -->
		<div class="row mb-2">
			<div class="col-12 col-md-2 fw-bold">
				KEGIATAN
			</div>
			<div class="col-12 col-md-10">
				: {{ $pekerjaan->nm_kegiatan ?? '-' }}
			</div>
		</div>

		<!-- SUB KEGIATAN -->
		<div class="row mb-3">
			<div class="col-12 col-md-2 fw-bold">
				SUB KEGIATAN
			</div>
			<div class="col-12 col-md-10">
				: {{ $pekerjaan->nm_sub_kegiatan ?? '-' }}
			</div>
		</div>

		<!-- SECTION ANGKA -->
		<div class="row text-center">

			<div class="col-12 col-md-4 mb-3">
				<div class="border rounded p-3 h-100">
					<div class="fw-bold small text-muted">ANGGARAN</div>
					<div class="text-danger fw-bold">
						{{ rupiah($pekerjaan->pagu_anggaran ?? 0) }}
					</div>
				</div>
			</div>

			<div class="col-12 col-md-4 mb-3">
				<div class="border rounded p-3 h-100">
					<div class="fw-bold small text-muted">REALISASI UANG</div>
					<div class="text-danger fw-bold">
						{{ rupiah($pekerjaan->realisasi ?? 0) }}
					</div>
				</div>
			</div>

			<div class="col-12 col-md-4 mb-3">
				<div class="border rounded p-3 h-100">
					<div class="fw-bold small text-muted">REALISASI FISIK</div>
					<div class="text-danger fw-bold">
						{{ rupiah(0) }}
					</div>
				</div>
			</div>

		</div>

	</div>
</div>

@endif
<div class="row">
	<div class="col-md-6">

	</div>
	<div class="col-md-6 text-end">

	</div>
</div>


<div class="row mt-3">
	@foreach($proyeks as $row)
	<div class="col-12 col-md-6 col-lg-4 mb-4">

		<div class="card h-100 border-0 shadow-sm position-relative card-hover">

			<!-- Full Clickable Area -->
			<a href="{{ route('kegiatan.pekerjaan.sub-pekerjaan.show') . '?id=' . $row->id }}"
				class="stretched-link text-decoration-none"></a>

			<div class="card-body d-flex flex-column">

				<!-- Title + Badge -->
				<div class="d-flex justify-content-between align-items-start mb-2">
					<h6 class="fw-bold mb-0 text-dark">
						{{ $row->nm_pekerjaan }}
					</h6>

					{{-- Badge Status --}}
					@php
					$badgeColor = match($row->status_progress) {
					'draft' => 'secondary',
					'proses' => 'warning',
					'selesai' => 'success',
					default => 'dark'
					};
					@endphp

					<span class="badge bg-{{ $badgeColor }}">
						{{ ucwords(str_replace('_', ' ', $row->status_progress)) }}
					</span>
				</div>

				<!-- Budget -->
				<div class="mb-2 small text-muted">
					Anggaran
				</div>
				<div class="fw-bold text-danger mb-3">
					{{ rupiah($row->pagu_anggaran) }}
				</div>

				<!-- Date -->
				<div class="small text-muted">
					{{ tanggalIndo($row->tanggal_mulai ?? '') }}
					-
					{{ tanggalIndo($row->tanggal_selesai ?? '') }}
				</div>

				<!-- Progress -->
				<div class="mt-3">
					<div class="d-flex justify-content-between small mb-1">
						<span>Progress</span>
						<span>{{ $row->progress }}%</span>
					</div>
					<div class="progress" style="height:6px;">
						<div class="progress-bar bg-success" style="width: {{ $row->progress }}%">
						</div>
					</div>
				</div>

				<!-- Button Section (Bottom) -->
				<div class="mt-auto pt-3">

					@if($row->status_progress == 'draft')
					@can('project.edit')
					<div class="d-flex gap-2">

						<button
							class="btn btn-sm btn-outline-primary waves-effect waves-light w-100 btn-edit-pekerjaan position-relative"
							data-id="{{ $row->id }}" style="z-index:2;">
							<i class="fa fa-edit me-1"></i> Edit
						</button>

						@can('project.delete')
						<button
							class="btn btn-sm btn-outline-danger waves-effect waves-light w-100 btn-delete-proyek position-relative"
							data-id="{{ $row->id }}" style="z-index:2;">
							<i class="fa fa-trash me-1"></i> Hapus
						</button>
						@endcan

					</div>
					@else
					<div class="text-center text-muted small">
						🔒 Tidak dapat diubah
					</div>
					@endcan
					@else
					<div class="text-center text-muted small">
						🔒 Terkunci
					</div>
					@endif

				</div>

			</div>
		</div>
	</div>
	@endforeach
</div>



<!-- Modal Bootstrap -->
<div class="modal fade" id="ajaxModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
	data-bs-keyboard="false">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<form id="formTambahPekerjaan" method="POST" action="{{ route('kegiatan.pekerjaan.create') }}"
			class="modal-content needs-validation" novalidate>
			<div class="modal-header">
				<h5 class="modal-title">Input Pekerjaan/Proyek (Draft)</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
			</div>

			@csrf
			<input type="hidden" name="kegiatan_id" value="{{ $pekerjaan->id ?? 0}}">
			<input type="hidden" name="kd_urusan" value="{{ $pekerjaan->kd_urusan ?? 0}}">
			<input type="hidden" name="kd_bidang" value="{{ $pekerjaan->kd_bidang ?? 0}}">
			<input type="hidden" name="kd_unit" value="{{ $pekerjaan->kd_unit ?? 0}}">
			<input type="hidden" name="kd_sub" value="{{ $pekerjaan->kd_sub ?? 0}}">
			<input type="hidden" name="kd_urusan90" value="{{ $pekerjaan->kd_urusan90 ?? 0}}">
			<input type="hidden" name="kd_bidang90" value="{{ $pekerjaan->kd_bidang90 ?? 0}}">
			<input type="hidden" name="kd_kegiatan90" value="{{ $pekerjaan->kd_kegiatan90 ?? 0}}">
			<input type="hidden" name="kd_sub_kegiatan" value="{{ $pekerjaan->kd_sub_kegiatan ?? 0}}">
			<div class="modal-body">
				<!-- contoh input: nama -->
				<div class="row">
					<div class="col-md-6">
						<label for="nomor_kontrak" class="form-label">Nomor kontrak <span
								class="text-danger">*</span></label>
						<input type="text" class="form-control" id="nomor_kontrak" name="nomor_kontrak" required
							minlength="3">
						<div class="invalid-feedback error-nomor_kontrak" data-field="nomor_kontrak"></div>
					</div>


					<!-- contoh input: deskripsi -->
					<div class="col-md-6">
						<label for="tanggal_kontrak" class="form-label">Tanggal Kontrak</label>
						<input type="date" class="form-control" id="tanggal_kontrak" name="tanggal_kontrak">
						<div class="invalid-feedback error-tanggal_kontrak" data-field="tanggal_kontrak"></div>
					</div>
				</div>

				<div class="col-12">
					<label for="nm_pekerjaan" class="form-label">Nama Pekerjaan/Proyek <span
							class="text-danger">*</span></label>
					<input type="text" class="form-control" id="nm_pekerjaan" name="nm_pekerjaan" required
						minlength="3">
					<div class="invalid-feedback error-nm_pekerjaan" data-field="nm_pekerjaan"></div>
				</div>
				<div class="col-12">
					<label for="deskripsi" class="form-label">Deskripsi Proyek <span
							class="text-danger">*</span></label>
					<textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
					<div class="invalid-feedback error-deskripsi" data-field="deskripsi"></div>
				</div>

				<div class="col-12">
					<label for="lokasi" class="form-label">Lokasi Proyek <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="lokasi" name="lokasi" required maxength="200">
					<div class="invalid-feedback error-lokasi" data-field="lokasi"></div>
				</div>

				<div class="row">

					<div class="col-md-4 mb-3">
						<label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
						<div>
							<input type="date" class="form-control" name="tanggal_mulai">
							<div class="invalid-feedback error-tanggal_mulai" data-field="tanggal_mulai"></div>
						</div>
					</div>


					<div class="col-md-4 mb-3">
						<label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
						<div>
							<input type="date" class="form-control" name="tanggal_selesai">
							<div class="invalid-feedback error-tanggal_selesai" data-field="tanggal_selesai"></div>
						</div>
					</div>

					<div class="col-md-4 mb-3">
						<label for="pagu_anggaran" class="form-label">Pagu Anggaran</label>

						<div>
							<input type="text" id="amount" class="form-control input-mask text-start rupiah"
								name="pagu_anggaran" required value="0" data-inputmask="'alias':'numeric',
						                        'groupSeparator':'.',
						                        'radixPoint':',',
						                        'digits':0,
						                        'autoGroup':true,
						                        'prefix':'Rp ',
						                        'placeholder':'0',
						                        'removeMaskOnSubmit':true">

							<div class="invalid-feedback error-pagu_anggaran" data-field="pagu_anggaran"></div>
						</div>
					</div>

				</div>
				<div class="row">
					<div class="col-md-4 mb-3">
						<label for="masa_pelaksanaan" class="form-label">Masa Pelaksanaan</label>
						<div>
							<input type="number" class="form-control" name="masa_pelaksanaan">
							<div class="invalid-feedback error-masa_pelaksanaan" data-field="masa_pelaksanaan"></div>
						</div>
					</div>
					<div class="col-md-4 mb-3">
						<label for="jenis_masa_pelaksanaan" class="form-label">Bulan/Minggu/Hari</label>
						<div>
							<select name="jenis_masa_pelaksanaan" class="form-control">
								<option value="bulan">Bulan</option>
								<option value="minggu">Minggu</option>
								<option value="hari">Hari</option>
							</select>
						</div>
					</div>

					<div class="col-md-4 mb-3">
						<label for="status" class="form-label">Status</label>
						<div>
							<input type="checkbox" name="status" checked value="Active"> Check to active
						</div>
					</div>

				</div>
				<div class='row'>
					<div class="col-md-12 mt-2">
						<label for="deskripsi" class="form-label">Lokasi dan Radius</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" name="latitude" id="latitude_add" value="" readonly>
							<input type="text" class="form-control" name="longitude" id="longitude_add" value=""
								readonly>
							<input type="number" class="form-control" name="radius" id="radius_add" value="100">
						</div>
					</div>
				</div>
				<div class="">
					<div style="border: 1px solid #000; border-radius: 10px;box-shadow: 0 4px 10px rgba(0,0,0,0.2);"
						class="mt-2">
						<div id="mapAdd" class=""
							style="height:300px;width:100%;border-radius: 12px; position: relative;">
						</div>

					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
				<button type="submit" id="submitBtn" class="btn btn-sm btn-primary">
					<span id="submitLabel">Simpan</span>
					<span id="submitSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"
						aria-hidden="true"></span>
				</button>
			</div>
		</form>
	</div>
</div>


<!-- Modal Bootstrap -->
<div class="modal fade" id="ajaxModalEditPekerjaan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
	data-bs-keyboard="false">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<form class="form" name="formUpdatePekerjaan" method="POST" action="/ajax/update_pekerjaan">
				<!-- Header -->
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Update Pekerjaan/Proyek</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
				</div>

				<!-- Body -->
				<div class="modal-body" id="editPekerjaan">
					<!-- Konten dinamis bisa dimasukkan di sini -->

				</div>

				<!-- Footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
					<button type="button" id="submitBtnUpdatePekerjaan" class="btn btn-primary btn-sm">
						<span id="submitLabelUpdate">Simpan</span>
						<span id="submitSpinnerUpdate" class="spinner-border spinner-border-sm d-none" role="status"
							aria-hidden="true"></span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<!-- form mask -->
<script src="{{ asset('assets/libs/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

@endpush

@push('scripts')

<script>
	$(document).ready(function() {
	
		$(".input-mask").inputmask();
	$('.btn-edit-pekerjaan').on('click',function(){
		
		let id = $(this).data('id');
		
		$('#editPekerjaan').html(loading_sm);
		
		$('#ajaxModalEditPekerjaan').modal('show');	
		
		$('#editPekerjaan').load("/ajax/load_edit_pekerjaan?id=" + id , function() {
         
        // Hapus listener lama agar tidak berulang
        $('#submitBtnUpdatePekerjaan').off('click');
		
		$('#submitBtnUpdatePekerjaan').on('click',async function() {
			 
				
				//lanjutkan 
				const ok = await confirmOnProgress();
				
				if (!ok) {
				
					return;
				}

				var form = $('#ajaxModalEditPekerjaan form');
				
				if (!form[0].checkValidity()) {
					form[0].reportValidity();
					
					
					return;
				}
				// 🔥 CONFIRM DULU SEBELUM SAVE
				Swal.fire({
				title: 'Simpan Data?',
				text: "Pastikan data sudah benar.",
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Simpan',
				cancelButtonText: 'Batal'
				}).then((result) => {

				$('#submitSpinnerUpdate').removeClass('d-none');
				$('#submitLabelUpdate').text('Menyimpan...');
				$(this).prop('disabled', true);
				
				
				  // Submit form via AJAX
					$.ajax({
						url: form.attr('action'),
						method: form.attr('method'),
						data: form.serialize(),
						success: function(res) {
							$('#submitSpinnerUpdate').addClass('d-none');
							$('#submitLabelUpdate').text('Simpan');
							$('#submitBtnUpdatePekerjaan').prop('disabled', false);

							// Tutup modal
							$('#ajaxModalEditPekerjaan').modal('hide');
							// Lakukan update tampilan atau reload data
							// Swal success (1.5 detik)
							Swal.fire({
								icon: 'success',
								title: 'Berhasil',
								text: 'Data berhasil disimpan',
								timer: 1500,
								showConfirmButton: false,
								timerProgressBar: true
							}).then(() => {
							// Reload setelah swal selesai
								location.reload();
							});
						},
						error: function(err) {
							$('#submitSpinnerUpdate').addClass('d-none');
							$('#submitLabelUpdate').text('Simpan');
							$('#submitBtnUpdatePekerjaan').prop('disabled', false);
							
							if (err.status === 422) {
								 
								
								let errors = err.responseJSON.errors;
								
								$.each(errors, function (key, value) {
								// Tambah class is-invalid
									$('[name="' + key + '"]').addClass('is-invalid');
									
									// Tampilkan error di bawah input
									$('.error-' + key).text(value[0]);
								});

								// Tampilkan pesan validation
								Swal.fire({
									icon: 'error',
									title: 'Validasi Gagal',
									html: "Periksa, data belum lengkap !",
									confirmButtonText: 'OK'
								});
							} else {
								// Error lain (500, 404, dsb)
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: 'Terjadi kesalahan saat memproses data!',
									confirmButtonText: 'OK'
								});
							}
						}
					});

				});	
					
			});
			
		});
	});

	async function confirmOnProgress() {
	if ($('#cek_status_progress').val() === 'on_progress') {
	
	const result = await Swal.fire({
	title: 'Konfirmasi',
	text: 'Apakah status akan diubah ke On Progress?',
	icon: 'warning',
	showCancelButton: true,
	confirmButtonText: 'Ya',
	cancelButtonText: 'Tidak',
	});
	
	if (!result.isConfirmed) {
	return false; // stop proses
	}
	
	return true; // lanjut
	}
	
	return true;
	}

	$('#openModalCreate').on('click', function() {
		$('#ajaxModal').modal('show');
	});

	$('#formTambahPekerjaan').on('submit', function(e) {

    e.preventDefault();

    let form = $(this);
    let url = form.attr('action');
    let data = form.serialize();

    // 🔥 CLEAR ERROR DULU
    $('.is-invalid').removeClass('is-invalid');
    $('[class^="error-"]').text('');

    // 🔥 CONFIRM DULU SEBELUM SAVE
    Swal.fire({
        title: 'Simpan Data?',
        text: "Pastikan data sudah benar.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {

            // 🚀 JALANKAN AJAX
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(response) {

                    if (response.status) {

                        $('#ajaxModal').modal('hide');
                        form[0].reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {

                    if (xhr.status === 422) {

                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, value) {
                            $('[name="' + key + '"]').addClass('is-invalid');
                            $('.error-' + key).text(value[0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: 'Data belum lengkap atau tidak valid.'
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Silakan coba lagi.'
                        });
                    }
                }
            });

        }

    });

});
    // $('#formTambahPekerjaan').on('submit', function(e) {
    //     e.preventDefault(); // mencegah submit default

    //     let form = $(this);
    //     let url = form.attr('action');
    //     let data = form.serialize(); // ambil semua field + csrf

    //     $.ajax({
    //         url: url,
    //         method: 'POST',
    //         data: data,
    //         success: function(response) {
    //             // jika sukses
    //             if(response.status) {
    //                 // Tutup modal
    //                 $('#ajaxModal').modal('hide');

    //                 // Reset form
    //                 form[0].reset();

    //                 // Optional: tampilkan notifikasi
    //                  Swal.fire({
	// 						icon: 'success',
	// 						title: 'Berhasil',
	// 						text: response.message,
	// 						timer: 1500,
	// 						showConfirmButton: false
	// 					});

	// 					// reload page
	// 					setTimeout(() => {
	// 						location.reload();
	// 					}, 1500);
    //             }
    //         },
    //         error: function(xhr) {
    //             // Handle error validation
    //             let errors = xhr.responseJSON.errors;
    //             if(errors) {
    //                 if (xhr.status === 422) {

    //                 let errors = xhr.responseJSON.errors;

    //                 $.each(errors, function (key, value) {
    //                     // Tambah class is-invalid
    //                     $('[name="' + key + '"]').addClass('is-invalid');

    //                     // Tampilkan error di bawah input
    //                     $('.error-' + key).text(value[0]);
    //                 });
					
	// 				Swal.fire("Error", "Data belum lengkap!", "error");
					
    //             }
    //             } else {
    //                 Swal.fire("Error", "Data belum lengkap!", "error");
    //             }
    //         }
    //     });
    // });
	
	
	 
	$(document).on('click', '.btn-delete-proyek', function () {
		let id = $(this).data('id');

		Swal.fire({
			title: 'Yakin hapus?',
			text: "Data tidak bisa dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya, hapus',
			cancelButtonText: 'Batal',
		}).then((result) => {
			if (result.isConfirmed) {

				$.ajax({
					url: '/sub-kegiatan/pekerjaan/sub-pekerjaan/delete/' + id,
					type: 'DELETE',
					data: {
						_token: "{{ csrf_token() }}"
					},
					success: function (response) {
						Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							text: response.message,
							timer: 1500,
							showConfirmButton: false
						});

						// reload page
						setTimeout(() => {
							location.reload();
						}, 1500);
					},

					error: function () {
						Swal.fire({
							icon: 'error',
							title: 'Gagal!',
							text: 'Tidak dapat menghapus data'
						});
					}
				});

			}
		});
	});
	 
});



</script>

<script>
	document.addEventListener("DOMContentLoaded", function () {

    const modalId = '#ajaxModal';
    let projectMapAdd = null;

    function initProjectMapAdd(options) {

        const config = {
            mapId: options.mapId,
            latInput: options.latInput,
            lngInput: options.lngInput,
            defaultLat: options.defaultLat ?? -6.84,
            defaultLng: options.defaultLng ?? 107.59,
            zoom: options.zoom ?? 15,
            locked: options.locked ?? false,
            projectLat: options.projectLat ?? null,
            projectLng: options.projectLng ?? null
        };

        let map = null;
        let marker = null;
		let circle = null;
        let isLocked = config.locked;

        function getCenter() {
            return [
                config.projectLat ?? config.defaultLat,
                config.projectLng ?? config.defaultLng
            ];
        }

        function createMap() {

            map = L.map(config.mapId, {
                attributionControl: false,
                doubleClickZoom: false
            }).setView(getCenter(), config.zoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
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
			
			
			document.getElementById('radius_add').addEventListener('input', function () {
			let radius = parseFloat(this.value);
			
			if (!isNaN(radius)) {
			circle.setRadius(radius);
			}
			});

        }

        function createMarker(lat, lng) {

            if (marker) {
                marker.setLatLng([lat, lng]);
				// ⬅ pindahkan circle mengikuti marker
				if (circle) {
				circle.setLatLng([lat, lng]);
				}
            } else {
                marker = L.marker([lat, lng], {
                    draggable: !isLocked
                }).addTo(map);

                // 🔥 Update input saat marker selesai digeser
                marker.on('dragend', function (e) {
                    const position = e.target.getLatLng();
                    updateInputs(position.lat, position.lng);

					// ⬅ pindahkan circle mengikuti marker
					if (circle) {
					circle.setLatLng([position.lat, position.lng]);
					}
                });
            }

            updateInputs(lat, lng);
        }

        function updateInputs(lat, lng) {
            document.getElementById(config.latInput).value = lat.toFixed(6);
            document.getElementById(config.lngInput).value = lng.toFixed(6);

			// ⬅ pindahkan circle mengikuti marker
			if (circle) {
			circle.setLatLng([lat, lng]);
			}

        }

        function bindMapDoubleClick() {
            map.on('dblclick', function (e) {
                if (isLocked) return;
                createMarker(e.latlng.lat, e.latlng.lng);

				// ⬅ pindahkan circle mengikuti marker
				if (circle) {
				circle.setLatLng([e.latlng.lat, e.latlng.lng]);
				}

            });
        }

        function bindManualInput() {
            const latBox = document.getElementById(config.latInput);
            const lngBox = document.getElementById(config.lngInput);

            latBox.addEventListener('change', updateFromInput);
            lngBox.addEventListener('change', updateFromInput);

            function updateFromInput() {
                const lat = parseFloat(latBox.value);
                const lng = parseFloat(lngBox.value);

                if (!isNaN(lat) && !isNaN(lng)) {
                    createMarker(lat, lng);
                    map.setView([lat, lng], config.zoom);

					// ⬅ pindahkan circle mengikuti marker
					if (circle) {
					circle.setLatLng([lat, lng]);
					}
						
                }
            }
        }

        return {
            init() {
                createMap();

                if (config.projectLat && config.projectLng) {
                    createMarker(config.projectLat, config.projectLng);
                }

                bindMapDoubleClick();
                bindManualInput();
            },

            invalidate() {
                if (map) {
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 200);
                }
            }
        };
    }

    // INIT SAAT MODAL DIBUKA
    $(modalId).on('shown.bs.modal', function () {

        if (!$(this).data('map-initialized')) {

            projectMapAdd = initProjectMapAdd({
                mapId: 'mapAdd',
                latInput: 'latitude_add',
                lngInput: 'longitude_add',
                projectLat: -6.83,
                projectLng: 107.48,
                locked: false
            });

            projectMapAdd.init();
            $(this).data('map-initialized', true);
        }

        projectMapAdd.invalidate();
    });

});
</script>
@endpush