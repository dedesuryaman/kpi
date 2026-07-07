@extends('layouts.admin.app')
@push('title' , 'Data Kontraktor')
@push('styles')
<style>
    .card-hover:hover {
        transform: translateY(-6px);
        /* naik */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        /* bayangan */
    }

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
                <i class="bx bx-grid-alt bx-5x"></i>
            </div>
            <div
                class="page-header-title-bar w-100 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-md-0">
                    <h4 class="mb-0 text-secondary mx-3 mt-3 mt-md-0 font-size-18 fw-bold text-uppercase title-text">
                        Daftar Kontraktor
                    </h4>
                </div>

                <div class="page-header-extra mt-2 mb-2 ms-md-auto text-md-end  mx-3">

                    @can('kontraktor.create')
                    <a href="{{ route('kontraktor.create') }}" class="btn btn-outline-primary waves-effect waves-light">
                        <i class="bi bi-plus-circle"></i> Tambah Kontraktor
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 md-3">

    </div>
    <div class="col-md-4 md-3">
        <!-- Kiri : Search & Filter -->
        <form method="GET" action="{{ route('kontraktor.index') }}" class="d-flex flex-wrap gap-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama kontraktor..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    <span class="d-none d-md-inline">Filter</span>
                </button>
                <a href="{{ route('kontraktor.index') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>
<div class="card shadow shadow-sm mt-3">
    <div class="card-body">
        <!-- end page title -->
        <div class="row g-3 mt-3">
            <div class="col-12 table-responsive">
                <table class="table table-sm">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="60px">Option</th>
                    </thead>
                    <tbody>
                        @php $n = 1; @endphp
                        @foreach($kontraktors as $org)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{ $org->name }}</td>
                            <td>{{ $org->address }}</td>
                            <td>{{ $org->email }}</td>
                            <td>{{ $org->phone }}</td>
                            <td>
                                <div class="btn-group">
                                    @can('kontraktor.delete')
                                    <a href="#" data-href="{{ route('kontraktor.destroy', $org->id) }}"
                                        class="btn btn-sm btn-outline-danger btn-delete-kontraktor">
                                        Delete
                                    </a>
                                    @endcan
                                    @can('kontraktor.view')
                                    <a href="{{ route('kontraktor.show', $org->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Detail
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $kontraktors->links('vendor.pagination.bootstrap-first-last') }}
    @endsection

    @push('scripts')
    <script>
        $(document).ready(function() {
    $('.btn-delete-kontraktor').on('click', function(e) {
        e.preventDefault();
        let url = $(this).data('href'); // ambil route dari data-href

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data kontraktor akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // csrf token wajib di Laravel
                    },
                    success: function(response) {
                        Swal.fire(
                            'Terhapus!',
                            'Data kontraktor berhasil dihapus.',
                            'success'
                        );
                        // Opsional: reload atau hapus row dari table
                        location.reload(); // reload halaman
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
    </script>
    @endpush