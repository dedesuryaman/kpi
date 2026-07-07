@extends('layouts.admin.app')

@push('title', 'Master >> Sub Unit')

@section('content')
<div class="row">
    <div class="col-12">
        <h4 class="mb-3">Master Data - Sinkronisasi Unit</h4>
    </div>
</div>

<div class="alert alert-info mb-0" role="alert">
    Menurunkan data sub kegiatan dari server untuk tahun aktif {{ session('tahun_aktif') }}
</div>
<div class="row card p-3">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-hover" id="tbl-sub-unit">

            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Sub Unit</th>
                    <th>Alias</th>
                    <th>Tarik Kegiatan</th>
                </tr>
            </thead>
            <tbody>
                @php $n= 1;@endphp
                @foreach($subunits as $row)
                <tr>
                    <td>{{$n++}}</td>
                    <td><a
                            href="{{ route('sub-kegiatan.sub-unit.detail') . '?id=' .  $row->id . '&urusan=' . $row->kd_urusan . '&bidang=' . $row->kd_bidang . '&unit=' . $row->kd_unit . '&sub=' . $row->kd_sub }}">{{
                            $row->nm_sub_unit }}</a></td>
                    <td>{{ $row->alias }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary btn-tarik" data-bs-target="#modalTarik"
                            data-kd_urusan="{{ $row->kd_urusan }}" data-kd_bidang="{{ $row->kd_bidang }}"
                            data-kd_unit="{{ $row->kd_unit }}" data-kd_sub="{{ $row->kd_sub }}"
                            data-tahun="{{ session('tahun_aktif') }}" data-url="{{ route('kegiatan.sync') }}">

                            <i class="fa fa-download"></i>
                        </a>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- ✅ SATU MODAL SAJA -->
<div class="modal fade" id="modalTarik" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Sinkronisasi Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <div class="avatar-md mx-auto mb-3">
                    <div class="avatar-title bg-light rounded-circle text-primary h1">
                        <i class="mdi mdi-cloud-download"></i>
                    </div>
                </div>
                <p>Apakah Anda yakin ingin melakukan penarikan data dari server?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button" class="btn btn-primary" id="btnTarikData">
                    Ya, Tarik Data
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
@endpush
@push('scripts')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
    $('#tbl-sub-unit').DataTable({
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
        ordering: true,
        searching: true,
        info: true,
        responsive: true,
        
        // Kolom yang TIDAK boleh di-sort
        columnDefs: [
        { orderable: false, targets: [0, 3] } // No & tombol
        ],
        
        // Default sort
        order: [[0, 'asc']]
    });
    
    $(document).on('click', '.btn-tarik', function (e) {
    e.preventDefault();

    const modalEl = document.getElementById('modalTarik');
    const modal = new bootstrap.Modal(modalEl);

    // simpan data row ke tombol konfirmasi
    const btnConfirm = $('#btnTarikData');

    btnConfirm.data('kd_urusan', $(this).data('kd_urusan'));
    btnConfirm.data('kd_bidang', $(this).data('kd_bidang'));
    btnConfirm.data('kd_unit', $(this).data('kd_unit'));
    btnConfirm.data('kd_sub', $(this).data('kd_sub'));
    btnConfirm.data('tahun', $(this).data('tahun'));
        btnConfirm.data('url', $(this).data('url'));

    modal.show();
});

// tombol konfirmasi tarik data
$(document).on('click', '#btnTarikData', function () {

    const button = $(this);
    const url = button.data('url');

    const payload = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        kd_urusan: button.data('kd_urusan'),
        kd_bidang: button.data('kd_bidang'),
        kd_unit: button.data('kd_unit'),
        kd_sub: button.data('kd_sub'),
        tahun: button.data('tahun')
    };

    console.log(url);

    // loading state
    button.prop('disabled', true)
          .html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
    
    $.ajax({
        url: url,
        type: 'POST',
        data: payload,
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
            location.reload(); // 🔄 Reload halaman
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
                text: xhr.responseJSON?.message ?? 'Terjadi kesalahan saat sinkronisasi'
            });
        }
    });
});
</script>

@endpush