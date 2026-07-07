@extends('layouts.admin.app')
@push('title' , 'Data Pengawasan')
@push('styles')
<style>
    .card-hover {
        transition: all 0.25s ease-in-out;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: translateY(-6px);
        /* naik */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        /* bayangan */
    }
</style>
@endpush

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data Laporan Pengawasan</h4>

            <div class="page-title-right">

            </div>
        </div>
    </div>
</div>

@if(!empty($pekerjaan))
<h5>{{ $pekerjaan->nm_pekerjaan ?? '' }}</h5>
<p>{{ $pekerjaan->deskripsi ?? '-' }}</p>

<div class="row align-items-stretch mt-3">
    @foreach($pengawasanhistories as $row)

    @php
    if($row->approved_status == 'verified') $warna = 'bg-warning';
    elseif($row->approved_status == 'approved') $warna = 'bg-success';
    elseif($row->approved_status == 'rejected') $warna = 'bg-danger';
    else $warna = 'bg-secondary';
    @endphp

    <div class="col-md-6 col-xl-4 d-flex">
        <div class="card flex-fill position-relative card-hover border border-info">
            {{-- FOTO --}}
            <a href="javascript:void(0)" class="btn-show-photo" data-bs-toggle="modal" data-bs-target="#photoModal"
                data-photo="{{ $row->foto_path ? asset('storage/'.$row->foto_path) : asset('assets/images/no-image.png') }}"
                title="View">

                <img src="{{ $row->foto_path ? asset('storage/'.$row->foto_path) : asset('assets/images/no-image.png') }}"
                    class="card-img-top" style="height:300px; object-fit:cover;">
            </a>
            <div class="card-body d-flex flex-column">

                {{-- SUB PEKERJAAN --}} <div class="fw-semibold text-truncate"> {{ $row->subPekerjaan?->judul ?? '-' }}
                </div>
                <div class="text-muted mb-1"> Pos: {{ $row->posPengawasan?->nm_pos ?? '-' }} </div> {{-- PENGAWAS --}}
                <div class="mb-1"> <span class="fw-semibold">{{ $row->pengawas->name ?? '-' }}</span> <span
                        class="text-muted d-block">{{
                        $row->waktu_pengawasan ?? '-' }}</span> </div> {{-- ALAMAT --}} <div class="text-truncate mb-1">
                    <i class="fa fa-map-marker-alt text-danger"></i> {{ $row->alamat ?? '-' }}
                </div> {{-- CATATAN --}}
                <div class="text-muted mb-1 text-truncate"> {{ $row->catatan ?? '-' }} </div> {{-- KOORDINAT --}} <div
                    class="text-muted mb-2"> {{ $row->latitude ?? '-' }} | {{ $row->longitude ?? '-' }} </div>

                {{-- FOOTER --}} <div class="mt-auto d-flex justify-content-between align-items-center"> <span
                        class="badge {{ $warna }}"> {{ !empty($row->approved_status) ? ucfirst($row->approved_status) :
                        'Waiting' }}
                    </span>
                    <div class="btn-group btn-group-sm"> @can('pengawasan.delete') @if(empty($row->approved_status))
                        <button class="btn btn-outline-danger btn-delete" data-id="{{ $row->id }}"> <i
                                class="fa fa-trash"></i> </button>
                        @endif @endcan @can('pengawasan.approved') <button class="btn-show-photo btn btn-outline-info"
                            data-id="{{ $row->id }}" data-tanggal="{{ $row->waktu_pengawasan }}"
                            data-alamat="{{ $row->alamat ?? '' }}" data-catatan="{{ $row->catatan ?? '' }}"
                            data-latitude="{{ $row->latitude ?? '' }}" data-longitude="{{ $row->longitude ?? '' }}"
                            data-pengawas="{{ $row->pengawas->name ?? '' }}"
                            data-approved_status="{{ $row->approved_status ?? 'verified' }}"
                            data-approved_note="{{ $row->approved_note ?? '' }}"
                            data-photo="{{ $row->foto_path ? asset('storage/'.$row->foto_path) : asset('assets/images/no-image.png') }}"
                            data-bs-toggle="modal" data-bs-target="#approvedModal"> <i class="fa fa-check"></i>
                        </button> @endcan </div>
                </div>

            </div>
        </div>
    </div>

    @endforeach
</div>

<div class="mt-3">
    {{ $pengawasanhistories->links('vendor.pagination.bootstrap-first-last') }}
</div>

<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Pengawasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid rounded" alt="Foto Pengawasan">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approvedModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Approved Pengawasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ url('/pengawasan/approved') }}" id="formApproved">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-8">

                            <input type="hidden" name="id" value="" id="id_pengawasan">

                            <div class="mb-3">
                                <label class="fw-semibold">Tanggal/Waktu Pengawasan</label>
                                <div id="m_tanggal" class="text-muted"></div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Lokasi Pengawasan</label>
                                <div id="m_alamat" class="text-muted"></div>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="fw-semibold">Latitude</label>
                                    <div id="m_latitude" class="text-muted"></div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="fw-semibold">Longitude</label>
                                    <div id="m_longitude" class="text-muted"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Catatan / Keterangan</label>
                                <div id="m_catatan" class="text-muted"></div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Pengawas</label>
                                <div id="m_pengawas" class="text-muted"></div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="fw-semibold d-block mb-2">Approval</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="approved" value="verified"
                                        id="r1">
                                    <label class="form-check-label" for="r1">Verified</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="approved" value="approved"
                                        id="r2" checked>
                                    <label class="form-check-label" for="r2">Approved</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="approved" value="rejected"
                                        id="r3">
                                    <label class="form-check-label" for="r3">Rejected</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Approved Note</label>
                                <textarea name="approved_note" id="m_approved_note" class="form-control" rows="3"
                                    maxlength="500"></textarea>
                                <small id="charCount">0 / 500</small>
                            </div>

                        </div>

                        <div class="col-md-4 mb-3">
                            <img id="approvedPhoto" src="" class="img-fluid rounded w-100" alt="Foto Pengawasan">
                        </div>
                    </div>
                    {{-- FOOTER --}}
                    <div class="modal-footer p-0 my-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>

            </form>
        </div>
    </div>
</div>
</div>
@else
<div class="col-12">
    <div class="alert alert-warning text-center shadow-sm py-4">

        <div class="mb-3">
            <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size:60px;"></i>
        </div>
        <i class="fa fa-folder-open fa-5x mb-3"></i>
        <h6 class="mb-1 fw-bold">Data Tidak Ditemukan</h6>
        <div>Belum ada data pekerjaan atau pengawasan.</div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-show-photo').forEach(btn => {
        btn.addEventListener('click', function () {
            const photoUrl = this.getAttribute('data-photo');
            document.getElementById('modalPhoto').src = photoUrl;
        });
    });
});


</script>

<script>
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-show-photo");
        if (!btn) return;

        document.getElementById("id_pengawasan").value = btn.dataset.id;
        document.getElementById("m_tanggal").innerText = btn.dataset.tanggal;
        document.getElementById("m_alamat").innerText = btn.dataset.alamat;
        document.getElementById("m_latitude").innerText = btn.dataset.latitude;
        document.getElementById("m_longitude").innerText = btn.dataset.longitude;
        document.getElementById("m_catatan").innerText = btn.dataset.catatan;
        document.getElementById("m_pengawas").innerText = btn.dataset.pengawas;

        // textarea
        document.getElementById("m_approved_note").value = btn.dataset.approved_note ?? '';

        // photo
        document.getElementById("approvedPhoto").src = btn.dataset.photo;

        // radio
        const status = (btn.dataset.approved_status || 'verified')
        .toString()
        .trim()
        .toLowerCase();
        
        document.querySelectorAll('input[name="approved"]').forEach(r => {
        r.checked = r.value.toLowerCase() === status;
        });
        const textarea = document.getElementById('m_approved_note');
        const counter = document.getElementById('charCount');
        
        
        textarea.addEventListener('input', function () {
        counter.innerText = this.value.length + ' / 500';
        });
        
        textarea.dispatchEvent(new Event('input'));
});
</script>

<script>
    $(document).on('submit', '#formApproved', function(e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr('action');
    let formData = form.serialize();

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyimpan approval ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (!result.isConfirmed) return;

        // tombol loading
        let btn = form.find('button[type=submit]');
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

        $.ajax({
        url: url,
        type: "POST",
        data: formData,
        
        success: function(res, status, xhr) {
        
        console.log('=== SUCCESS ===');
        console.log('Response:', res);
        console.log('Status:', status);
        console.log('HTTP:', xhr.status);
        
        btn.prop('disabled', false);
        btn.html('Update');
        
        Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: res.message ?? 'Data berhasil disimpan'
        }).then(() => {
        $('#approvedModal').modal('hide');
        
        if (typeof table !== 'undefined') {
        table.ajax.reload(null, false);
        } else {
        location.reload();
        }
        });
        },
        
        error: function(xhr, status, error) {
        
        console.log('=== ERROR ===');
        console.log('Status:', status);
        console.log('Error:', error);
        console.log('ResponseText:', xhr.responseText);
        console.log('JSON:', xhr.responseJSON);
        
        btn.prop('disabled', false);
        btn.html('Update');
        
        let msg = 'Terjadi kesalahan';
        
        if (xhr.responseJSON && xhr.responseJSON.message) {
        msg = xhr.responseJSON.message;
        }
        
        Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: msg
        });
        }
        });

    });
});
</script>
<script>
    $(document).on('click', '.btn-delete', function () {

    let id = $(this).data('id');
    let token = '{{ csrf_token() }}';
    let url = "{{ url('/ajax/delete-laporan-pengawasan')}}" + "/" + id ;
    url = url.replace(':id', id);

    Swal.fire({
        title: 'Yakin hapus data?',
        text: "Data pengawasan akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _method: 'DELETE',
                    _token: token
                },
                success: function (response) {

                    Swal.fire(
                        'Berhasil!',
                        'Data pengawasan berhasil dihapus.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });

                },
                error: function (xhr) {

                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus data.',
                        'error'
                    );

                }
            });

        }
    });

});
</script>
@endpush