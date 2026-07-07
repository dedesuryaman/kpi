@extends('layouts.admin.app')
@push('title', 'Master >> Unit')
@push('css')

@endpush
@push('styles')

@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Unit</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Unit</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<form method="GET" class="mb-3">
    <div class="row g-3 align-items-end">

        <!-- Urusan / Bidang -->
        <div class="col-md-7">
            <label for="kd_bidang_filter" class="form-label">Urusan / Bidang</label>
            <select name="bidang" id="kd_bidang_filter" class="form-select select2">
                <option value="">-- Semua Bidang --</option>

                @foreach($bidangs->groupBy('urusan.nm_urusan') as $urusan => $rows)
                <optgroup label="{{ $urusan }}">
                    @foreach($rows as $bidang)

                    @php
                    $kode = $bidang->kd_urusan . '-' . $bidang->kd_bidang;
                    @endphp

                    <option value="{{ $kode }}" {{ request('bidang')==$kode ? 'selected' : '' }}>
                        {{ $bidang->kd_bidang }} - {{ $bidang->nm_bidang }}
                    </option>

                    @endforeach
                </optgroup>
                @endforeach

            </select>
        </div>

        <!-- Search -->
        <div class="col-md-3">
            <label for="search" class="form-label">Search</label>
            <input type="text" id="search" name="search" class="form-control" placeholder="Cari kode / nama unit"
                value="{{ request('search') }}">
        </div>

        <!-- Button -->
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i> Cari
            </button>
        </div>

    </div>
</form>

<div class="row">
    <div class="card col-12 p-3">
        <div class="table-responsive">

            <table class="table table-sm table-hover" id="tbl-unit">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Unit</th>
                        <th>Bidang</th>
                        <th>Urusan</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $n=1 @endphp
                    @foreach($units as $row)
                    <tr>
                        <td class="text-center">
                            {{ ($units->currentPage() - 1) * $units->perPage() + $loop->iteration }}
                        </td>
                        <td><a
                                href="{{ url('master/sub-unit?unit=' . $row->kd_urusan .'-' . $row->kd_bidang .'-' .$row->kd_unit ) }}">{{
                                $row->nm_unit}}</a></td>
                        <td>{{ $row->bidang?->nm_bidang ?? ''}}</td>
                        <td>{{ $row->urusan?->nm_urusan ?? ''}}</td>
                        <td>{{ $row->kd_unit90 }}</td>

                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $row->id }}"
                                data-nama="{{ $row->nm_unit }}" data-bidang="{{ $row->kd_bidang }}"
                                data-urusan="{{ $row->kd_urusan }}" data-kode="{{ $row->kd_unit90 }}">
                                <i class="fa fa-edit"></i>
                            </button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>


            @if($units->hasPages())
            <div class="mt-3">
                {{ $units->links('vendor.pagination.bootstrap-first-last') }}
            </div>
            @endif
        </div>

    </div>
</div>
<div class="modal fade" id="modalUnit">
    <div class="modal-dialog">
        <form id="formUnit">
            @csrf
            <input type="hidden" id="id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Urusan</label>
                        <select id="kd_urusan" class="form-control select2" style="width: 100%;">
                            <option value="">-- Pilih Urusan --</option>
                            @foreach($urusans as $urusan)
                            <option value="{{ $urusan->kd_urusan }}">
                                {{ $urusan->kd_urusan }} - {{ $urusan->nm_urusan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Bidang</label>
                        <select id="kd_bidang" class="form-control select2" style="width: 100%;">
                            <option value="">-- Pilih Bidang --</option>
                            @foreach($bidangs as $bidang)
                            <option value="{{ $bidang->kd_bidang }}">{{ $bidang->nm_bidang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nama Unit</label>
                        <input type="text" id="nm_unit" class="form-control">
                    </div>





                    <div class="mb-3">
                        <label>Kode Unit</label>
                        <input type="text" id="kd_unit90" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnUpdate" type="submit">
                        <span class="spinner-border spinner-border-sm me-2 d-none"></span>
                        <span class="btn-text">Update</span>
                    </button>
                </div>

            </div>
        </form>
    </div>
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
    $('#kd_bidang_filter').select2({
    width: '100%'
    });


    // onchange urusan → update bidang
    $('#kd_urusan').on('change', function(){
        let kd_urusan = $(this).val();


        $('#kd_bidang').empty().append('<option value="">-- Pilih Bidang --</option>');

        if(kd_urusan){
            $.ajax({
                url: '/master/bidangs/by-urusan/' + kd_urusan,
                type: 'GET',
                success: function(data){
                    $.each(data, function(i, bidang){
                        $('#kd_bidang').append('<option value="'+bidang.kd_bidang+'">'+bidang.nm_bidang+'</option>');
                    });
                    $('#kd_bidang').val(null).trigger('change'); // reset select2
                }
            });
        }
    });

});
</script>

<script>
    $(document).ready(function(){

    $('#kd_urusan, #kd_bidang').select2({
        dropdownParent: $('#modalUnit'),
        width: '100%'
    });

    // tombol edit
    $('.btn-edit').click(function(){
        $('#modalUnit').modal('show');

        let id = $(this).data('id');
        let nm_unit = $(this).data('nama');
        let kd_urusan = $(this).data('urusan');
        let kd_bidang = $(this).data('bidang');
        let kd_unit90 = $(this).data('kode');

        $('#id').val(id);
        $('#nm_unit').val(nm_unit);
        $('#kd_urusan').val(kd_urusan).trigger('change');

        // Simpan bidang awal agar dipilih setelah AJAX
        $('#kd_bidang').data('selected', kd_bidang);

        $('#kd_unit90').val(kd_unit90);
    });

    // onchange urusan → update bidang
    $('#kd_urusan').on('change', function(){
        let kd_urusan = $(this).val();

        $('#kd_bidang').empty().append('<option value="">-- Pilih Bidang --</option>');

        if(kd_urusan){
            $.ajax({
                url: '/master/bidangs/by-urusan/' + kd_urusan,
                type: 'GET',
                success: function(data){
                    $.each(data, function(i, bidang){
                        $('#kd_bidang').append('<option value="'+bidang.kd_bidang+'">'+bidang.nm_bidang+'</option>');
                    });

                    // pilih bidang sesuai data awal jika ada
                    let selectedBidang = $('#kd_bidang').data('selected');
                    if(selectedBidang){
                        $('#kd_bidang').val(selectedBidang).trigger('change');
                        $('#kd_bidang').data('selected', null); // reset
                    } else {
                        $('#kd_bidang').val(null).trigger('change');
                    }
                }
            });
        } else {
            $('#kd_bidang').val(null).trigger('change');
        }
    });

    // submit update
    $('#formUnit').submit(function(e){
        e.preventDefault();

        let id = $('#id').val();

        Swal.fire({
            title:'Update data?',
            icon:'question',
            showCancelButton:true,
            confirmButtonText:'Ya'
        }).then((result)=>{
            if(result.isConfirmed){

                // spinner
                $('#btnUpdate').attr('disabled', true);
                $('#btnUpdate .spinner-border').removeClass('d-none');
                $('#btnUpdate .btn-text').text('Menyimpan...');

                $.ajax({
                    url: '/master/unit/' + id,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nm_unit: $('#nm_unit').val(),
                        kd_bidang: $('#kd_bidang').val(),
                        kd_urusan: $('#kd_urusan').val(),
                        kd_unit90: $('#kd_unit90').val()
                    },
                    success:function(){
                        Swal.fire(
                            'Berhasil',
                            'Data berhasil diupdate',
                            'success'
                        ).then(()=>{
                            location.reload();
                        });
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
                        $('#btnUpdate').attr('disabled', false);
                        $('#btnUpdate .spinner-border').addClass('d-none');
                        $('#btnUpdate .btn-text').text('Update');
                    }
                });

            }
        });
    });


});
</script>

@endpush