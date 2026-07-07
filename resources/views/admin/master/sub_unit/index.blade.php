@extends('layouts.admin.app')

@push('title', 'Master >> Sub Unit')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-semibold mb-1">Master Data Sub Unit</h4>
                <small class="text-muted">
                    Tahun Aktif : {{ session('tahun_aktif') }}
                </small>
            </div>
        </div>
    </div>
</div>

<form method="GET" class="mb-3">
    <div class="row g-3 align-items-end">

        <div class="col-md-7">
            <label class="form-label">Unit</label>
            <select name="unit" class="form-select select2">
                <option value="">-- Semua Unit --</option>

                @foreach($units->groupBy('bidang.nm_bidang') as $bidang => $rows)
                <optgroup label="{{ $bidang }}">
                    @foreach($rows as $unit)

                    @php
                    $kode = $unit->kd_urusan . '-' . $unit->kd_bidang . '-' . $unit->kd_unit;
                    @endphp

                    <option value="{{ $kode }}" {{ request('unit')==$kode ? 'selected' : '' }}>
                        {{ $unit->nm_unit }}
                    </option>

                    @endforeach
                </optgroup>
                @endforeach

            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Cari kode / nama subunit"
                value="{{ request('search') }}">
        </div>

        <div class="col-md-1 d-grid">
            <button class="btn btn-primary">
                <i class="fa fa-search"></i>
            </button>
        </div>

    </div>
</form>



<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 fw-semibold">Daftar Sub Unit</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive mb-3">
            <table class="table table-sm table-hover align-middle mb-0" id="tbl-sub-unit" width="100%">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Sub Unit</th>
                        <th>Alias</th>
                        <th class="text-center">Kode Urusan</th>
                        <th class="text-center">Kode Bidang</th>
                        <th class="text-center">Kode Unit</th>

                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $n = 1; @endphp
                    @foreach($subunits as $row)
                    <tr>
                        <td>{{ $n++ }}</td>

                        <td>
                            <a href="{{ route('sub-kegiatan.sub-unit.detail') . 
                                '?id=' .  $row->id .
                                '&urusan=' . $row->kd_urusan .
                                '&bidang=' . $row->kd_bidang .
                                '&unit=' . $row->kd_unit .
                                '&sub=' . $row->kd_sub }}" class="fw-semibold text-decoration-none">
                                {{ $row->nm_sub_unit }}
                            </a>
                        </td>

                        <td>{{ $row->alias }}</td>
                        <td class="text-center">{{ $row->kd_urusan }}</td>
                        <td class="text-center">{{ $row->kd_bidang }}</td>
                        <td class="text-center">{{ $row->kd_unit }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary btn-update" data-bs-toggle="modal"
                                data-bs-target="#modalUpdate" data-id="{{ $row->id }}"
                                data-kd_urusan="{{ $row->kd_urusan }}" data-kd_bidang="{{ $row->kd_bidang }}"
                                data-kd_unit="{{ $row->kd_unit }}" data-kd_sub="{{ $row->kd_sub }}"
                                data-nm_sub_unit="{{ $row->nm_sub_unit }}" data-alias="{{ $row->alias }}">
                                <i class="fa fa-edit"></i> Update
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        @if($subunits->hasPages())
        <div class="mt-3">
            {{ $subunits->links('vendor.pagination.bootstrap-first-last') }}
        </div>
        @endif
    </div>
</div>
<div class="modal fade" id="modalUpdate" tabindex="-1" aria-hidden="true">
    <form id="formSubUnit">
        @csrf
        <input type="hidden" id="id_subunit">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Sub Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Urusan</label>
                        <select id="kd_urusan" class="form-control select2" style="width: 100%;">
                            <option value="">-- Pilih Urusan --</option>
                            @foreach($urusans as $urusan)
                            <option value="{{ $urusan->kd_urusan }}">{{ $urusan->kd_urusan }} - {{ $urusan->nm_urusan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Bidang</label>
                        <select id="kd_bidang" class="form-control select2" style="width: 100%;">
                            <option value="">-- Pilih Bidang --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Unit</label>
                        <select id="kd_unit" class="form-control select2" style="width: 100%;">
                            <option value="">-- Pilih Unit --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nama Sub Unit</label>
                        <input type="text" id="nm_sub_unit" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Alias</label>
                        <input type="text" id="alias" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnUpdateSubUnit">
                        <span class="spinner-border spinner-border-sm me-2 d-none"></span>
                        <span class="btn-text">Update</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('css')
<!-- CSS -->
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
@endpush
@push('scripts')

<!-- JS -->
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function(){
    $('.select2').select2({ width: '100%' });
});
</script>

<script>
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

    $(document).ready(function(){

    // Init select2
    $('#kd_urusan, #kd_bidang, #kd_unit').select2({
        dropdownParent: $('#modalUpdate'),
        width: '100%'
    });

    // Tombol tarik
    $('.btn-update').click(function(){
        let button = $(this);

        $('#id_subunit').val(button.data('id'));
        $('#nm_sub_unit').val(button.data('nm_sub_unit'));
        $('#alias').val(button.data('alias'));
        $('#kd_urusan').val(button.data('kd_urusan')).trigger('change');

        // Simpan bidang & unit selected agar setelah AJAX bisa dipilih
        $('#kd_bidang').data('selected', button.data('kd_bidang'));
        $('#kd_unit').data('selected', button.data('kd_unit'));

        $('#kd_bidang').empty().append('<option value="">-- Pilih Bidang --</option>');
        $('#kd_unit').empty().append('<option value="">-- Pilih Unit --</option>');
    });

    // OnChange Urusan → load Bidang
    $('#kd_urusan').on('change', function(){
        let kd_urusan = $(this).val();
        $('#kd_bidang').empty().append('<option value="">-- Pilih Bidang --</option>');
        $('#kd_unit').empty().append('<option value="">-- Pilih Unit --</option>');

        if(!kd_urusan) return;

        $.getJSON('/master/bidangs/by-urusan/'+kd_urusan, function(data){
            $.each(data, function(i, bidang){
                $('#kd_bidang').append('<option value="'+bidang.kd_bidang+'">'+bidang.nm_bidang+'</option>');
            });

            let selectedBidang = $('#kd_bidang').data('selected');
            if(selectedBidang){
                $('#kd_bidang').val(selectedBidang).trigger('change');
                $('#kd_bidang').data('selected', null);
            }
        });
    });

    // OnChange Bidang → load Unit
    $('#kd_bidang').on('change', function(){
        let kd_urusan = $('#kd_urusan').val();
        let kd_bidang = $(this).val();
        $('#kd_unit').empty().append('<option value="">-- Pilih Unit --</option>');

        if(!kd_urusan || !kd_bidang) return;

        $.getJSON('/master/units/by-bidang/'+kd_urusan+'/'+kd_bidang, function(data){
            $.each(data, function(i, unit){
                $('#kd_unit').append('<option value="'+unit.kd_unit+'">'+unit.nm_unit+'</option>');
            });

            let selectedUnit = $('#kd_unit').data('selected');
            if(selectedUnit){
                $('#kd_unit').val(selectedUnit).trigger('change');
                $('#kd_unit').data('selected', null);
            }
        });
    });

    // Submit form AJAX
    $('#formSubUnit').submit(function(e){
        e.preventDefault();
        let id = $('#id_subunit').val();

        Swal.fire({
            title:'Update Sub Unit?',
            icon:'question',
            showCancelButton:true,
            confirmButtonText:'Ya'
        }).then((result)=>{
            if(result.isConfirmed){
                $('#btnUpdateSubUnit').attr('disabled', true);
                $('#btnUpdateSubUnit .spinner-border').removeClass('d-none');
                $('#btnUpdateSubUnit .btn-text').text('Menyimpan...');

                $.ajax({
                    url:'/master/sub-unit/'+id,
                    type:'PUT',
                    data:{
                        _token:'{{ csrf_token() }}',
                        kd_urusan:$('#kd_urusan').val(),
                        kd_bidang:$('#kd_bidang').val(),
                        kd_unit:$('#kd_unit').val(),
                        nm_sub_unit:$('#nm_sub_unit').val(),
                        alias:$('#alias').val()
                    },
                    success:function(){
                        Swal.fire('Berhasil','Data berhasil diupdate','success').then(()=> location.reload());
                    },
                    error:function(xhr){
                        let errors = xhr.responseJSON?.errors;
                        if(errors){
                            let msg = Object.values(errors).flat().join("\n");
                            Swal.fire('Error', msg, 'error');
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan', 'error');
                        }
                    },
                    complete:function(){
                        $('#btnUpdateSubUnit').attr('disabled', false);
                        $('#btnUpdateSubUnit .spinner-border').addClass('d-none');
                        $('#btnUpdateSubUnit .btn-text').text('Update');
                    }
                });
            }
        });
    });

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