@extends('layouts.admin.app')
@push('title' , 'Data Proyek')
@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0 font-size-18">Daftar Proyek</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Proyek</a></li>
					<li class="breadcrumb-item active">Data Proyek</li>
				</ol>
			</div>

		</div>
	</div>
</div>
<div class="card mb-4 shadow-sm">
	<div class="card-body">
		<div class="d-flex flex-wrap align-items-center justify-content-between gap-2">

			<!-- Kiri : Search & Filter -->
			<form method="GET" action="{{ route('proyek.index') }}" class="d-flex flex-wrap gap-2">

				<!-- Search -->
				<div>
					<input type="text" name="search" class="form-control" placeholder="Cari nama proyek..."
						value="{{ request('search') }}">
				</div>

				<!-- Tanggal Mulai -->
				<div>
					<input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
				</div>

				<!-- Tanggal Selesai -->
				<div>
					<input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
				</div>

				<!-- Button Filter -->
				<button type="submit" class="btn btn-primary">
					<i class="bi bi-search"></i> Filter
				</button>

				<!-- Reset -->
				<a href="{{ route('proyek.index') }}" class="btn btn-outline-secondary">
					Reset
				</a>
			</form>

			<!-- Kanan : Button New Project -->
			<div class="text-end">
				<a href="{{ route('proyek.create') }}" class="btn btn-success">
					<i class="bi bi-plus-circle"></i> Proyek Baru
				</a>
			</div>

		</div>
	</div>
</div>
<!-- end page title -->
<div class="card ">
	<div class="card-body g-3">
		<div class="table-responsive">
			<table class="table table-sm table-hover mb-0">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Proyek</th>
						<th>Lokasi</th>
						<th>Tahun</th>
						<th>Kemajuan</th>
						<th>Pagu</th>
						<th>Anggaran</th>
						<th>Realisasi</th>
						<th>Status</th>
					</tr>
				</thead>

				<tbody>
					@foreach($projects as $row)
					<?php
					$badge = "bg-default";
					if($row->status_id <= 1){
						$badge = "bg-warning";
					}else{
						$badge = "bg-info";
					}
				?>
					<tr>
						<td>{{ $projects->firstItem() + $loop->index }}</td>
						<td><a href="{{ route('proyek.detail' , $row->id }}">{{ $row->name }}</a></td>
						<td>{{ $row->lokasi }}</td>
						<td>{{ $row->tahun_anggaran }}</td>
						<td>{{ number_format($row->progress_summary ?? 0 ,2) }}%</td>
						<td>{{ rupiah($row->pagu_anggaran ?? 0) }}</td>
						<td>{{ rupiah($row->total_anggaran ?? 0) }}</td>
						<td>{{ rupiah($row->total_realisasi ?? 0) }}</td>
						<td><span class="badge {{$badge}}">
								{{ $row->status->name ?? '-'}}
							</span>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<br>

			{{ $projects->links('vendor.pagination.bootstrap-first-last') }}
		</div>
	</div>
</div>


@endsection

@push('scripts')
<script>
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
                url: '/proyek/' + id,
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
</script>

@endpush