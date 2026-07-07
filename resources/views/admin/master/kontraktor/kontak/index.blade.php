@extends('layouts.admin.app')
@push('title' , 'Data Kontak')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Daftar Kontak</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('kontak.index') }}">Kontak</a></li>
                    <li class="breadcrumb-item active">Data Kontak</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">

            <!-- Kiri : Search & Filter -->
            <form method="GET" action="{{ route('kontak.index') }}" class="d-flex flex-wrap gap-2">

                <!-- Search -->
                <div>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama..."
                        value="{{ request('search') }}">
                </div>



                <!-- Button Filter -->
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Filter
                </button>

                <!-- Reset -->
                <a href="{{ route('kontak.index') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            </form>

            <!-- Kanan : Button New Project -->
            <div class="text-end">
                <button data-href="{{ route('kontak.create') }}" class="btn btn-success btn-add-contact"
                    data-bs-toggle="modal" data-bs-target="#add-contact">
                    <i class="bi bi-plus-circle"></i> Tambah Kontak
                </button>
            </div>

        </div>
    </div>
</div>

<!-- end page title -->
<div class="row g-3">
    @foreach($contacts as $row)
    <div class="col-3">
        <div class="card border border-primary">
            <div class="card-header bg-transparent border-primary">
                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>{{ $row->name }}</h5>
            </div>

            <div class="card-body">
                <div>Nama : {{ $row->address }}</div>
                <p>Email : {{ $row->email }}</p>
                <p>Phone :{{ $row->phone }}</p>
                @if($row->organization)

                <p>Vendor : {{ $row->organization->name }}</p>

                @endif
                <p>Project : {{ $row->projects_count }}</p>
            </div>
            <div class="card-footer text-end">
                <button data-href="{{ route('kontak.destroy', $row->id) }}"
                    class="btn btn-sm btn-outline-danger btn-delete">
                    Delete
                </button>
                <a href="{{ route('kontak.show', $row->id) }}" class="btn btn-sm btn-outline-primary">
                    Detail
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{ $contacts->links('vendor.pagination.bootstrap-first-last') }}

<div class="modal fade" id="add-contact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="add-contactLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-contactLabel">Tambah Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambah-kontak" action="{{route('kontak.store')}}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kontraktor/Vendor</label>

                        <select class="form-control select2" name="organization_id" required>
                            <option value="">--Pilih vendor--</option>
                            @foreach ($organizations as $row)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" placeholder="Input nama" required>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Input email"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone"
                                    placeholder="Input nomor telepon/hp" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" rows="3" name="address" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    $('.btn-delete').click(function(e) {
        e.preventDefault();
        let url = $(this).data('href'); // ambil URL delete
        let row = $(this).closest('tr'); // ambil row untuk dihapus

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data kontak akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // CSRF token
                    },
                    success: function(response) {
                        if(response.success) {
                        Swal.fire(
                        'Terhapus!',
                        response.message || 'Kontak berhasil dihapus.',
                        'success'
                        ).then(() => {
                        // Reload halaman setelah SweetAlert ditutup
                        location.reload();
                        });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Gagal!',
                            xhr.responseJSON?.message || 'Terjadi kesalahan.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

<script>
    $(document).ready(function() {
    $('#tambah-kontak').on('submit', function(e) {
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
                if(response.success) {
                    // Tutup modal
                    $('#add-contact').modal('hide');

                    // Reset form
                    form[0].reset();

                    // Optional: tampilkan notifikasi
                    alert(response.message || 'Kontak berhasil ditambahkan');

                    // Optional: update tabel kontak secara realtime
                    // Misal reload datatable / append row baru
                    // $('#kontak-table').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                // Handle error validation
                let errors = xhr.responseJSON.errors;
                if(errors) {
                    let errorText = '';
                    $.each(errors, function(key, value) {
                        errorText += value + "\n";
                    });
                    alert(errorText);
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });
});
</script>
@endpush