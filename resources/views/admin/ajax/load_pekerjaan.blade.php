<style>
	.card-body {

		padding: 0.5rem 1rem;
	}

	.card-footer {
		padding: .125rem 0.55rem;
		background-color: rgb(225 225 225) !important;
	}

	/* Card modern */
	.custom-card {
		border: none;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
		transition: all 0.3s ease;
	}

	.custom-card:hover {
		box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
		transform: translateY(-2px);
	}

	/* Gambar zoom */
	.card-img-wrapper {
		overflow: hidden;
		border-bottom: 1px solid #eee;
	}

	.card-img-wrapper img {
		width: 100%;
		transition: transform 0.4s ease;
	}

	.card-img-wrapper img:hover {
		transform: scale(1.07);
	}

	/* Footer */
	.card-footer-custom {
		background: #fff;
		border-top: 1px solid #eee !important;
	}
</style>
@if($pekerjaan->status_progress == 'verifikasi')
<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<i class="mdi mdi-alert-outline me-2"></i>
	Menunggu verifikasi dari PPK
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
			<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
			<span class="d-none d-sm-block">Detail Pekerjaan</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-bs-toggle="tab" href="#pengawasan" role="tab">
			<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
			<span class="d-none d-sm-block">Pengawasan</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-bs-toggle="tab" href="#dokumen" role="tab">
			<span class="d-block d-sm-none"><i class="far fa-folder"></i></span>
			<span class="d-none d-sm-block">Dokumen</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-bs-toggle="tab" href="#peta" role="tab">
			<span class="d-block d-sm-none"><i class="fas fa-map"></i></span>
			<span class="d-none d-sm-block">Peta Lokasi Proyek/Kegiatan</span>
		</a>
	</li>
</ul>
<div class="tab-content py-3 text-muted">
	<div class="tab-pane active" id="home" role="tabpanel">
		<div class="row">
			<div class="col-md-6 col-6 d-flex align-items-center">


				<span class="badge rounded-pill me-2
											                {{ $pekerjaan->lastClosure ? 'bg-danger' : 'bg-info' }}">
					{{ $pekerjaan->lastClosure?->status ? $pekerjaan->lastClosure->status : $pekerjaan->status ??
					'Project Open'
					}}
				</span>


				@if($pekerjaan->status_progress == 'selesai')
				<span class="badge rounded-pill bg-success">Selesai</span>
				@elseif($pekerjaan->status_progress == 'verifikasi')
				<span class="badge rounded-pill bg-warning">Verifikasi</span>
				@elseif($pekerjaan->status_progress == 'on_progress')
				<span class="badge rounded-pill bg-primary">On Progress</span>
				@elseif($pekerjaan->status_progress == 'draft')
				<span class="badge rounded-pill bg-danger">Draft</span>
				@else

				@endif


			</div>
			<div class="col-md-6 col-6">
				@if($pekerjaan->status_progress != 'selesai')
				<ul class="list-inline user-chat-nav text-end mb-0">


					<li class="list-inline-item">
						<div class="dropdown">
							<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
								<i class="bx bx-cog"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="#" data-id="{{ $pekerjaan->id }}" data-bs-toggle="modal"
									data-bs-target="#modalChangeStatus"><i class="fa fa-edit"></i> Update Status</a>

								<a class="dropdown-item"
									href="{{ url('laporan/sub-pekerjaan?tahun=' .( $pekerjaan->subKegiatan?->tahun ?? '' ). '&opd_id=&proyek_id=' . $pekerjaan->id . '&status=') }}"><i
										class="fa fa-file"></i> Lihat laporan</a>

							</div>
						</div>
					</li>
					@if($pekerjaan->status_progress == 'draft')
					<li class="list-inline-item">
						<div class="dropdown">
							<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
								<i class="bx bx-dots-horizontal-rounded"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end" style="">

								@can('project.edit')
								@if($pekerjaan->status_progress == 'draft')
								<a href="javascript:void(0);" class="dropdown-item btn-edit-pekerjaan"
									data-id="{{ $pekerjaan->id }}"><i class="fa fa-edit"></i> Update
									Data Proyek</a>

								@endif
								@endcan

								@can('project.edit')
								@if($pekerjaan->status_progress == 'draft')
								<a href="javascript:void(0);" class="dropdown-item" data-id="{{ $pekerjaan->id }}"
									data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i> OPD
									Pengawas Proyek</a>

								@endif
								@endcan

								@can('project.edit')
								@if($pekerjaan->status_progress == 'draft')
								<a class="dropdown-item" href="#" data-bs-toggle="modal"
									data-bs-target="#modalOrganization" data-id="kon_pelaksana_id"
									onclick="setTarget('pelaksana')"><i class="fa fa-edit"></i> Kontraktor Pelaksana</a>

								@endif
								@endcan

								@can('project.edit')
								@if($pekerjaan->status_progress == 'draft')

								<a class="dropdown-item" href="#" data-bs-toggle="modal"
									data-bs-target="#modalOrganization" data-id="kon_pengawas_id"
									onclick="setTarget('pengawas')"><i class="fa fa-edit"></i> Kontraktor/Konsultan
									Pengawas</a>
								@endif
								@endcan

							</div>
						</div>
					</li>
					@endif
				</ul>
				@endif
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-8">
				<h5 class="mb-0 fw-bold text-primary">
					{{ $pekerjaan->nm_pekerjaan }}
				</h5>

				<!-- TITLE -->
				<div class="mb-2">

					<div class="small text-muted mt-1">
						{{ $pekerjaan->lokasi }}
					</div>
				</div>

				<!-- DESKRIPSI -->
				<div class="mb-3 small text-muted">
					{!! nl2br(e($pekerjaan->deskripsi)) !!}
				</div>


				<!-- FINANCIAL STRIP -->
				<div class="border rounded-3 px-2 py-2 mb-3 bg-light">
					<div class="row text-center g-0 small">

						<div class="col-6 col-md-3 border-end">
							<div class="text-muted text-uppercase">Pagu</div>
							<div class="fw-bold text-dark">
								{{ rupiah($pekerjaan->pagu_anggaran ?? 0) }}
							</div>
						</div>

						<div class="col-6 col-md-3 border-end">
							<div class="text-muted text-uppercase">Anggaran</div>
							<div class="fw-bold text-primary">
								{{ rupiah($pekerjaan->total_anggaran ?? 0) }}
							</div>
						</div>

						<div class="col-6 col-md-3 border-end mt-2 mt-md-0">
							<div class="text-muted text-uppercase">Realisasi</div>
							<div class="fw-bold text-success">
								{{ rupiah($pekerjaan->total_realisasi ?? 0) }}
							</div>
						</div>

						<div class="col-6 col-md-3 mt-2 mt-md-0">
							<div class="text-muted text-uppercase">%</div>
							<div class="fw-bold 
			                    @if($pekerjaan->persentase_realisasi >= 80) text-success
			                    @elseif($pekerjaan->persentase_realisasi >= 50) text-warning
			                    @else text-danger
			                    @endif">
								{{ number_format($pekerjaan->persentase_realisasi,2) }}%
							</div>
						</div>

					</div>
				</div>


				<!-- META INFO (INLINE, NO BOX) -->
				<div class="row g-2 mb-3">

					<!-- KOORDINAT -->
					<div class="col-6 col-md-3">
						<div class="card border-0 shadow-sm rounded-3 text-center py-2">
							<div class="text-muted small text-uppercase"><i class="bx bx-map me-1 text-primary"></i>
								Koordinat</div>
							<div class="fw-semibold">
								{{ $pekerjaan->latitude ?? 0 }}, {{ $pekerjaan->longitude ?? 0 }}
							</div>
						</div>
					</div>

					<!-- MULAI -->
					<div class="col-6 col-md-3">
						<div class="card border-0 shadow-sm rounded-3 text-center py-2">
							<div class="text-muted small text-uppercase"><i
									class="bx bx-calendar me-1 text-primary"></i> Mulai</div>
							<div class="fw-semibold">
								{{ tanggalIndo($pekerjaan->tanggal_mulai ?? '-') }}
							</div>
						</div>
					</div>

					<!-- SELESAI -->
					<div class="col-6 col-md-3">
						<div class="card border-0 shadow-sm rounded-3 text-center py-2">
							<div class="text-muted small text-uppercase"><i
									class="bx bx-calendar-check me-1 text-primary"></i> Selesai</div>
							<div class="fw-semibold">
								{{ tanggalIndo($pekerjaan->tanggal_selesai ?? '-') }}
							</div>
						</div>
					</div>

					<!-- DURASI -->
					<div class="col-6 col-md-3">
						<div class="card border-0 shadow-sm rounded-3 text-center py-2">
							<div class="text-muted small text-uppercase"><i class="bx bx-time me-1 text-primary"></i>
								Durasi</div>
							<div class="fw-semibold">
								{{ $pekerjaan->masa_pelaksanaan ?? 0 }} {{ $pekerjaan->jenis_masa_pelaksanaan ?? '-' }}
							</div>
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-md-6">

						<!-- PROGRESS (MINIMAL) -->
						<div class="card border-1 shadow-sm rounded-3 text-center p-2 bg-light">
							@php
							$progress = $pekerjaan->progress_summary ?? 0;
							if ($progress <= 30) { $color='bg-danger' ; } elseif ($progress <=70) { $color='bg-warning'
								; } else { $color='bg-success' ; } @endphp <div class="mb-2">
								<div class="d-flex justify-content-between small mb-1">
									<span class="text-muted">Progress</span>
									<span class="fw-semibold">{{ number_format($progress,2) }}%</span>
								</div>

								<div class="progress" style="height:6px;">
									<div class="progress-bar {{ $color }}" style="width: {{ $progress }}%;"></div>
								</div>
						</div>
					</div>


				</div>

				<div class="col-md-3">
					<div class="card border-0 shadow-sm rounded-3 text-center py-2">
						<div class="text-muted small text-uppercase"><i class="bx bx-calendar me-1 text-primary"></i>
							Closure</div>
						<div class="fw-semibold">
							{{ $pekerjaan->lastClosure?->end_date ? tanggalIndo($pekerjaan->lastClosure->end_date) : '-'
							}}
						</div>
					</div>

				</div>
				<div class="col-md-3">
					<div class="card border-0 shadow-sm rounded-3 text-center py-2">
						<div class="text-muted small text-uppercase"><i class="bx bx-timer me-1 text-primary"></i>
							Judge</div>
						<div class="fw-semibold">
							@php
							use Carbon\Carbon;

							$target = $pekerjaan->tanggal_selesai
							? Carbon::parse($pekerjaan->tanggal_selesai)
							: null;

							$realisasi = optional($pekerjaan->lastClosure)->end_date
							? Carbon::parse($pekerjaan->lastClosure->end_date)
							: null;

							$status = '-';
							$badge = 'secondary';

							if ($target && $realisasi) {

							$selisih = $target->diffInDays($realisasi, false);
							// false agar bisa negatif (lebih cepat)

							if ($selisih < -7) { $status='Lebih Cepat' ; $badge='success' ; } elseif ($selisih <=0) {
								$status='Sesuai Waktu' ; $badge='primary' ; } else { $status='Terlambat' ;
								$badge='danger' ; } } @endphp <span class="badge bg-{{ $badge }}">
								{{ $status }}
								</span>

						</div>
					</div>

				</div>
			</div>



			<!-- Modal Bootstrap -->
			<div class="modal fade" id="ajaxModalEditPekerjaan" tabindex="-1" aria-hidden="true"
				data-bs-backdrop="static" data-bs-keyboard="false">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<form class="form" name="formUpdatePekerjaan" method="POST" action="/ajax/update_pekerjaan">
							<!-- Header -->
							@csrf
							<div class="modal-header">
								<h5 class="modal-title">Update Pekerjaan/Proyek</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"
									aria-label="Tutup"></button>
							</div>

							<!-- Body -->
							<div class="modal-body" id="editPekerjaan">
								<!-- Konten dinamis bisa dimasukkan di sini -->

							</div>

							<!-- Footer -->
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary btn-sm"
									data-bs-dismiss="modal">Batal</button>
								<button type="button" id="submitBtnUpdatePekerjaan" class="btn btn-primary btn-sm">
									<span id="submitLabelUpdate">Simpan</span>
									<span id="submitSpinnerUpdate" class="spinner-border spinner-border-sm d-none"
										role="status" aria-hidden="true"></span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- Modal Tambah Sub Pekerjaan -->
			<div class="modal fade" id="modalProgress" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
				data-bs-keyboard="false">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">

						<div class="modal-header">
							<h5 class="modal-title">Tambah Sub Pekerjaan</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>

						<div class="modal-body">
							<form id="formProgress">
								@csrf
								<input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id }}">

								<div class="row g-3">

									<!-- KODE -->
									<div class="col-md-2">
										<label class="form-label small text-uppercase text-muted">Nomor/Kode</label>
										<input type="number" min="1" name="kd_sub_pekerjaan"
											class="form-control form-control-sm" value="1" required>
										<div class="invalid-feedback"></div>
									</div>

									<!-- JUDUL -->
									<div class="col-md-10">
										<label class="form-label small text-uppercase text-muted">Judul Sub
											Pekerjaan</label>
										<input type="text" name="judul" class="form-control form-control-sm" required>
										<div class="invalid-feedback"></div>
									</div>

									<!-- DESKRIPSI -->
									<div class="col-12">
										<label class="form-label small text-uppercase text-muted">Deskripsi
											Pekerjaan</label>
										<textarea name="deskripsi" class="form-control form-control-sm" rows="3"
											required></textarea>
										<div class="invalid-feedback"></div>
									</div>

									<!-- TANGGAL -->
									<div class="col-md-6">
										<label class="form-label small text-uppercase text-muted">Tanggal
											Mulai</label>
										<input type="date" name="tanggal_mulai" class="form-control form-control-sm"
											required>
										<div class="invalid-feedback"></div>
									</div>

									<div class="col-md-6">
										<label class="form-label small text-uppercase text-muted">Tanggal
											Selesai</label>
										<input type="date" name="tanggal_selesai" class="form-control form-control-sm"
											required>
										<div class="invalid-feedback"></div>
									</div>

									<!-- DURASI -->
									<div class="col-md-4">
										<label class="form-label small text-uppercase text-muted">Masa</label>
										<input type="number" name="masa_pelaksanaan"
											class="form-control form-control-sm" placeholder="7" required>
										<div class="invalid-feedback"></div>
									</div>

									<div class="col-md-4">
										<label class="form-label small text-uppercase text-muted">Satuan</label>
										<select name="jenis_masa_pelaksanaan" class="form-select form-select-sm"
											required>
											<option value="hari">Hari</option>
											<option value="minggu">Minggu</option>
											<option value="bulan">Bulan</option>
										</select>
										<div class="invalid-feedback"></div>
									</div>

									<!-- STATUS -->
									<div class="col-md-4">
										<label class="form-label small text-uppercase text-muted">Status</label>
										<select name="status_progress" class="form-select form-select-sm" required>
											<option value="menunggu_mulai">Menunggu Mulai</option>
											<option value="proses_pengerjaan">Proses Pengerjaan</option>
											<option value="selesai_pengerjaan">Selesai Pengerjaan</option>
											<option value="menunggu_verifikasi">Menunggu Verifikasi</option>
											<option value="selesai_disetujui">Selesai & Disetujui</option>
										</select>
										<div class="invalid-feedback"></div>
									</div>

									<!-- ANGGARAN -->
									<div class="col-md-4">
										<label class="form-label small text-muted">ANGGARAN (Rp)</label>

										<input type="text" class="form-control input-mask text-start rupiah"
											name="anggaran" required value="0" data-inputmask="'alias':'numeric',
																								            						                        'groupSeparator':'.',
																								            						                        'radixPoint':',',
																								            						                        'digits':0,
																								            						                        'autoGroup':true,
																								            						                        'prefix':'Rp ',
																								            						                        'placeholder':'0',
																								            						                        'removeMaskOnSubmit':true">
										<div class="invalid-feedback"></div>
									</div>

								</div>
							</form>
						</div>

						<div class="modal-footer">
							<button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
							<button class="btn btn-sm btn-primary" id="btnSubmitProgress">Simpan</button>
						</div>


					</div>
				</div>
			</div>
			<!-- Modal Tambah Sub Pekerjaan -->
			<!-- Modadal Update Sub Pekerjaan -->
			@foreach($sub_pekerjaans as $sp)
			<div class="modal fade" id="modalEditSubPekerjaan{{ $sp->id}}" tabindex="-1" aria-hidden="true"
				data-bs-backdrop="static" data-bs-keyboard="false">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">

						<div class="modal-header">
							<h5 class="modal-title">Update Sub Pekerjaan</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>

						<div class="modal-body">
							<form id="formUpdateSubPekerjaan{{ $sp->id}}">
								@csrf
								<input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id }}">
								<div class="mb-3">
									<label class="form-label">Kode</label>
									<input type="number" min="1" name="kd_sub_pekerjaan" class="form-control"
										value="{{ $sp->kd_sub_pekerjaan }}" required>
									<div class="invalid-feedback"></div>
								</div>


								<div class="mb-3">
									<label class="form-label">Judul</label>
									<input type="text" name="judul" class="form-control" required
										value="{{ $sp->judul }}">
									<div class="invalid-feedback"></div>
								</div>

								<div class="mb-3">
									<label class="form-label">Deskripsi</label>
									<textarea name="deskripsi" class="form-control" rows="3"
										required>{{ $sp->deskripsi }}</textarea>
									<div class="invalid-feedback"></div>
								</div>

								<div class="row">
									<div class="col-md-6 mb-3">
										<label class="form-label">Tanggal Mulai</label>
										<input type="date" name="tanggal_mulai" class="form-control" required
											value="{{ $sp->tanggal_mulai }}">
										<div class="invalid-feedback"></div>
									</div>

									<div class="col-md-6 mb-3">
										<label class="form-label">Tanggal Selesai</label>
										<input type="date" name="tanggal_selesai" class="form-control" required
											value="{{ $sp->tanggal_selesai }}">
										<div class="invalid-feedback"></div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6 mb-3">
										<label class="form-label">Masa Pelaksanaan</label>
										<input type="number" name="masa_pelaksanaan" class="form-control"
											placeholder="contoh: 7" required value="{{ $sp->masa_pelaksanaan }}">
										<div class="invalid-feedback"></div>
									</div>

									<div class="col-md-6 mb-3">
										<label class="form-label">Jenis Masa Pelaksanaan</label>
										<select name="jenis_masa_pelaksanaan" class="form-control" required>
											<option value="hari" {{ $sp->jenis_masa_pelaksanaan == 'hari' ?
												'selected' :
												'' }}>Hari</option>
											<option value="minggu" {{ $sp->jenis_masa_pelaksanaan == 'minggu' ?
												'selected'
												: '' }}>Minggu</option>
											<option value="bulan" {{ $sp->jenis_masa_pelaksanaan == 'bulan' ?
												'selected' :
												'' }}>Bulan</option>
										</select>
										<div class="invalid-feedback"></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label class="form-label">Status Progress</label>
										<select name="status_progress" class="form-control" required>
											<option value="menunggu_mulai" {{ $sp->status_progress ==
												'menunggu_mulai' ?
												'selected'
												: '' }}>Menunggu Mulai</option>
											<option value="proses_pengerjaan" {{ $sp->status_progress ==
												'proses_pengerjaan' ?
												'selected'
												: '' }}>Proses Pengerjaan</option>
											<option value="selesai_pengerjaan" {{ $sp->status_progress ==
												'selesai_pengerjaan' ?
												'selected'
												: '' }}>Selesai Pengerjaan</option>
											<option value="menunggu_verifikasi" {{ $sp->status_progress ==
												'menunggu_verifikasi' ?
												'selected'
												: '' }}>Menunggu Verifikasi</option>
											<option value="selesai_disetujui" {{ $sp->status_progress ==
												'selesai_disetujui' ?
												'selected'
												: '' }}>Selesai & Disetujui</option>
										</select>
										<div class="invalid-feedback"></div>
									</div>
									<div class="col-md-6">

										<label class="form-label">Anggaran</label>

										<input type="text" class="form-control input-mask text-start rupiah"
											name="anggaran" required value="{{  $sp->anggaran }}" data-inputmask="'alias':'numeric',
																																			            						                        'groupSeparator':'.',
																																			            						                        'radixPoint':',',
																																			            						                        'digits':0,
																																			            						                        'autoGroup':true,
																																			            						                        'prefix':'Rp ',
																																			            						                        'placeholder':'0',
																																			            						                        'removeMaskOnSubmit':true">

										<div class="invalid-feedback"></div>

									</div>
								</div>

							</form>
						</div>

						<div class="modal-footer">
							<button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
							<button class="btn btn-sm btn-primary btnSubmitUpdateSubPekerjaan">Simpan</button>
						</div>


					</div>
				</div>
			</div>
			@endforeach



		</div>
		<div class="col-md-4">
			<div class="row g-3">
				<!-- Nomor Kontrak -->
				<div class="col-md-6">
					<label for="nomor_kontrak" class="form-label small text-uppercase text-muted">Nomor
						Kontrak</label>
					<input type="text" id="nomor_kontrak" class="form-control form-control-sm"
						value="{{ $pekerjaan->nomor_kontrak ?? '-' }}" readonly>
				</div>

				<!-- Tanggal Kontrak -->
				<div class="col-md-6">
					<label for="tanggal_kontrak" class="form-label small text-uppercase text-muted">Tanggal
						Kontrak</label>
					<input type="text" id="tanggal_kontrak" class="form-control form-control-sm"
						value="{{ tanggalIndo($pekerjaan->tanggal_kontrak ?? '-') }}" readonly>
				</div>

				<!-- Kontraktor Pelaksana -->
				<div class="col-md-6">
					<label for="kon_pelaksana_name" class="form-label small text-uppercase text-muted">Kontraktor
						Pelaksana</label>
					<div class="input-group input-group-sm">
						<input type="text" id="kon_pelaksana_name" class="form-control"
							value="{{ $pekerjaan->konPelaksana->name ?? '-' }}" readonly
							placeholder="Pilih Kontraktor Pelaksana">
						<input type="hidden" name="kon_pelaksana_id" id="kon_pelaksana_id">

					</div>
				</div>

				<!-- Kontraktor / Konsultan Pengawas -->
				<div class="col-md-6">
					<label for="kon_pengawas_name" class="form-label small text-uppercase text-muted">Kontraktor /
						Konsultan
						Pengawas</label>
					<div class="input-group input-group-sm">
						<input type="text" id="kon_pengawas_name" class="form-control"
							value="{{ $pekerjaan->konPengawas->name ?? '-' }}" readonly
							placeholder="Pilih Kontraktor / Pengawas">
						<input type="hidden" name="kon_pengawas_id" id="kon_pengawas_id">

					</div>
				</div>

			</div>

			<div class="mb-2 mt-2">
				<label for="formrow-firstname-input" class="form-label">Penanggunjawab (Pengawas OPD)</label>
				<div>


					{{ $pekerjaan->opdPengawas->name ?? '-' }}
				</div>
				<div>
					{{ $pekerjaan->opdPengawas->email ?? '-' }}
				</div>


			</div>

			<div class="mb-3">
				@can('project.approved')
				@if(in_array($pekerjaan->lastClosure?->status ,['disetujui', 'ditolak'] ))
				<hr>
				<div class="text-center mt-3">
					<button type="button" class="btn btn-success w-md btn-project-approval"
						data-id="{{ $pekerjaan->id }}" data-bs-toggle="modal" data-bs-target="#pekerjaanApprovalModal"
						title="Persetujuan bahwa proyek selesai secara resmi.">
						<i class="fas fa-file-signature"></i>
						Project Approved (Closing)
					</button>
				</div>
				@endif
				@endcan
			</div>


			<div class="modal fade" id="pekerjaanApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false"
				tabindex="-1">
				<div class="modal-dialog modal-lg">
					<form id="formClosure" action="{{ url('/proyek-closure/store') }}" method="POST"
						enctype="multipart/form-data">
						@csrf

						<input type="hidden" name="pekerjaan_id" id="modal_pekerjaan_id" value="{{ $pekerjaan->id }}">

						<div class="modal-content">
							<div class="modal-header bg-success text-white">
								<h5 class="modal-title text-light">
									Approval Penutupan Proyek
								</h5>
								<button type="button" class="btn-close btn-close-white"
									data-bs-dismiss="modal"></button>
							</div>

							<div class="modal-body">

								{{-- Tanggal --}}
								<div class="mb-3">
									<label class="form-label">Tanggal Selesai</label>
									<input type="date" name="end_date" class="form-control" required>
								</div>

								{{-- Status --}}
								<div class="mb-3">
									<label class="form-label">Status Akhir</label>
									<select name="status" class="form-select" required>
										<option value="sesuai">Sesuai Rencana</option>
										<option value="revisi">Dengan Revisi</option>
										<option value="catatan">Dengan Catatan</option>
									</select>
								</div>

								{{-- Checklist --}}
								<div class="mb-3">
									<label class="form-label">Konfirmasi</label>

									<div class="form-check">
										<input type="checkbox" name="deliverable_completed" value="1"
											class="form-check-input">
										<label class="form-check-label">Deliverable selesai</label>
									</div>

									<div class="form-check">
										<input type="checkbox" name="payment_completed" value="1"
											class="form-check-input">
										<label class="form-check-label">Pembayaran selesai</label>
									</div>

									<div class="form-check">
										<input type="checkbox" name="documentation_completed" value="1"
											class="form-check-input">
										<label class="form-check-label">Dokumentasi diserahkan</label>
									</div>
								</div>

								{{-- Catatan --}}
								<div class="mb-3">
									<label class="form-label">Catatan</label>
									<textarea name="notes" class="form-control" rows="3"></textarea>
								</div>

								{{-- Upload Tanda Tangan --}}
								<div class="mb-3">
									<label class="form-label">Tanda Tangan (PNG/JPG)</label>
									<input type="file" name="signature" class="form-control"
										accept="image/png,image/jpeg">
								</div>

							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
									Batal
								</button>

								<button type="submit" class="btn btn-success" id="btnSubmitClosure">
									Simpan Approval
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<script>
				function initProjectApprovalModal() {
			
			    // Event delegation untuk tombol approve
			    document.body.addEventListener('click', function(e){
			        if(e.target.closest('.btn-project-approval')) {
			            const btn = e.target.closest('.btn-project-approval');
			            const projectId = btn.dataset.id;
			
			            const modalInput = document.getElementById('modal_pekerjaan_id');
			            if(modalInput) modalInput.value = projectId;
			        }
			    });
			
			    // Submit form dengan AJAX (pastikan form sudah ada)
			    const form = document.getElementById('formClosure');
			    const btnSubmit = document.getElementById('btnSubmitClosure');
			    if(form && btnSubmit){
			
			        // Hapus listener lama agar tidak double-bind
			        form.removeEventListener('submit', form._submitHandler);
			
			        form._submitHandler = function(e){
			            e.preventDefault();
			
			            Swal.fire({
			                title: 'Yakin tutup proyek?',
			                text: "Proyek akan dinyatakan selesai.",
			                icon: 'warning',
			                showCancelButton: true,
			                confirmButtonColor: '#198754',
			                cancelButtonColor: '#6c757d',
			                confirmButtonText: 'Ya, Approve!',
			                cancelButtonText: 'Batal'
			            }).then((result) => {
			                if(result.isConfirmed){
			
			                    let formData = new FormData(form);
			                    btnSubmit.disabled = true;
			                    btnSubmit.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Processing...`;
			
			                    fetch(form.action, {
			                        method: 'POST',
			                        headers: {'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value},
			                        body: formData
			                    })
			                    .then(response => {
			                        if(!response.ok){
			                            return response.json().then(err => Promise.reject(err));
			                        }
			                        return response.json();
			                    })
			                    .then(data => {
									console.log(data);
			                        // Close modal
			                        const modalEl = document.getElementById('pekerjaanApprovalModal');
			                        const modal = bootstrap.Modal.getInstance(modalEl);
			                        if(modal) modal.hide();
									
									loadData();
									
			                        // Update badge & hide tombol
			                        const projectId = formData.get('pekerjaan_id');
			                        const badge = document.getElementById('status-badge-' + projectId);
			                        if(badge){
			                            badge.textContent = 'Closed';
			                            badge.className = 'badge bg-success';
			                        }
			
			                        const btnApprove = document.querySelector('.btn-project-approval[data-id="'+projectId+'"]');
			                        if(btnApprove) btnApprove.style.display = 'none';
									
									// Reset tombol & form
									btnSubmit.disabled = false;
									btnSubmit.innerHTML = "Simpan Approval";
									form.reset();

			                        Swal.fire({
			                            icon: 'success',
			                            title: 'Berhasil!',
			                            text: 'Project berhasil di-approve.'
			                        }).then((result) => {
									if (result.isConfirmed) {
										
									}
									});
			
			                        
			                    })
			                    .catch(error => {
			                        btnSubmit.disabled = false;
			                        btnSubmit.innerHTML = "Simpan Approval";
			
			                        if(error.errors){
			                            let messages = Object.values(error.errors).map(e => e[0]).join('<br>');
			                            Swal.fire({icon:'error', title:'Validasi Gagal', html: messages});
			                        } else {
			                            Swal.fire({icon:'error', title:'Terjadi Kesalahan', text:'Silakan coba lagi.'});
			                        }
			                    });
			
			                }
			            });
			
			        };
			
			        form.addEventListener('submit', form._submitHandler);
			    }
			}
			
			// Panggil setiap kali modal & tombol diinject via AJAX
			initProjectApprovalModal();
			</script>


		</div>


	</div>

	<hr>

	<div class="row">
		<div class="col-md-12">

			<!-- Nav tabs -->
			<ul class="nav nav-tabs nav-tabs-custom" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
						type="button" role="tab">
						<i class="bx bx-task"></i> Sub Pekerjaan
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button"
						role="tab">
						<i class="bx bx-money"></i> Anggaran
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button"
						role="tab">
						<i class="bx bx-money"></i> Realisasi Anggaran
					</button>
				</li>
			</ul>

			<!-- Tab content -->
			<div class="tab-content border border-top-0 p-3" id="myTabContent">
				<div class="tab-pane fade show active" id="tab1" role="tabpanel">
					@can('project.create')
					@if($pekerjaan->status_progress == 'draft')
					<div>
						<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalProgress"
							id="btnModalProgress">
							<i class="fa fa-plus"></i> Tambah Sub Pekerjaan</button>
					</div>
					@endif
					@endcan
					<div class="table-responsive mt-2">
						<table class="table table-sm table-hover">
							<thead class="table-dark">
								<th>Options</th>
								<th>Nomor/Kode</th>
								<th>Judul</th>
								<th>Tanggal Mulai</th>
								<th>Tanggal Selesai</th>
								<th class="text-center">Masa Pelaksanaan</th>
								<th>Anggaran</th>
								<th>Realisasi</th>
								<th>% Progress</th>
								<th>Status</th>
							</thead>
							<tbody class="">
								@php $n=1; @endphp
								@foreach($sub_pekerjaans as $sp)
								<tr>
									<td>
										@if($sp->status_progress == 'menunggu_mulai' && $pekerjaan->status == 'Active')
										<div class="btn-group">

											@php
											$hasAction =
											auth()->user()->can('project.edit') ||
											auth()->user()->can('project.delete');
											@endphp

											@if($hasAction || $sp->status == 'menunggu_mulai')

											@can('project.edit')
											<button type="button" class="btn btn-sm btn-info btn-edit-sub-pekerjaan"
												data-id="{{ $sp->id }}" data-bs-toggle="modal"
												data-bs-target="#modalEditSubPekerjaan{{ $sp->id }}">
												<i class="fa fa-edit"></i>
											</button>
											@endcan

											@can('project.delete')
											<button type="button" class="btn btn-sm btn-danger btn-delete-sub-pekerjaan"
												data-id="{{ $sp->id }}">
												<i class="fa fa-trash"></i>
											</button>
											@endcan

											@else

											<button type="button" class="btn btn-sm btn-warning">
												<span>🔒</span>
											</button>
											@endif


										</div>
										@else
										@if($sp->status == 'Active')
										@can('progress.approved')
										<button type="button" class="btn btn-sm btn-info">
											<span class="fas fa-file-signature"></span>
										</button>
										@else
										<button type="button" class="btn btn-sm btn-danger">
											<span>🔒</span>
										</button>
										@endcan
										@endif
										@endif
									</td>

									<td>{{ $sp->kd_sub_pekerjaan ?? 0 }}</td>
									<td>{{ $sp->judul ?? ''}}</td>
									<td>{{ tanggalIndo($sp->tanggal_mulai ?? '') }}</td>
									<td>{{ tanggalIndo($sp->tanggal_selesai ?? '') }}</td>
									<td>{{ $sp->masa_pelaksanaan ?? ''}} {{ $sp->jenis_masa_pelaksanaan ?? '' }}
									</td>

									<td>{{ rupiah($sp->anggaran ?? 0) }}</td>
									<td>{{ rupiah($sp->anggaran_sum_nilai_realisasi ?? 0) }}</td>
									<td>{{ $sp->persentase_progress ?? 0 }} %</td>
									<td>{{ $statusList[$sp->status_progress] ?? '-' }}</td>

								</tr>

								@endforeach
							</tbody>
						</table>
					</div>

				</div>

				<div class="tab-pane fade" id="tab2" role="tabpanel">
					@can('project.create')
					<div>
						<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAnggaran"
							id="btnModalAnggaran">
							<i class="fa fa-plus"></i> Tambah Anggaran</button>
					</div>
					<hr>
					@endcan
					<div class="table-responsive">
						<table class="table table-sm" id="table-anggaran">
							<thead class="table-dark">
								<th>No</th>
								<th>Tannggal</th>
								<th>Sub Pekerjaan</th>
								<th>Keterangn</th>
								<th>Item (QTY)</th>
								<th>Satuan</th>
								<th>Nilai (Rp)</th>
								<th>Total (Rp)</th>
								<th>Opsi</th>
							</thead>
							<tbody>
								@php $n = 1 @endphp
								@foreach($anggaran as $ag)
								<tr>
									<td>{{ $n++ }}</td>
									<td>{{ tanggalIndo($ag->tanggal ?? '-') }}</td>
									<td>{{ $ag->subPekerjaan?->judul ?? '-'}}</td>
									<td>{{ $ag->judul ?? '-' }}</td>
									<td>{{ $ag->item ?? '0'}}</td>
									<td>{{ $ag->satuan ?? '-'}}</td>
									<td>{{ number_format($ag->nilai,0) }}</td>
									<td>{{ number_format(($ag->nilai ?? 0) * ($ag->item ?? 0)) }}</td>

									<td>
										@can('project.delete')
										<button type="button" class="btn btn-sm btn-danger delete-anggaran"
											data-id="{{ $ag->id }}">
											<i class="fa fa-trash"></i>
										</button>
										@endcan
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>


					<div class="modal fade" id="ModalAnggaran" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-centered">
							<div class="modal-content">

								<div class="modal-header">
									<h5 class="modal-title">Input Rincian Anggaran</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
								</div>

								<form id="formAnggaran">
									@csrf
									<input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id }}">
									<input type="hidden" name="sub_kegiatan_id" value="{{ $pekerjaan->kegiatan_id }}">
									<div class="modal-body">

										<div class="row">
											<div class="col-md-12 mb-3">
												<label class="form-label">Sub Pekerjaan</label>
												<select name="sub_pekerjaan_id" class="form-select" required>
													<option value="">-- Pilih --</option>
													@foreach($sub_pekerjaans as $row)
													<option value="{{ $row->id }}">
														{{ $row->judul }}
													</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-6 mb-3">
												<label class="form-label">Tanggal</label>
												<input type="date" name="tanggal" class="form-control" required>
											</div>

											<div class="col-md-12 mb-3">
												<label class="form-label">Judul/Keterangan</label>
												<input type="text" name="judul" class="form-control">
											</div>

											<div class="col-md-4 mb-3">
												<label class="form-label">Nilai</label>

												<input type="text" id="amount"
													class="form-control input-mask text-start rupiah" name="nilai"
													required value="0" data-inputmask="'alias':'numeric',
																		                        'groupSeparator':'.',
																		                        'radixPoint':',',
																		                        'digits':0,
																		                        'autoGroup':true,
																		                        'prefix':'Rp ',
																		                        'placeholder':'0',
																		                        'removeMaskOnSubmit':true" required>

											</div>

											<div class="col-md-4 mb-3">
												<label class="form-label">Item (QTY)</label>
												<input type="number" name="item" class="form-control" required>
											</div>

											<div class="col-md-4 mb-3">
												<label class="form-label">Satuan</label>
												<input type="text" name="satuan" class="form-control" required>
											</div>



										</div>

									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-secondary"
											data-bs-dismiss="modal">Tutup</button>

										<button type="submit" class="btn btn-success">
											Simpan
										</button>
									</div>

								</form>

							</div>
						</div>
					</div>

					<script>
						$(document).ready(function() {
						
						$(".input-mask").inputmask();
						});
						$('#table-anggaran').on('click', '.delete-anggaran', function (e) {
						e.preventDefault();
						
						let id = $(this).data('id');
						
						Swal.fire({
						title: 'Hapus data?',
						text: 'Data anggaran akan dihapus!',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#d33',
						cancelButtonColor: '#6c757d',
						confirmButtonText: 'Ya, Hapus',
						cancelButtonText: 'Batal'
						}).then((result) => {
						
						if (result.isConfirmed) {
						
						$.ajax({
						url: '/anggaran/delete-anggaran/' + id,
						type: 'DELETE',
						headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						success: function () {
						
						Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
						
						loadData(); // reload ajax table
						},
						error: function () {
						Swal.fire('Error!', 'Data gagal dihapus.', 'error');
						}
						});
						
						}
						
						});

						});
						
						$('#formAnggaran').submit(function(e){
						
						e.preventDefault();
						
						let form = $(this);
						let data = form.serialize();
						
						Swal.fire({
						title: 'Simpan data?',
						text: "Anggaran akan disimpan",
						icon: 'question',
						showCancelButton: true,
						confirmButtonText: 'Ya Simpan',
						cancelButtonText: 'Batal'
						}).then((result) => {
						
						if (result.isConfirmed) {
						
						$.ajax({
						url: "{{ route('anggaran.anggaran.store') }}",
						type: "POST",
						data: data,
						beforeSend: function(){
						Swal.fire({
						title: 'Menyimpan...',
						allowOutsideClick: false,
						didOpen: () => {
						Swal.showLoading()
						}
						});
						},
						success: function(res){
						
						Swal.fire({
						icon: 'success',
						title: 'Berhasil',
						text: res.message,
						timer: 1500,
						showConfirmButton: false
						});
						
						$('#ModalAnggaran').modal('hide');
						$('#formAnggaran')[0].reset();
						
						loadData();

						},
						error: function(xhr){
						
						
							let message = 'Terjadi kesalahan';
							
							if(xhr.status === 422){
							
							// validasi laravel
							if(xhr.responseJSON.message){
							message = xhr.responseJSON.message;
							}
							
							// jika ada banyak error
							if(xhr.responseJSON.errors){
							
							let errors = Object.values(xhr.responseJSON.errors)
							.map(e => e[0])
							.join('\n');
							
							message = errors;
							}
							
							}
							
							Swal.fire({
							icon: 'warning',
							title: 'Validasi gagal',
							text: message
							});

						
						}
						});
						
						}
						
						});
						
						});
					</script>

				</div>
				<div class="tab-pane fade" id="tab3" role="tabpanel">
					@can('project.create')
					<div>
						<button class="btn btn-sm btn-primary" data-bs-toggle="modal"
							data-bs-target="#ModalRealisasiAnggaran" id="btnModalRealisasiAnggaran">
							<i class="fa fa-plus"></i> Tambah Realisasi Anggaran</button>
					</div>
					<hr>
					@endcan
					<div class="table-responsive">
						<table class="table table-sm" id="table-realisasi-anggaran">
							<thead class="table-dark">
								<th>No</th>
								<th>Tannggal</th>
								<th>Sub Pekerjaan</th>
								<th>Jenis</th>
								<th>Nilai</th>
								<th>Keterangan</th>
								<th>Opsi</th>
							</thead>
							<tbody>
								@php $n = 1 @endphp
								@foreach($anggaran_realisasi as $ag)
								<tr>
									<td>{{ $n++ }}</td>
									<td>{{ tanggalIndo($ag->tanggal ?? '-') }}</td>
									<td>{{ $ag->subPekerjaan?->judul ?? '-'}}</td>
									<td>{{ $ag->jenis}}</td>
									<td>{{ number_format($ag->nilai_realisasi,0) }}</td>
									<td>{{ $ag->keterangan }}</td>
									<td>
										@can('project.delete')
										<button type="button" class="btn btn-sm btn-danger delete-realisasi-anggaran"
											data-id="{{ $ag->id }}">
											<i class="fa fa-trash"></i>
										</button>
										@endcan
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="modal fade" id="ModalRealisasiAnggaran" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-centered">
							<div class="modal-content">

								<div class="modal-header">
									<h5 class="modal-title">Input Realisasi Anggaran</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
								</div>

								<form id="formRealisasiAnggaran">
									@csrf
									<input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id }}">
									<input type="hidden" name="sub_kegiatan_id"
										value="{{ $pekerjaan->sub_kegiatan_id }}">
									<div class="modal-body">

										<div class="row">

											<div class="col-md-12 mb-3">
												<label class="form-label">Sub Pekerjaan</label>
												<select name="sub_pekerjaan_id" class="form-select" required>
													<option value="">-- Pilih --</option>
													@foreach($sub_pekerjaans as $row)
													<option value="{{ $row->id }}">
														{{ $row->judul }}
													</option>
													@endforeach
												</select>
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Tanggal</label>
												<input type="date" name="tanggal" class="form-control" required>
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Jenis Pembayaran</label>
												<select name="jenis" class="form-select" required>
													<option value="">-- pilih --</option>
													<option value="Uang Muka">Uang Muka</option>
													<option value="Termin">Termin</option>
													<option value="SP2D">SP2D</option>
													<option value="Retensi">Retensi</option>
												</select>
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Termin Ke</label>
												<input type="number" name="termin_ke" class="form-control"
													placeholder="contoh: 1">
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Nomor Dokumen</label>
												<input type="text" name="nomor_dokumen" class="form-control"
													placeholder="No SP2D / SPM / BAST">
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Nilai Pembayaran</label>

												<input type="text" id="amount"
													class="form-control input-mask text-start rupiah"
													name="nilai_realisasi" required value="0" data-inputmask="'alias':'numeric',
													            						                        'groupSeparator':'.',
													            						                        'radixPoint':',',
													            						                        'digits':0,
													            						                        'autoGroup':true,
													            						                        'prefix':'Rp ',
													            						                        'placeholder':'0',
													            						                        'removeMaskOnSubmit':true">
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Sumber Dana</label>
												<select name="sumber_dana" class="form-select">
													<option value="APBD">APBD</option>
													<option value="DAK">DAK</option>
													<option value="Banprov">Banprov</option>
												</select>
											</div>

											<div class="col-md-12 mb-3">
												<label class="form-label">Keterangan</label>
												<textarea name="keterangan" class="form-control"></textarea>
											</div>

										</div>

									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-secondary"
											data-bs-dismiss="modal">Tutup</button>

										<button type="submit" class="btn btn-success">
											Simpan
										</button>
									</div>

								</form>

							</div>
						</div>
					</div>
					<script>
						$('#table-realisasi-anggaran').on('click', '.delete-realisasi-anggaran', function (e) {
							e.preventDefault();
							
							let id = $(this).data('id');
							
							Swal.fire({
							title: 'Hapus data?',
							text: 'Data realisasi anggaran akan dihapus!',
							icon: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#d33',
							cancelButtonColor: '#6c757d',
							confirmButtonText: 'Ya, Hapus',
							cancelButtonText: 'Batal'
							}).then((result) => {
							
							if (result.isConfirmed) {
							
								$.ajax({
									url: '/anggaran/delete-realisasi/' + id,
									type: 'DELETE',
									headers: {
										'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									},
									success: function () {
									
										Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
									
										loadData(); // reload ajax table
									},
									error: function () {
										Swal.fire('Error!', 'Data gagal dihapus.', 'error');
									}
									});
								
								}
								
								});
								
							});

							$('#formRealisasiAnggaran').submit(function(e){
							
							e.preventDefault();
							
							let form = $(this);
							let data = form.serialize();
							
							Swal.fire({
							title: 'Simpan data?',
							text: "Realisasi anggaran akan disimpan",
							icon: 'question',
							showCancelButton: true,
							confirmButtonText: 'Ya Simpan',
							cancelButtonText: 'Batal'
							}).then((result) => {
							
							if (result.isConfirmed) {
							
							$.ajax({
							url: "{{ route('anggaran.realisasi.store') }}",
							type: "POST",
							data: data,
							beforeSend: function(){
							Swal.fire({
							title: 'Menyimpan...',
							allowOutsideClick: false,
							didOpen: () => {
							Swal.showLoading()
							}
							});
							},
							success: function(res){
							
							Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							text: res.message,
							timer: 1500,
							showConfirmButton: false
							});
							
							$('#ModalRealisasiAnggaran').modal('hide');
							$('#formRealisasiAnggaran')[0].reset();
							
							loadData();
							
							},
							error: function(xhr){
							
							
							let message = 'Terjadi kesalahan';
							
							if(xhr.status === 422){
							
							// validasi laravel
							if(xhr.responseJSON.message){
							message = xhr.responseJSON.message;
							}
							
							// jika ada banyak error
							if(xhr.responseJSON.errors){
							
							let errors = Object.values(xhr.responseJSON.errors)
							.map(e => e[0])
							.join('\n');
							
							message = errors;
							}
							
							}
							
							Swal.fire({
							icon: 'warning',
							title: 'Validasi gagal',
							text: message
							});
							
							
							}
							});
							
							}
							
							});
							
							});

					</script>


				</div>
			</div>



			<script>
				$(document).ready(function(){
						$(document).on('click', '.btn-delete-sub-pekerjaan', function () {
									let id = $(this).data('id');
		
									Swal.fire({
										title: "Delete this data?",
										text: "This action cannot be undone.",
										icon: "warning",
										showCancelButton: true,
										confirmButtonText: "Yes, delete it!",
									}).then((result) => {
										if (result.isConfirmed) {
		
											$.ajax({
												url: "/ajax/sub-pekerjaan/delete/" + id,
												type: "DELETE",
												data: {
													_token: "{{ csrf_token() }}"
												},
												success: function (res) {
													if (res.success) {
														toastr.clear();
														 toastr.success("Data berhasil dihapus");
														
														loadData(); 
								
													}
												},
												error: function (err) {
													console.log(err);
													Swal.fire("Error", "Cannot delete data", "error");
												}
											});
		
										}
									});
							});
					});
			</script>

		</div>
	</div>

</div>

<div class="tab-pane" id="pengawasan" role="tabpanel">

	<ul class="nav nav-pills bg-light  mb-3" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-bs-toggle="tab" href="#buy-tab" role="tab" aria-selected="true">Pos
				Pengawasan</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-bs-toggle="tab" href="#sell-tab" role="tab" aria-selected="false">Laporan
				Pengawasan</a>
		</li>
	</ul>

	<div class="tab-content mt-4" style="min-height: 340px;">
		<div class="tab-pane active" id="buy-tab" role="tabpanel">
			<div class="mb-1">
				<h5 class="card-title">
					Penanggunjawab (Pengawas)</h5>
				<div id="opd_pengawas">
					<table class="table table-sm">
						<tr>
							<td width="20%">Pengawas Lapangan</td>
							<td width="1%">:</td>
							<td>
								{{ $pekerjaan->opdPengawas->name ?? '-' }}
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="mb-1">
				<h5 class="card-title mb-3">

					<i class="fa fa-map"></i> Lokasi Pos Pengawasan
				</h5>
			</div>

			@canany(['project.create', 'project.edit'])
			<div class="mt-2">
				@if ($sub_pekerjaans_pos)
				@if($pekerjaan->status_progress == 'draft')
				<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#mapModal"
					id="btnShowMap">
					<i class="fa fa-tag"></i> Tambah Pos Pengawasan
				</button>
				@endif
				@endif
			</div>
			@endcanany
			<div class="row">
				<div class="col-md-8">
					<div class="shadow shadow-sm  mt-2">
						<div id="map-pengawas" class="border border-secondary rounded-3" style="min-height: 600px; ">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card shadow shadow-sm border border-secondary table-responsive rounded-3 mt-2"
						style="min-height: 600px;">
						<div class='card-body'>
							<table class="table table-sm align-middle table-nowrap mt-3">
								<thead class="table-dark">
									<tr>
										<th scope="col">Lokasi Pengawasan</th>
										<th>Sub Pekerjaan</th>
										@canany(['project.delete'])
										<th scope="col">Action</th>
										@endcanany
									</tr>
								</thead>
								<tbody>
									@foreach($pos_pengawas as $p)


									<tr>

										<td>
											<h4 class="font-size-13 text-truncate mb-1">
												<a href="javascript: void(0);" class="text-dark">{{ $p->nm_pos}}</a>
											</h4>

											<p class="text-muted mb-0">{{ $p->nm_lokasi }}</p>
										</td>
										<td>{{ $p->subPekerjaan->judul ?? ''}}</td>

										<?php 
									//dd($p->subPekerjaan);
									?>
										@canany(['project.delete'])
										<td width="5%">
											@if($p->subPekerjaan->status_progress ?? '' == 'menunggu_mulai')
											<div class="dropdown">
												<a class="text-muted font-size-16" role="button"
													data-bs-toggle="dropdown" aria-haspopup="true">
													<i class="mdi mdi-dots-horizontal"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a class="dropdown-item delete-pos-pengawas"
														href="javascript:void(0);" data-id="{{ $p->id }}"><i
															class="fa fa-trash"></i> Delete</a>
													<a class="dropdown-item update-pos-pengawas"
														href="javascript:void(0);" data-id="{{ $p->id }}"
														data-sub_pekerjaan_id="{{ $p->subPekerjaan->id ?? '0' }}"
														data-nm_sub_pekerjaan="{{ $p->subPekerjaan->judul ?? '-' }}"
														data-nm_pos="{{ $p->nm_pos }}"
														data-nm_lokasi="{{ $p->nm_lokasi }}"
														data-pos_latitude="{{ $p->latitude }}"
														data-pos_longitude="{{ $p->longitude }}"
														data-polyline="{{ $p->polyline }}"><i class="fa fa-pencil"></i>
														Edit</a>

												</div>
											</div>
											@else
											<span>🔒</span>
											@endif
										</td>
										@endcanany
									</tr>

									@endforeach

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="tab-pane" id="sell-tab" role="tabpanel">

			<div class="me-2">
				<h5 class="card-title mb-4">Laporan Pengawasan</h5>
			</div>

			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3" id="gallery">
				@foreach($histori_pengawasan as $row)
				<div class="col">
					<div class="card h-100 shadow shadow-sm border rounded">

						<!-- FOTO -->
						<div class="position-relative overflow-hidden" style="height:220px;">
							<img src="{{ $row->foto_url ? asset($row->foto_url) : asset('assets/images/no-image.png') }}"
								class="card-img-top img-cover" alt="Foto Pengawasan">
						</div>

						<!-- BODY -->
						<div class="card-body p-3">
							<h5 class="card-title text-truncate">
								{{ $row->subPekerjaan->judul ?? '-' }}
							</h5>

							<p class="text-muted small mb-1">
								<strong>Pos Pengawasan:</strong> {{ $row->posPengawasan->nm_pos ?? '-' }}
							</p>
							<p class="text-muted small mb-1">
								<strong>Lokasi:</strong> {{ $row->posPengawasan->nm_lokasi ?? '-' }}
							</p>

							<p class="text-sm mb-2">
								<strong>Kondisi:</strong>
								{{ Str::limit($row->kondisi_lapangan ?? '-', 100) }}
							</p>

							<div class="d-flex justify-content-between">
								<span class="badge bg-primary">
									Progress: {{ $row->progres_persentase ?? 0 }}%
								</span>
								<small class="text-muted">
									{{ $row->waktu_pengawasan }}
								</small>
							</div>
						</div>

						<!-- FOOTER -->
						<div class="card-footer bg-white border-top-0 pt-2">
							<div class="d-flex justify-content-between align-items-center">
								<small class="text-muted small">
									[{{ $row->latitude }}, {{ $row->longitude }}]
								</small>
								<div class="dropdown">
									<a class="text-secondary fs-5" role="button" data-bs-toggle="dropdown">
										<i class="mdi mdi-dots-horizontal"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-end">
										@can('pengawasan.delete')
										<li>
											<a class="dropdown-item text-danger btn-delete" href="#"
												data-id="{{ $row->id }}">
												Hapus
											</a>
										</li>
										@endcan
										<li>
											<a href="#" class="dropdown-item text-info btn-view"
												data-href="{{ $row->foto_url ? asset($row->foto_url) : asset('assets/images/no-image.png') }}"
												data-id="{{ $row->id }}">
												Lihat Foto
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

					</div>
				</div>
				@endforeach
			</div>


		</div>
	</div>





	<div class="modal fade" id="modalViewImage" tabindex="-1">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title">Foto Pengawasan</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<div class="modal-body text-center">
					<img src="" id="viewImage" class="img-fluid rounded" style="max-height:70vh;">
				</div>

			</div>
		</div>
	</div>

	<script>
		document.addEventListener("click", function(e) {
				    const btn = e.target.closest(".btn-view");
				    if (!btn) return;
				
				    e.preventDefault();
				
				    const imgUrl = btn.getAttribute("data-href");
				
				    document.getElementById("viewImage").src = imgUrl;
				
				    const modal = new bootstrap.Modal(document.getElementById('modalViewImage'));
				    modal.show();
				});
	</script>





	<div class="modal fade" id="mapModal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">


				<form id="formLokasiPosPengawas" method="POST"
					action="{{ route('kegiatan.pekerjaan.sub-pekerjaan.save-pos-pengawas') }}"
					class="modal-content needs-validation" novalidate>
					<div class="modal-header">
						<h5 class="modal-title">Input Lokasi Pengawasan</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
					</div>

					@csrf
					<input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id ?? 0}}">
					<input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id ?? 0}}">

					<div class="modal-body">
						<div class="mb-1">
							<label for="nm_pos" class="form-label">Nama Sub Pekerjaan <span
									class="text-danger">*</span></label>
							<select class="form-control select2" id="sub_pekerjaan_id" name="sub_pekerjaan_id" required>
								@foreach($sub_pekerjaans_pos as $sp)
								<option value="{{ $sp->id }}">{{ $sp->judul }}</option>
								@endforeach
							</select>
							<div class="invalid-feedback error-sub_pekerjaan_id" data-field="sub_pekerjaan_id">
							</div>
						</div>
						<!-- contoh input: nama -->
						<div class="mb-1">
							<label for="nm_pos" class="form-label">Nama Pos Pengawasan <span
									class="text-danger">*</span></label>
							<input type="text" class="form-control" id="nm_pos" name="nm_pos" required minlength="3">
							<div class="invalid-feedback error-nm_pos" data-field="nm_pos"></div>
						</div>

						<div class="mb-1">
							<label for="nm_lokasi" class="form-label">Lokasi/Alamat <span
									class="text-danger">*</span></label>
							<input type="text" class="form-control" id="nm_lokasi" name="nm_lokasi" required
								minlength="3">
							<div class="invalid-feedback error-nm_lokasi" data-field="nm_lokasi"></div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<label for="pos_latitude" class="form-label">Latitude</label>
								<input type="text" class="form-control" value="{{ $pekerjaan->latitude }}"
									name="pos_latitude" id="pos_latitude" readonly>
								<div class="invalid-feedback error-pos_latitude" data-field="pos_latitude">
								</div>
							</div>
							<div class="col-md-4">
								<label for="pos_longitude" class="form-label">Longitude</label>
								<input type="text" class="form-control" value="{{ $pekerjaan->longitude }}"
									name="pos_longitude" id="pos_longitude" readonly>
								<div class="invalid-feedback error-pos_longitude" data-field="pos_longitude">
								</div>
							</div>
							<div class="col-md-4">
								<label for="radiusInput" class="form-label">Radius (meter)</label>
								<input type="number" class="form-control" value="10" name="radiusInput"
									id="radiusInput">
								<div class="invalid-feedback error-radiusInput" data-field="radiusInput"></div>
							</div>

						</div>
						<!-- contoh input: deskripsi -->
						<div class="alert alert-info mt-2" id="statusx">Status: ready</div>


						<div id="mapX"
							style="height:400px;width:100%; border: 1px solid #000; border-radius: 10px;box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
						</div>
					</div>

					<div class="modal-footer d-flex w-100 justify-content-between">

						<!-- KIRI -->
						<div>
							<button class="btn btn-secondary btn-sm" type="button" id="btnBuffer">Tampilkan
								Buffer</button>
							<button class="btn btn-secondary btn-sm" type="button" id="btnClearBuffer">Hapus
								Buffer</button>
						</div>

						<!-- KANAN -->
						<div>
							<button type="button" class="btn btn-secondary btn-sm"
								data-bs-dismiss="modal">Batal</button>
							<button type="submit" id="submitBtn" class="btn btn-primary btn-sm">
								<span id="submitLabel">Simpan</span>
								<span id="submitSpinner" class="spinner-border spinner-border-sm ms-2 d-none"
									role="status"></span>
							</button>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>


	<div class="modal fade" id="updatePos" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<form id="formUpdateLokasiPosPengawas" method="POST"
					action="{{ route('kegiatan.pekerjaan.sub-pekerjaan.update-pos-pengawas') }}"
					class="needs-validation" novalidate>

					@csrf
					<input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id ?? 0}}">
					<input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id ?? 0}}">
					<input type="hidden" name="pos_id" id="edit-pos_id">

					<input type="hidden" id="edit-polyline" name="polyline">

					<div class="modal-header">
						<h5 class="modal-title">Edit Lokasi Pengawasan</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>

					<div class="modal-body">

						<div class="mb-2">
							<label class="form-label">Nama Sub Pekerjaan</label>
							<p id="edit-nm_sub_pekerjaan" class="fw-bold mb-0"></p>
						</div>

						<div class="mb-2">
							<label class="form-label">Nama Pos Pengawasan</label>
							<input type="text" class="form-control" id="edit-nm_pos" name="nm_pos" required>
							<div class="invalid-feedback error-nm_pos"></div>
						</div>

						<div class="mb-2">
							<label class="form-label">Lokasi / Alamat</label>
							<input type="text" class="form-control" id="edit-nm_lokasi" name="nm_lokasi" required>
							<div class="invalid-feedback error-nm_lokasi"></div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<label class="form-label">Latitude</label>
								<input type="text" class="form-control" name="pos_latitude" id="edit-pos_latitude"
									readonly>
							</div>
							<div class="col-md-4">
								<label class="form-label">Longitude</label>
								<input type="text" class="form-control" name="pos_longitude" id="edit-pos_longitude"
									readonly>
							</div>
							<div class="col-md-4">
								<label class="form-label">Radius (meter)</label>
								<input type="number" class="form-control" name="radius" id="edit-radius">
							</div>
						</div>

						<div class="alert alert-info mt-2" id="statusx">
							Status: ready
						</div>

						<div id="mapZ" style="height:400px;width:100%;"></div>

					</div>

					<div class="modal-footer d-flex justify-content-between">
						<div>
							<button class="btn btn-secondary btn-sm" type="button" id="btnBufferZ">
								Tampilkan Buffer
							</button>
							<button class="btn btn-secondary btn-sm" type="button" id="btnClearBufferZ">
								Hapus Buffer
							</button>
						</div>

						<div>
							<button type="button" class="btn btn-secondary btn-sm"
								data-bs-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-primary btn-sm">
								Simpan
							</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
	    $('#formUpdateLokasiPosPengawas').on('submit', function(e) {
	        e.preventDefault(); // cegah submit default
	
	        let form = this;
	        let formData = new FormData(form);
	
	        // Konfirmasi Swal
	        Swal.fire({
	            title: 'Apakah Anda yakin?',
	            text: "Data lokasi akan disimpan!",
	            icon: 'warning',
	            showCancelButton: true,
	            confirmButtonColor: '#3085d6',
	            cancelButtonColor: '#d33',
	            confirmButtonText: 'Ya, simpan!',
	            cancelButtonText: 'Batal'
	        }).then((result) => {
	            if (result.isConfirmed) {
	
	                // Kirim AJAX
	                $.ajax({
	                    url: $(form).attr('action'),
	                    type: $(form).attr('method'),
	                    data: formData,
	                    processData: false,
	                    contentType: false,
	                    success: function(response) {
	
	                        Swal.fire({
	                            title: 'Berhasil!',
	                            text: 'Data lokasi berhasil disimpan.',
	                            icon: 'success',
	                            timer: 2000,
	                            showConfirmButton: false
	                        });
	
	                        // Tutup modal
	                        $('#updatePos').modal('hide');
	
	                        // Opsional: refresh table / marker
	                        if(typeof reloadTable === 'function') loadData();
	                    },
	                    error: function(xhr) {
	                        let msg = "Terjadi kesalahan!";
	                        if(xhr.responseJSON && xhr.responseJSON.message) {
	                            msg = xhr.responseJSON.message;
	                        }
	
	                        Swal.fire({
	                            title: 'Gagal!',
	                            text: msg,
	                            icon: 'error'
	                        });
	                    }
	                });
	            }
	        });
	    });
	});
	</script>

	<script>
		let mapZ = null;
	let markerZ = null;
	let circleZ = null;
	
	let drawnItemsZ = null;
	let currentPolylineZ = null;
	let bufferLayerZ = null;
	let pointMarkerZ = null;
	
	document.addEventListener("click", function(e) {
	
	    if (e.target.closest(".update-pos-pengawas")) {
	
	        let btn = e.target.closest(".update-pos-pengawas");
	
	        // =========================
	        // AMBIL DATA
	        // =========================
	        let id = btn.dataset.id;
	        let nmSub = btn.dataset.nm_sub_pekerjaan;
	        let nmPos = btn.dataset.nm_pos;
	        let nmLokasi = btn.dataset.nm_lokasi;
	        let lat = parseFloat(btn.dataset.pos_latitude) || -6.84;
	        let lng = parseFloat(btn.dataset.pos_longitude) || 107.59;
	        let polyline = btn.dataset.polyline || "";
	        let radius = parseInt(btn.dataset.radius) || 10;
	
	        let centerLat = lat;
	        let centerLng = lng;
	
	        // =========================
	        // SET KE MODAL
	        // =========================
	        document.getElementById("edit-pos_id").value = id;
	        document.getElementById("edit-nm_sub_pekerjaan").innerText = nmSub;
	        document.getElementById("edit-nm_pos").value = nmPos;
	        document.getElementById("edit-nm_lokasi").value = nmLokasi;
	        document.getElementById("edit-pos_latitude").value = lat;
	        document.getElementById("edit-pos_longitude").value = lng;
	        document.getElementById("edit-radius").value = radius;

			let polyInput = document.getElementById("edit-polyline");
			if (polyInput) {
			polyInput.value = polyline;
			}
			
	        let modalElement = document.getElementById('updatePos');
	        let modal = new bootstrap.Modal(modalElement);
	        modal.show();
	
	        // =========================
	        // SAAT MODAL TERBUKA
	        // =========================
	        modalElement.addEventListener('shown.bs.modal', function () {
	
	            if (mapZ !== null) {
	                mapZ.remove();
	                mapZ = null;
	            }
	
	            // INIT MAP
	            mapZ = L.map('mapZ').setView([centerLat, centerLng], 13);
	
	            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	                attribution: '&copy; OpenStreetMap contributors'
	            }).addTo(mapZ);
	
	            // MARKER
	            markerZ = L.marker([lat, lng], { draggable: true }).addTo(mapZ);
	
	            // CIRCLE
	            circleZ = L.circle([lat, lng], {
	                radius: radius,
	                color: 'blue',
	                fillOpacity: 0.2
	            }).addTo(mapZ);
	
	            markerZ.on('dragend', function () {
	                let pos = markerZ.getLatLng();
	                updatePosition(pos.lat, pos.lng);
	            });
	
	            mapZ.on('click', function(e) {
	                updatePosition(e.latlng.lat, e.latlng.lng);
	            });
	
	            function updatePosition(lat, lng) {
	                markerZ.setLatLng([lat, lng]);
	                circleZ.setLatLng([lat, lng]);
	
	                document.getElementById("edit-pos_latitude").value = lat.toFixed(6);
	                document.getElementById("edit-pos_longitude").value = lng.toFixed(6);
	            }
	
	            document.getElementById("edit-radius").addEventListener("input", function() {
	                let newRadius = parseInt(this.value) || 0;
	                circleZ.setRadius(newRadius);
	            });
	
	            // =========================
	            // DRAW POLYLINE SETUP
	            // =========================
	            drawnItemsZ = new L.FeatureGroup().addTo(mapZ);
	
	            let drawControl = new L.Control.Draw({
	                draw: {
	                    polyline: true,
	                    marker: false,
	                    polygon: false,
	                    rectangle: false,
	                    circle: false,
	                    circlemarker: false
	                },
	                edit: {
	                    featureGroup: drawnItemsZ,
	                    remove: true
	                }
	            });
	
	            mapZ.addControl(drawControl);
	
	            // =========================
	            // LOAD POLYLINE JIKA ADA
	            // =========================
	            if (polyline && polyline !== "" && polyline !== "null") {
	                try {
	                    let latlngs = JSON.parse(polyline);
	
	                    if (Array.isArray(latlngs) && latlngs.length > 0) {
	                        currentPolylineZ = L.polyline(latlngs, {
	                            color: 'red',
	                            weight: 4
	                        });
	
	                        drawnItemsZ.addLayer(currentPolylineZ);
	                        mapZ.fitBounds(currentPolylineZ.getBounds());
	                    }
	
	                } catch (err) {
	                    console.error("Format polyline tidak valid:", err);
	                }
	            }
	
	            // =========================
	            // SAAT BUAT POLYLINE
	            // =========================
	            mapZ.on(L.Draw.Event.CREATED, function (e) {
	
	                drawnItemsZ.clearLayers();
	                currentPolylineZ = null;
	
	                let layer = e.layer;
	                drawnItemsZ.addLayer(layer);
	
	                if (layer instanceof L.Polyline) {
	                    currentPolylineZ = layer;
	                    savePolylineToInput(layer);
	                }
	            });
	
	            // =========================
	            // SAAT EDIT
	            // =========================
	            mapZ.on('draw:edited', function (e) {
	                e.layers.eachLayer(function (layer) {
	                    if (layer instanceof L.Polyline) {
	                        savePolylineToInput(layer);
	                    }
	                });
	            });
	
	            // =========================
	            // SAAT HAPUS
	            // =========================
	            mapZ.on('draw:deleted', function () {
	                currentPolylineZ = null;
	                document.getElementById("edit-polyline").value = "";
	            });
	
	            // FIX SIZE MAP
	            setTimeout(() => {
	                mapZ.invalidateSize();
	            }, 300);
	
	        }, { once: true });
	    }
	});
	
	// =========================
	// SIMPAN POLYLINE KE INPUT
	// =========================
	function savePolylineToInput(layer) {
	let latlngs = layer.getLatLngs();
	let formatted = latlngs.map(p => [p.lat, p.lng]);
	
	let polyInput = document.getElementById("edit-polyline");
	if (polyInput) {
	polyInput.value = JSON.stringify(formatted);
	}
	
}

// BUFFER
document.getElementById("btnBufferZ").onclick = () => {
if (!currentPolylineZ) return updateStatus("Buat polyline dulu");

let radius = Number(document.getElementById("edit-radius").value);

let coords = currentPolylineZ.getLatLngs().map(pt => [pt.lng, pt.lat]);
let buff = turf.buffer(turf.lineString(coords), radius, { units:"meters" });

if (bufferLayerZ) mapZ.removeLayer(bufferLayerZ);

bufferLayerZ = L.geoJSON(buff, {
style:{ color:"orange", weight:2, fillOpacity:.2 }
}).addTo(mapZ);

mapZ.fitBounds(bufferLayerZ.getBounds());


};

document.getElementById("btnClearBufferZ").onclick = () => {
if (bufferLayerZ) mapZ.removeLayer(bufferLayerZ);
bufferLayerZ = null;
};

	</script>


	<script>
		$(document).ready(function(){
				$(document).off('click', '.btnSubmitUpdateSubPekerjaan')
							.on('click', '.btnSubmitUpdateSubPekerjaan', function (e) {
								e.preventDefault();
								let button = $(this);
								let modal = $(this).closest('.modal');    // ambil modal terdekat
								let form = modal.find('form');            // ambil form dalam modal tsb
								let id = modal.attr('id').replace('modalEditSubPekerjaan', ''); // ambil angka ID
		
								let formData = form.serialize();
								clearErrors(form);
		
								// SAFETY: cegah double submit
								if (button.data('submitting')) return;
								button.data('submitting', true).prop('disabled', true);
		
							$.ajax({
								url: "/ajax/sub-pekerjaan/update/" + id,
								type: "PUT",
								data: formData,
								success: function(res) {
									if (typeof loadData === "function") {
										Swal.fire({
										icon: 'success',
										title: 'Berhasil',
										text: 'Data berhasil disimpan',
										timer: 1500,
										showConfirmButton: false,
										confirmButtonText: 'OK'
										}).then((result) => {
											modal.modal('hide'); // tutup modal
											loadData();	
										 
										});	
									}
								},
								error: function(xhr) {
									if (xhr.status === 422) {
									toastr.error('Terjadi kesalahan server');
									let errors = xhr.responseJSON.errors;
									
									$.each(errors, function (field, messages) {
									let input = form.find(`[name="${field}"]`);
									
									if (!input.length) return;
									
									input.addClass('is-invalid');
									
									input.closest('.mb-3, .col-md-6')
									.find('.invalid-feedback')
									.html(messages[0]);
									});
									
									} else {
									toastr.error('Terjadi kesalahan server');
									}
									console.log(xhr);
									// Swal.fire({
									// 	icon: 'error',
									// 	title: 'Gagal menyimpan'
									// });
								},
								
								
								complete: function () {
								button.data('submitting', false).prop('disabled', false);
								}
							});
						});
						function clearErrors(form) {
						form.find('.is-invalid').removeClass('is-invalid');
						form.find('.invalid-feedback').html('');
						}
	});
	</script>

	<script>
		//let markerX;
if (typeof markerX === "undefined") {
    var markerX = null;
}
if (typeof marker === "undefined") {
    var marker = null;
}

if (typeof circleX === "undefined") {
var circleX = null;
}

if (typeof markerPos === "undefined") {
    var markerPos = null;
}
if (typeof markerPengawas === "undefined") {
    var markerPengawas = null;

}


document.getElementById('mapModal').addEventListener('shown.bs.modal', function () {
	// DELETE MAP JIKA SUDAH ADA (antisipasi reload AJAX)
    if (mapX) {
        mapX.remove();
        mapX = null;
		if (typeof pointMarker === "undefined") {
			var pointMarker = null;
		}
    }
    if (!mapX) {

        let defaultLat = -6.84;
        let defaultLng = 107.59;

        let centerLat = projectLat !== null ? projectLat : defaultLat;
        let centerLng = projectLng !== null ? projectLng : defaultLng;

        // ✅ MODE READ ONLY
        mapX = L.map('mapX', {
            dragging: true,
            zoomControl: true,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            boxZoom: true,
            keyboard: true,
            tap: true,
            touchZoom: true
        }).setView([centerLat, centerLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(mapX);

		let radius = 100; // meter
		
		circleX = L.circle([centerLat, centerLng], {
		radius: radius,
		color: 'red',
		fillColor: '#f03',
		fillOpacity: 0.3
		}).addTo(mapX);

 
		placePointMarkerX(centerLat, centerLng);
		// Layer tempat polyline & marker
					drawnItems = new L.FeatureGroup().addTo(mapX);
					
					// Draw control
					drawControl = new L.Control.Draw({
						draw: {
							polyline: true,
							marker: false,
							polygon: false,
							rectangle: false,
							circle: false,
							circlemarker: false,
						},
						edit: {
							featureGroup: drawnItems,
							remove: true
						}
					});

					mapX.addControl(drawControl);

					// ============================
					// EVENT: Polyline dibuat
					// ============================
					mapX.on(L.Draw.Event.CREATED, function (e) {
						let layer = e.layer;

						drawnItems.clearLayers();
						if (bufferLayer) { mapX.removeLayer(bufferLayer); bufferLayer = null; }

						drawnItems.addLayer(layer);

						if (layer instanceof L.Polyline) {
							currentPolyline = layer;
						}
					});

					// EVENT: Edit polyline
					mapX.on('draw:edited', function () {
						if (bufferLayer) { mapX.removeLayer(bufferLayer); bufferLayer = null; }
					});

					// EVENT: Hapus polyline
					mapX.on('draw:deleted', function () {
						currentPolyline = null;
						if (bufferLayer) { mapX.removeLayer(bufferLayer); bufferLayer = null; }
					});



					mapX.on('click', function (e) {
						placePointMarkerX(e.latlng.lat, e.latlng.lng);
					});
					
					
    }


		function placePointMarkerX(lat, lng) {

			// jika marker sudah ada → pindahkan saja
			if (pointMarker) {

				pointMarker.setLatLng([lat, lng]);

				if (circleX) {
					circleX.setLatLng([lat, lng]);
				}

			} else {

				pointMarker = L.marker([lat, lng], {
					draggable: true
				}).addTo(mapX);

				// event saat marker digeser
				pointMarker.on('dragend', function (e) {

					let pos = e.target.getLatLng();

					$("#pos_latitude").val(pos.lat.toFixed(6));
					$("#pos_longitude").val(pos.lng.toFixed(6));

					// pindahkan circle ke posisi baru marker
					if (circleX) {
						circleX.setLatLng([pos.lat, pos.lng]);
					}

				});
			}

			// update input
			$("#pos_latitude").val(parseFloat(lat).toFixed(6));
			$("#pos_longitude").val(parseFloat(lng).toFixed(6));
		}

    // Fix agar map tidak blank saat modal tampil
    setTimeout(() => {
        mapX.invalidateSize();
    }, 300);

	document.getElementById('radiusInput').addEventListener('input', function () {
	
	let r = parseFloat(this.value);
	
	if (!isNaN(r) && circleX) {
	circleX.setRadius(r);
	}
	
	});

	// =========================
	// HELPER
	// =========================
	function updateLatLng(lat, lng) {
	$("#pos_latitude").val(lat.toFixed(6));
	$("#pos_longitude").val(lng.toFixed(6));
	}

	function getPopupContent(lat, lng) {
	return `
	<b>Lokasi Project {{ $pekerjaan->nm_pekerjaan }}</b><br>
	Latitude: ${lat.toFixed(6)}<br>
	Longitude: ${lng.toFixed(6)}
	`;
	}
});


	</script>



</div>

<div class="tab-pane" id="dokumen" role="tabpanel">
	<div id="contentDokumen"></div>
	<script>
		$(document).ready(function(){
				loadPageDiv('/ajax/pekerjaan/load-dokumen-pekerjaan/' + {{ $pekerjaan->id }},'#contentDokumen');
			});
	</script>
</div>
<div class="tab-pane" id="peta" role="tabpanel">
	<div style="border: 1px solid #000; border-radius: 10px;box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
		<div id="map" style="height: 600px; width: 100%; border-radius: 12px;"></div>

	</div>
</div>

</div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="modal-lokasi-pengawas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
	data-bs-keyboard="false">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<form id="formLokasiPosPengawas" method="POST"
			action="{{ route('kegiatan.pekerjaan.sub-pekerjaan.save-pos-pengawas') }}"
			class="modal-content needs-validation" novalidate>
			<div class="modal-header">
				<h5 class="modal-title">Input Pos Lokasi Pengawasan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
			</div>

			@csrf
			<input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id ?? 0}}">
			<input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id ?? 0}}">

			<div class="modal-body">


				<div class="mb-1">
					<label for="lokasi" class="form-label">Lokasi Pos Pengawasan </label>

					<div id="mapPosPengawas" style="min-height:300px;"></div>

				</div>

			</div>

			<div class="modal-footer d-flex w-100 justify-content-between">

				<!-- KIRI -->
				<div>
					<button class="btn btn-secondary btn-sm" type="button" id="btnBuffer">Tampilkan Buffer</button>
					<button class="btn btn-secondary btn-sm" type="button" id="btnClearBuffer">Hapus Buffer</button>
				</div>

				<!-- KANAN -->
				<div>
					<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
					<button type="submit" id="submitBtn" class="btn btn-primary btn-sm">
						<span id="submitLabel">Simpan</span>
						<span id="submitSpinner" class="spinner-border spinner-border-sm ms-2 d-none"
							role="status"></span>
					</button>
				</div>

			</div>

		</form>
	</div>
</div>

@php
$status = $pekerjaan->status_progress;
$canEdit = auth()->user()->can('project.edit');
$canApprove = auth()->user()->can('project.approved');
@endphp

<div class="modal fade" id="modalChangeStatus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
	data-bs-keyboard="false">

	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">

			<!-- Header -->
			<div class="modal-header">
				<h5 class="modal-title">Ubah Status Project</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			{{-- ================= ALERT SECTION ================= --}}

			@if($canApprove && $status != 'verifikasi')
			<div class="modal-body">
				<div class="alert alert-warning">
					Belum ada pengajuan verifikasi!
				</div>
			</div>

			@elseif(!$canApprove && $status == 'verifikasi')
			<div class="modal-body">
				<div class="alert alert-warning">
					Menunggu verifikasi dari PPK!
				</div>
			</div>

			{{-- ================= FORM SECTION ================= --}}
			@else

			<form id="formChangeStatus" method="post" action="{{ url('/ajax/pekerjaan/update-status-progress') }}">

				@csrf

				<div class="modal-body">

					<input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id }}">

					<!-- Status -->
					<div class="form-floating mb-3">
						<select class="form-select" name="status" required>
							<option value="" disabled selected>Pilih Status</option>

							{{-- Draft → On Progress --}}
							@if($canEdit && $status == 'draft')
							<option value="on_progress">On Progress</option>
							@endif

							{{-- On Progress → Verifikasi --}}
							@if($canEdit && $status == 'on_progress')
							<option value="verifikasi">Verifikasi</option>
							@endif

							{{-- Verifikasi → Selesai --}}
							@if($canApprove && $status == 'verifikasi')
							<option value="disetujui">Disetujui</option>
							<option value="pending">Pending</option>
							<option value="ditolak">Ditolak</option>

							@endif

						</select>
						<label>
							Status Project <span class="text-danger">*</span>
						</label>
					</div>
					<div class="form-floating mb-3">
						<input type="date" class="form-control" name="end_date" placeholder="Tanggal" required>
						<label>Tanggal (*)</label>
					</div>
					<!-- Catatan -->
					<div class="form-floating mb-3">
						<textarea class="form-control" name="note" style="height: 100px"
							placeholder="Tambahkan catatan"></textarea>
						<label>Catatan (Opsional)</label>
					</div>

				</div>

				<!-- Footer -->
				<div class="modal-footer d-flex justify-content-between">
					<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
						Batal
					</button>

					<button type="submit" class="btn btn-primary btn-sm">
						Simpan
					</button>
				</div>

			</form>

			@endif

		</div>
	</div>
</div>

<script>
	$(document).ready(function() {


	$('.select2').select2();
	
	function loadDokumen(){
	//$('#contentDokumen').load('/pekerjaan/load-dokumen-pekerjaan/' + ${$pekerjaan->id});
	
	}
	
	loadDokumen();

$('#btnSubmitProgress').on('click', function (e) {
e.preventDefault();

let form = $('#formProgress'); // ✅ FIX UTAMA
let formData = form.serialize();

clearErrors(form);

$.ajax({
url: "/ajax/sub-pekerjaan/store",
type: "POST",
data: formData,
dataType: "json",

beforeSend: function () {
$('#btnSubmitProgress')
.prop("disabled", true)
.html("Menyimpan <i class='fa fa-spinner fa-spin'></i>");
},

success: function (res) {
$('#btnSubmitProgress')
.prop("disabled", false)
.html("Simpan");

$('#modalProgress').modal('hide');

toastr.clear();
toastr.success(res.message ?? "Progress berhasil disimpan");

form[0].reset();

// reload data
if (typeof loadData === 'function') {
loadData();
}
},

error: function (xhr) {
$('#btnSubmitProgress')
.prop("disabled", false)
.html("Simpan");

if (xhr.status === 422) {

let errors = xhr.responseJSON.errors;

$.each(errors, function (field, messages) {
let input = form.find(`[name="${field}"]`);

if (!input.length) return;

input.addClass('is-invalid');

input.closest('.mb-3, .col-md-6')
.find('.invalid-feedback')
.html(messages[0]);
});

} else {
toastr.error('Terjadi kesalahan server');
}

console.error(xhr);
}
});
});

function clearErrors(form) {
form.find('.is-invalid').removeClass('is-invalid');
form.find('.invalid-feedback').html('');
}

});
</script>

<script>
	$(document).ready(function() {

    // submit form pencarian
    $('#formCariUser').on('submit', function(e) {
        e.preventDefault();

        let keyword = $('#keywordUser').val().trim();
        if (!keyword) return;

        $('#userList').html('<p class="text-muted">Mencari...</p>');

        $.ajax({
            url: '{{ route("ajax.user.search") }}', // route backend untuk pencarian
            type: 'GET',
            data: { keyword: keyword },
            success: function(res) {

                const users = res.results;
                
                if (users.length === 0) {
                $('#userList').html('<p class="text-danger">User tidak ditemukan</p>');
                return;
                }
                
                let html = '<ul class="list-group">';
                    users.forEach(user => {
                    html += `<li class="list-group-item user-item" data-id="${user.id}" data-name="${user.text}">
                        <strong>${user.text}</strong>
                        <br>
                        <small class="text-muted">${user.opds.join(', ')}</small>
                    </li>`;
                    });
                    html += '</ul>';
                $('#userList').html(html);
            },
            error: function(xhr) {
                $('#userList').html('<p class="text-danger">Terjadi kesalahan, coba lagi.</p>');
            }
        });
    });
    $(document).on('click', '.user-item', function() {
        
        let userId = $(this).data('id');
        let userName = $(this).data('name');
        $('#selectedUserId').val(userId);
        $('#selectedUserName').val(userName);
    });

    
});
</script>

<script>
	$(document).ready(function() {
		
		
	
		$('#myModal').on('shown.bs.modal', function () {

		$('#mySelect').select2({
        dropdownParent: $('#myModal'),

        placeholder: 'Ketik minimal 2 karakter...',
        allowClear: true,
        minimumInputLength: 2,

        ajax: {
            url: '/api/search-user',    // ganti dengan URL API kamu
            dataType: 'json',
            delay: 300,
            cache: true,

            data: function (params) {
                return {
                    q: params.term,       // keyword
                    page: params.page || 1
                };
            },

            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,                // id, text
                    pagination: { more: data.more }      // apakah masih ada halaman berikutnya
                };
            }
        },

        templateResult: function (item) {
            if (item.loading) return item.text;

            return $(`<div>
                <strong>${item.text}</strong><br/>
                <small>${item.desc ?? ''}</small>
            </div>`);
        },

        templateSelection: item => item.text || item.id,
		});
		});		

		$('#submitOPDPengawas').off('click').on('click', function () {

		let selectedId = $('#selectedUserId').val();
		let pekerjaanId = $('#selectedUserId').data('id');
		if (!selectedId) {
			showSwal('error', 'Error', "OPD Pengawas belum dipilih");
			return;
		}

		$.ajax({
			url: '/api/simpan-opd-pengawas',
			type: 'POST',
			data: {
				user_id : selectedId,
				pekerjaan_id : pekerjaanId,
				_token: '{{ csrf_token() }}'
			},
			success: function (res) {
				if(res.status) {
					showSwal('success', 'Berhasil', 'Data berhasil disimpan!', 1500, function() {
						// misal reload data setelah Swal tertutup
						loadData();
					});
				} else {
					showSwal('error', 'Gagal', 'Terjadi kesalahan saat menyimpan data');
				}


			},
			error: function(xhr) {
			let errorMessage = 'Terjadi kesalahan';
			if(xhr.status === 422) {
				const errors = xhr.responseJSON.errors;
				errorMessage = Object.values(errors).map(e => e.join(', ')).join('\n');
			} else if(xhr.responseJSON && xhr.responseJSON.message) {
				errorMessage = xhr.responseJSON.message;
			}
				showSwal('error', 'Error', errorMessage);
			}
		});

		});
		

		function showSwal(type, title, text, timer = null , callback = null)  {
			if (!Swal.isVisible()) { // Cek Swal sudah muncul atau belum
				Swal.fire({
					icon: type,
					title: title,
					text: text,
					timer: timer,
				showConfirmButton: timer ? false : true,
				}).then((result) => {
					// Jika timer selesai atau user klik Swal
					if (callback) {
						callback(result); // Jalankan callback jika ada
					}

				});
			}
		}

		

		let lastTab = localStorage.getItem('lastTab');

		if (lastTab) {
			let tabTrigger = document.querySelector('a[href="'+ lastTab +'"]');

			if (tabTrigger) {
				let tab = new bootstrap.Tab(tabTrigger);
				tab.show();
			}
		}
	
		$('.delete-pos-pengawas').on('click', function(){
			let id = $(this).data('id');

			Swal.fire({
				title: "Yakin ingin menghapus?",
				text: "Data tidak dapat dikembalikan!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Ya, hapus",
				cancelButtonText: "Batal"
			}).then((result) => {
				if (result.isConfirmed) {

					$.ajax({
						url: "{{ route('kegiatan.pekerjaan.sub-pekerjaan.delete-pos-pengawas') }}",
						type: "DELETE",
						data: {
							_token: "{{ csrf_token() }}",
							'id' : id
						},
						success: function (res) {
							Swal.fire({
								icon: 'success',
								title: 'Berhasil',
								text: res.message,
								timer: 1500,
								showConfirmButton: false
							});

							setTimeout(() => {
								loadData();	
							}, 1500);
						},
						error: function(xhr) {
							Swal.fire({
								icon: 'error',
								title: 'Gagal',
								text: xhr.responseJSON.message || "Terjadi kesalahan."
							});
						}
					});

				}
			});	
			
		});
		
		let loading = `<div class="text-center p-5 m-5"><i class="fa fa-spinner fa-spin fa-3x my-3"></i><h5>Loading...</h5></div>`;
		$('.add-lokasi-pengawasan').on('click',function(){
			setTimeout(() => {
				if (mapPos) {
					mapPos.invalidateSize();
				}
			}, 300);
			$('#modal-lokasi-pengawas').modal('show');
	
		});
	
		$('#openModalCreate').on('click', function() {
			$('#ajaxModal').modal('show');
		});
		
		
		$('#formLokasiPosPengawas').on('submit', function(e) {
		 
        e.preventDefault(); // mencegah submit default
		
        let form = $(this);
        let url = form.attr('action');
        let formData = form.serializeArray(); // ambil semua field + csrf
		// Ubah menjadi object key:value
		let payload = {};
			formData.forEach(item => {
			payload[item.name] = item.value;
		});
 
		// Tambahkan polyline
		if (currentPolyline) {
			payload.polyline = currentPolyline.getLatLngs()
				.map(p => [p.lat, p.lng]);
		} else {
			payload.polyline = []; // atau kirim null
		}
		 console.log("DATA DIKIRIM:", payload);
		 
        $.ajax({
            url: url,
            method: 'POST',
            data: JSON.stringify(payload),
			contentType: "application/json",
            success: function(response) {
                // jika sukses
                if(response.status) {
                    // Tutup modal
                    $('#modal-lokasi-pengawas').modal('hide');

                    // Reset form
                    form[0].reset();

                    // Optional: tampilkan notifikasi
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
                }else{
					Swal.fire("Error", "Data belum lengkap!", "error");
				}
            },
            error: function(xhr) {
                // Handle error validation
                let errors = xhr.responseJSON.errors;
                if(errors) {
                    if (xhr.status === 422) {

						let errors = xhr.responseJSON.errors;

						$.each(errors, function (key, value) {
							// Tambah class is-invalid
							$('[name="' + key + '"]').addClass('is-invalid');

							// Tampilkan error di bawah input
							$('.error-' + key).text(value[0]);
						});
						
						Swal.fire("Error", "Data belum lengkap!", "error");
						
                }
                } else {
                    Swal.fire("Error", "Data belum lengkap!", "error");
                }
            }
        });
		});
	
		$('#formTambahPekerjaan').on('submit', function(e) {
        e.preventDefault(); // mencegah submit default

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize(); // ambil semua field + csrf

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                // jika sukses
                if(response.status) {
                    // Tutup modal
                    $('#ajaxModal').modal('hide');

                    // Reset form
                    form[0].reset();

                    // Optional: tampilkan notifikasi
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
                }
            },
            error: function(xhr) {
                // Handle error validation
                let errors = xhr.responseJSON.errors;
                if(errors) {
                    if (xhr.status === 422) {

						let errors = xhr.responseJSON.errors;

						$.each(errors, function (key, value) {
							// Tambah class is-invalid
							$('[name="' + key + '"]').addClass('is-invalid');

							// Tampilkan error di bawah input
							$('.error-' + key).text(value[0]);
						});
						
						Swal.fire("Error", "Data belum lengkap!", "error");
						
                }
                } else {
                    Swal.fire("Error", "Data belum lengkap!", "error");
                }
            }
        });
		});
	
	
	 
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
	 

		let googleStreets = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
			maxZoom: 20,
			subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
		});
		let googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
			maxZoom: 20,
			subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
		});
		
		let googleHybrid2 = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
			maxZoom: 20,
			subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
		});
		
		let openstreet = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			//attribution: '&copy; KBB <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		});
		 
		 if (map) {
			map.remove();
			map = null;
		}
		
		if (mapPengawas) {
				mapPengawas.remove();
				mapPengawas = null;
		}
			
		if (!map) {

        const pospengawas = @json($pos_pengawas);

	
        //
        map = L.map('map', {
			preferCanvas: true,
			layers: [googleHybrid],
		
            dragging: true,
            zoomControl: true,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            boxZoom: true,
            keyboard: true,
            tap: true,
            touchZoom: true
        }).setView([centerLat, centerLng], 17);

   
        // ✅ Marker statis
			if (projectLat !== null && projectLng !== null) {
				marker = L.marker([projectLat, projectLng], {
					draggable: false
				}).addTo(map)
				  .bindPopup(
					`<b>Lokasi Utama : {{ $pekerjaan->nm_pekerjaan }}</b><br>
					 Latitude: ${projectLat}<br>
					 Longitude: ${projectLng}<br>
					 <a href="https://www.google.com/maps?q=${projectLat},${projectLng}" 
				   target="_blank" 
				   class="btn btn-sm btn-info w-100 text-light">
					Buka di Google Maps
				</a>` // adjust as needed
				  ).openPopup();
				 
				// === Circle marker (radius mengikuti zoom) ===
				// let baseSize = projectRad;

				// let circleMarker = L.circle([projectLat, projectLng], {
					// radius: baseSize,
					// color: 'red',
					// fillColor: '#f03',
					// fillOpacity: 0.3
				// }).addTo(map);

				// // Klik radius → buka popup marker
				// circleMarker.on("click", function () {
					// marker.openPopup();      // ⬅⬅ popup marker muncul
				// });

				// Zoom scalable radius
				// map.on("zoom", function () {
					// let zoom = map.getZoom();
					// let newSize = baseSize * (zoom / 14);
					// circleMarker.setRadius(newSize);
				// });
				   
			}
				
			 
		 mapPengawas = L.map('map-pengawas', {
			preferCanvas: true,
			layers: [googleStreets],
		
            dragging: true,
            zoomControl: true,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            boxZoom: true,
            keyboard: true,
            tap: true,
            touchZoom: true
        }).setView([centerLat, centerLng], 13);
		
        // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            // maxZoom: 20
        // }).addTo(mapPengawas); 
		
		
		
        if (projectLat !== null && projectLng !== null) {
            markerPengawas = L.marker([projectLat, projectLng], {
                draggable: false
            }).addTo(mapPengawas)
				.bindPopup(
			`
            <strong>Lokasi Proyek</strong>
            <h6 class="card-title mb-1">{{ $pekerjaan->nm_pekerjaan }}</h6>
            <div class="mb-2" style="font-size: 13px;">
                <span class="text-secondary">Latitude:</span> <b>${projectLat}</b><br>
                <span class="text-secondary">Longitude:</span> <b>${projectLng}</b>
						 
				`,
				{ maxWidth: 400 }
			  ).openPopup();
			  
	 
	
        }
		
		
		let markers = L.layerGroup().addTo(mapPengawas);
		let markersPeta = L.layerGroup().addTo(map);
		
		
		pospengawas.forEach(pos => {
			if (!pos.latitude || !pos.longitude) {
				console.warn('Data tidak lengkap', pos);
				return;
			}
			
			
				// var circle2 = L.circle([pos.latitude, pos.longitude], {
							// radius: pos.radius,  
							// color: 'red',          
							// fillColor: '#f03',  
							// fillOpacity: 0.3
						// }).addTo(map);
						
			// Cek apakah polyline valid & ada isinya
let hasPolyline = false;
let latlngs = [];

if (pos.polyline) {
    try {
        // Jika string → parse
        let data = typeof pos.polyline === 'string'
            ? JSON.parse(pos.polyline)
            : pos.polyline;

        // Cek apakah array dan ada isinya
        if (Array.isArray(data) && data.length > 0) {
            hasPolyline = true;
            latlngs = data.map(p => [parseFloat(p[0]), parseFloat(p[1])]);
        }
    } catch (e) {
        console.warn("Polyline tidak valid:", pos.polyline);
        hasPolyline = false;
    }
}

if (hasPolyline) {
    // =========================
    //   TAMPILKAN POLYLINE
    // =========================
	let baseWeight = pos.radius * 4;
	
    var polyline = L.polyline(latlngs, {
        color: 'yellow',
        weight: pos.radius * 4,
        opacity: 0.4
    }).addTo(mapPengawas);

    var mainPolyline = L.polyline(latlngs, {
        color: 'red',
        weight: 3,
        opacity: 0.9
    }).addTo(mapPengawas);

    var polyline2 = L.polyline(latlngs, {
        color: 'yellow',
        weight: pos.radius * 4,
        opacity: 0.4
    }).addTo(map);

    var mainPolyline2 = L.polyline(latlngs, {
        color: 'red',
        weight: 3,
        opacity: 0.9
    }).addTo(map);
	
    // Click event popup
    polyline.on('click', function (e) {
		//let gmapUrl = buildGoogleMapsPolylineURL(latlngs);
		//let gmapUrl = buildGoogleMapsEncodedURL(latlngs);
		
		//let gmapUrl = buildGoogleMapsWaypointsURL(latlngs);
		
    let lat = e.latlng.lat;
    let lng = e.latlng.lng;
	
	// Custom marker icon
	var customIcon = L.icon({
		iconUrl: '{{ asset("assets/icons/location-pin.png") }}',
		iconSize: [40, 40],
		iconAnchor: [20, 40],
	});

		// Hapus dulu marker sebelumnya kalau ada (opsional)
    if (window.clickMarker) {
        mapPengawas.removeLayer(window.clickMarker);
    }
	// Buat marker baru di titik klik
    window.clickMarker = L.marker([lat, lng], { icon: customIcon }).addTo(mapPengawas);

    // URL Google Maps dari titik klik
    let gmapUrl = `https://www.google.com/maps?q=${lat},${lng}`;
	
	// Tampilkan popup
    window.clickMarker.bindPopup(`
        <h5>Titik lokasi</h5>
		<strong>${pos.nm_pos}</strong>
		<div>${pos.nm_lokasi}</div>
        Lat: ${lat}<br>
        Lng: ${lng}<br>
        <a href="${gmapUrl}" target="_blank"
           class="btn btn-sm btn-primary text-light mt-2 w-100">
           Buka di Google Maps
        </a>
    `).openPopup();
	
        // L.popup()
            // .setLatLng(e.latlng)
            // .setContent(`
                // <strong>Pos Pengawas</strong><br>
                // Nama: ${pos.nm_pos ?? '-'}<br>
                // Lokasi: ${pos.nm_lokasi ?? '-'}<br>
                // Radius: ${pos.radius ?? '-'} meter<br>
				 // <a href="${gmapUrl}" target="_blank" class="btn btn-sm btn-primary mt-2 w-100">
          // Buka di Google Maps
        // </a>
            // `)
            // .openOn(mapPengawas);
    });

} else {
    // =========================
    //   TAMPILKAN MARKER
    // =========================
    
    // Marker utama
const marker2 = L.marker(
    [parseFloat(pos.latitude), parseFloat(pos.longitude)],
    {
        icon: L.icon({
            iconUrl: '{{ asset("assets/icons/location-pin.png") }}',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -30]
        })
    }
).bindPopup(`
    <strong>Lokasi Pengawasan</strong>
    <h6 class="card-title mb-1">${pos.nm_pos ?? '-'}</h6>
    <div class="mb-2" style="font-size: 13px;">
        <div><b>${pos.nm_lokasi ?? '-'}</b></div>
        <div>(${pos.latitude},${pos.longitude}) [${pos.radius} meter]</div>
    </div>
`, { minWidth: 300 });

const marker3 = L.marker(
    [parseFloat(pos.latitude), parseFloat(pos.longitude)],
    {
        icon: L.icon({
            iconUrl: '{{ asset("assets/icons/location-pin.png") }}',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -30]
        })
    }
).bindPopup(`
    <strong>Lokasi Pengawasan</strong>
    <h6 class="card-title mb-1">${pos.nm_pos ?? '-'}</h6>
    <div class="mb-2" style="font-size: 13px;">
        <div><b>${pos.nm_lokasi ?? '-'}</b></div>
        <div>(${pos.latitude},${pos.longitude}) [${pos.radius} meter]</div>
    </div>
`, { minWidth: 300 });

markers.addLayer(marker2);
markersPeta.addLayer(marker3);


// --------------------------
// CIRCLE YANG BISA DI-CLICK
// --------------------------

// const circle = L.circle([pos.latitude, pos.longitude], {
    // radius: pos.radius,   // meter (benar)
    // color: 'red',
    // fillColor: '#f03',
    // fillOpacity: 0.3,
    // interactive: true     // WAJIB biar bisa diklik
// }).addTo(mapPengawas);

// const circlePeta = L.circle([pos.latitude, pos.longitude], {
    // radius: pos.radius,   // meter (benar)
    // color: 'red',
    // fillColor: '#f03',
    // fillOpacity: 0.3,
    // interactive: true     // WAJIB biar bisa diklik
// }).addTo(map);

// // Klik circle → buka popup marker
// circle.on('click', function () {
    // marker2.openPopup();
// });


}

			
		});
		
		
			
		//map.addLayer(markers);
	
		
	
		
	 
		}
		
		// Encoder polyline (Google polyline algorithm)
function encodePolyline(points) {
    // points: [[lat, lng], [lat, lng], ...]
    let lastLat = 0;
    let lastLng = 0;
    let result = '';

    function encodeSignedNumber(num) {
        let sgn_num = num << 1;
        if (num < 0) {
            sgn_num = ~sgn_num;
        }
        let chunks = [];
        while (sgn_num >= 0x20) {
            chunks.push((0x20 | (sgn_num & 0x1f)) + 63);
            sgn_num >>= 5;
        }
        chunks.push(sgn_num + 63);
        return String.fromCharCode(...chunks);
    }

    for (let i = 0; i < points.length; i++) {
        let lat = Math.round(points[i][0] * 1e5);
        let lng = Math.round(points[i][1] * 1e5);

        let dLat = lat - lastLat;
        let dLng = lng - lastLng;

        result += encodeSignedNumber(dLat);
        result += encodeSignedNumber(dLng);

        lastLat = lat;
        lastLng = lng;
    }

    return result;
}


		function buildGoogleMapsWaypointsURL(latlngs) {
    // latlngs: [[lat,lng],[lat,lng],...]
    let waypoints = latlngs.map(p => `${p[0]},${p[1]}`).join('|');
    return `https://www.google.com/maps/dir/?api=1&waypoints=${encodeURIComponent(waypoints)}`;
}


		function buildGoogleMapsEncodedURL(latlngs) {
    // Encode polyline: latlngs = [ [lat, lng], [lat, lng], ... ]
    //let encoded = polylineCodec.encode(latlngs);
		let encoded = encodePolyline(latlngs);
    return `https://www.google.com/maps/dir/?api=1&path=enc:${encoded}`;
}
		function buildGoogleMapsPolylineURL(latlngs) {
    let waypoints = latlngs.map(p => `${p[0]},${p[1]}`).join('|');

    return `https://www.google.com/maps/dir/?api=1&waypoints=${waypoints}`;
}
		// ============================
		// INIT MAP (dipanggil sekali saja)
		// ============================
		function initMapPosx(centerLat, centerLng) {

			// Cegah map duplikasi (empty modal bug)
				if (mapPos) {
					setTimeout(() => mapPos.invalidateSize(), 300);
					return;
				}
				if (!mapPos) { 
					 mapPos = L.map('mapPosPengawas', {
						dragging: false,
						zoomControl: false,
						scrollWheelZoom: false,
						doubleClickZoom: false,
						boxZoom: false,
						keyboard: false,
						tap: false,
						touchZoom: false
					}).setView([centerLat, centerLng], 13);

					L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						maxZoom: 19
					}).addTo(mapPos);
					
					// Layer tempat polyline & marker
					drawnItems = new L.FeatureGroup().addTo(mapPos);
					
					// Draw control
					drawControl = new L.Control.Draw({
						draw: {
							polyline: true,
							marker: false,
							polygon: false,
							rectangle: false,
							circle: false,
							circlemarker: false,
						},
						edit: {
							featureGroup: drawnItems,
							remove: true
						}
					});

					mapPos.addControl(drawControl);

					// ============================
					// EVENT: Polyline dibuat
					// ============================
					mapPos.on(L.Draw.Event.CREATED, function (e) {
						let layer = e.layer;

						drawnItems.clearLayers();
						if (bufferLayer) { mapPos.removeLayer(bufferLayer); bufferLayer = null; }

						drawnItems.addLayer(layer);

						if (layer instanceof L.Polyline) {
							currentPolyline = layer;
						}
					});

					// EVENT: Edit polyline
					mapPos.on('draw:edited', function () {
						if (bufferLayer) { mapPos.removeLayer(bufferLayer); bufferLayer = null; }
					});

					// EVENT: Hapus polyline
					mapPos.on('draw:deleted', function () {
						currentPolyline = null;
						if (bufferLayer) { mapPos.removeLayer(bufferLayer); bufferLayer = null; }
					});

					// ============================
					// CLICK PETA → PUT MARKER
					// ============================
					mapPos.on("click", function (e) {
						let lat = e.latlng.lat.toFixed(6);
						let lng = e.latlng.lng.toFixed(6);

						// isi textbox jika ada
						$("#pos_latitude").val(lat);
						$("#pos_longitude").val(lng);

						placePointMarker(lat, lng);
					});
					
				setTimeout(() => mapPos.invalidateSize(), 300);
			}
		}
		
		
			
		// ============================
		// FUNGSI MARKER
		// ============================
		function placePointMarker(lat, lng) {
			if (pointMarker) mapPos.removeLayer(pointMarker);

			pointMarker = L.marker([lat, lng]).addTo(mapPos);
		}


			// ============================
			// BUAT RADIUS BUFFER
			// ============================
			function makeBuffer() {
				if (!currentPolyline) return alert("Polyline belum dibuat!");

				let radius = Number($("#radiusInput").val()) || 50;

				let coords = currentPolyline.getLatLngs().map(c => [c.lng, c.lat]);
				let line = turf.lineString(coords);
				let buffered = turf.buffer(line, radius, { units: "meters" });

				if (bufferLayer) mapPos.removeLayer(bufferLayer);

				bufferLayer = L.geoJSON(buffered, {
					style: { color: "red", weight: 2, fillOpacity: 0.2 }
				}).addTo(mapPos);

				mapPos.fitBounds(bufferLayer.getBounds());
			}


			// ============================
			// CEK TITIK DALAM BUFFER
			// ============================
			function checkPointInside() {

				if (!bufferLayer) return alert("Buffer belum dibuat!");

				let lat = parseFloat($("#pos_latitude").val());
				let lng = parseFloat($("#pos_longitude").val());

				let pt = turf.point([lng, lat]);
				let bufferGeo = bufferLayer.toGeoJSON();

				let inside = false;

				if (bufferGeo.type === "FeatureCollection") {
					bufferGeo.features.forEach(f => {
						if (turf.booleanPointInPolygon(pt, f)) inside = true;
					});
				} else {
					inside = turf.booleanPointInPolygon(pt, bufferGeo);
				}

				if (inside) {
					alert("Titik berada di dalam radius!");
					pointMarker.bindPopup("✔ Dalam radius").openPopup();
				} else {
					alert("Titik berada di luar radius!");
					pointMarker.bindPopup("✖ Di luar radius").openPopup();
				}
			}

			function placeMarker(lat, lng){
						if (pointMarker) map.removeLayer(pointMarker);
						pointMarker = L.marker([lat, lng]).addTo(map);
					}

			function updateStatus(text) {
				const el = document.getElementById('statusx');
				el.textContent = 'Status: ' + text;
			  }

		updateStatus('Ready. Gunakan toolbar draw (pojok atas kiri) untuk menggambar polyline.');
  
		// BUFFER
        document.getElementById("btnBuffer").onclick = () => {
            if (!currentPolyline) return updateStatus("Buat polyline dulu");

            let radius = Number(document.getElementById("radiusInput").value);

            let coords = currentPolyline.getLatLngs().map(pt => [pt.lng, pt.lat]);
            let buff = turf.buffer(turf.lineString(coords), radius, { units:"meters" });

            if (bufferLayer) mapX.removeLayer(bufferLayer);

            bufferLayer = L.geoJSON(buff, {
                style:{ color:"orange", weight:2, fillOpacity:.2 }
            }).addTo(mapX);

            mapX.fitBounds(bufferLayer.getBounds());

			 
        };

        document.getElementById("btnClearBuffer").onclick = () => {
            if (bufferLayer) mapX.removeLayer(bufferLayer);
            bufferLayer = null;
        };
		
		
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
		
		 

			let target = $(e.target).attr("href");
			localStorage.setItem('lastTab', target);
		// Panggil map yang aktif sesuai tab
		 
		 if (typeof map !== "undefined") {
            setTimeout(() => {
                map.invalidateSize();
				marker.openPopup();
            }, 250);
        }
		
        if (typeof mapPengawas !== "undefined") {
            setTimeout(() => {
                mapPengawas.invalidateSize();
				markerPengawas.openPopup();
            }, 250); // delay sedikit supaya tab benar2 visible
        }
		
		if (typeof mapPos !== "undefined") {
            setTimeout(() => {
                mapPos.invalidateSize();
				marker.openPopup();
            }, 250);
        }
		
		 
		// if (target === "#peta") {
			// // if (!map) {
				// // map.invalidateSize(); // refresh ukuran map
				
				// // map = L.map('map').setView([lat, lon], 15);
				// // //L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
			// // }
			// setTimeout(() => map.invalidateSize(), 200);
		// }

		// if (target === "#pengawasan") {
			// if (!mapPengawas) {
				 
				// mapPengawas = L.map('map-pengawas').setView([lat, lon], 15);
				// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapPengawas);
			// }
			// setTimeout(() => mapPengawas.invalidateSize(), 200);
		// }
	});	
	
	
	
		

			
});
 
</script>
<script>
	function loadKontraktors(page = 1, search = '') {
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
                                    data-name="${org.name}" data-target="kon_pelaksana_id">Pilih</button>
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
    loadKontraktors(page, $('#searchOrg').val());
}

// Trigger saat modal dibuka
$('#modalOrganization').on('shown.bs.modal', function () {
    loadKontraktors();
});

// Search realtime
$('#searchOrg').on('keyup', function() {
    loadKontraktors(1, $(this).val());
});
</script>
<script>
	// Fungsi untuk set target sebelum modal dibuka
function setTarget(target) {
    targetField = target; // misal 'pengawas' atau 'pelaksana'
}

// Satu handler click untuk semua item
$(document).off('click').on('click', '.pilih-org', function() {
	//$('#submitOPDPengawas').off('click').on('click', function () {
    let id = $(this).data('id');
    let name = $(this).data('name');

    if (targetField === 'pengawas') {
        $('#kon_pengawas_id').val(id);
        $('#kon_pengawas_name').val(name);
		
	update_kontraktor({{$pekerjaan->id}},'kon_pengawas_id',id);
		
    } else if (targetField === 'pelaksana') {
        $('#kon_pelaksana_id').val(id);
        $('#kon_pelaksana_name').val(name);
		
		update_kontraktor({{$pekerjaan->id}},'kon_pelaksana_id', id);
    }

		// Tutup modal
		$('#modalOrganization').modal('hide');
	});

 
	function update_kontraktor(id, target,kon_id){
	$.ajax({
        url: "/ajax/update_kontraktor_pekerjaan",
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
			'id' : id,
			'target' : target,
			'kon_id' : kon_id,
        },
        success: function (res) {
             
             
            // Tampilkan status sukses
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil diubah!'
            }).then(() => {
				//refresh();
				  
			});
        },
        error: function (xhr) {
             
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menyimpan.'
            });
        }
    });		
}

 
</script>


<script>
	$(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();

    let id = $(this).data('id');

    Swal.fire({
        title: "Yakin ingin hapus?",
        text: "Data ini tidak bisa dikembalikan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, hapus!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "/ajax/delete-laporan-pengawasan/" + id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {

                    if (res.success) {
                        // Hapus card dari tampilan
                        $("#card-" + id).fadeOut(300, function(){
                            $(this).remove();
                        });

                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: res.message,
                            timer: 1200
                        }).then(() => {
							loadData();
						});
                    } else {
                        Swal.fire("Gagal", res.message, "error");
                    }
                },
                error: function(xhr) {
                    Swal.fire("Gagal", "Terjadi kesalahan pada server", "error");
                }
            });

        }
    });
});
</script>

<script>
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

	document.getElementById('formChangeStatus').addEventListener('submit', function(e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);
    let submitBtn = document.getElementById('submitBtn');
    let submitLabel = document.getElementById('submitLabel');
    let submitSpinner = document.getElementById('submitSpinner');

    Swal.fire({
        title: 'Ubah Status?',
        text: "Pastikan status yang dipilih sudah benar.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            // Aktifkan loading
            submitBtn.disabled = true;
            submitLabel.innerText = 'Menyimpan...';
            submitSpinner.classList.remove('d-none');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(res => {

                submitBtn.disabled = false;
                submitLabel.innerText = 'Simpan';
                submitSpinner.classList.add('d-none');

                if (res.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message ?? 'Status berhasil diperbarui',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Tutup modal
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalChangeStatus'));
                    modal.hide();

                    // Reload data
                    if (typeof loadData === "function") {
                        loadData();
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: res.message ?? 'Terjadi kesalahan'
                    });
                }
            })
            .catch(error => {

                submitBtn.disabled = false;
                submitLabel.innerText = 'Simpan';
                submitSpinner.classList.add('d-none');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan server.'
                });
            });

        }
    });
});
</script>