@extends('layouts.admin.app')
@push('title', 'Data Laporan Kendala')

@section('content')

<div class="row mb-3">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-semibold">Data Laporan Kendala</h4>
                        <h5 class="text-muted">
                            {{ $pekerjaan->nm_pekerjaan }}
                        </h5>
                        <div class="text-muted">
                            {{ $pekerjaan->deskripsi ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="60">No</th>
                            <th width="140">Tanggal</th>
                            <th>Kendala</th>
                            <th>Deskripsi</th>
                            <th width="160">Jenis</th>
                            <th width="160">Pengawas</th>
                            <th width="80">Foto</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kendalas as $row)
                        <tr>
                            <td class="text-center">
                                {{ $kendalas->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y H:i') }}
                            </td>

                            <td class="fw-semibold">
                                {{ $row->judul ?? '-' }}
                            </td>

                            <td class="text-muted">
                                {{ $row->deskripsi ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ $row->tipe_masalah ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $row->pengawas->name ?? '-' }}
                            </td>

                            <td class="text-center">
                                @if($row->foto_url)
                                <button class="btn btn-sm btn-outline-info btn-foto" data-bs-toggle="modal"
                                    data-bs-target="#fotoModal" data-foto="{{ asset('storage/'. $row->file_path) }}">
                                    <i class="fa fa-camera"></i>
                                </button>
                                @else
                                -
                                @endif
                            </td>

                            <td class="text-center">
                                @can('kendala.delete')
                                <form action="{{ route('kendala.destroy', $row->id) }}" method="POST"
                                    class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                -
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada laporan kendala.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $kendalas->links('vendor.pagination.bootstrap-first-last') }}
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Modal Foto --}}
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Preview Foto Kendala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="fotoPreview" src="" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

    // ======================
    // FOTO MODAL
    // ======================
    const fotoModal = document.getElementById('fotoModal');

    fotoModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const foto = button.getAttribute('data-foto');
        document.getElementById('fotoPreview').src = foto;
    });

    fotoModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('fotoPreview').src = '';
    });

    // ======================
    // DELETE CONFIRM
    // ======================
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {

            const form = this.closest('.form-delete');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Data kendala yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });
    });

});
</script>
@endpush