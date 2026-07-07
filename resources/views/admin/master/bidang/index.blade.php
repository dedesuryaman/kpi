@extends('layouts.admin.app')
@push('title', 'Master >> Sub Bagian')
@push('css')

@endpush
@push('styles')

@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Bidang</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                    <li class="breadcrumb-item active">Bidang</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<form method="GET">

    <div class="row mb-3">

        <div class="col-md-7">
            <select name="urusan" class="form-select select2">
                <option value="">-- Semua Urusan --</option>
                @foreach($urusans as $urusan)
                <option value="{{ $urusan->kd_urusan }}" {{ request('urusan')==$urusan->kd_urusan ? 'selected' : '' }}>
                    {{ $urusan->nm_urusan }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari kode / nama bidang"
                value="{{ request('search') }}">
        </div>

        <div class="col-md-1">
            <button class="btn btn-primary">
                <i class="fa fa-search"></i> Cari
            </button>
        </div>

    </div>

</form>

<div class="row">
    <div class="card col-12 p-3">
        <div class="table-responsive">

            <table class="table table-sm table-hover" id="tbl-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bidang</th>
                        <th>Urusan</th>

                        <th class="text-center">Kode Urusan</th>
                        <th class="text-center">Kode Bidang</th>
                        <th class="text-center">Kode Fungsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $n=1 @endphp
                    @foreach($bidangs as $row)
                    <tr>
                        <td class="text-center">
                            {{ ($bidangs->currentPage() - 1) * $bidangs->perPage() + $loop->iteration }}
                        </td>
                        <td><a href="{{ url('/master/unit?bidang=' . $row->kd_urusan . '-'. $row->kd_bidang ) }}">{{
                                $row->nm_bidang}}</a></td>
                        <td><a
                                href="{{ url('master/bidang?urusan=' . $row->urusan?->kd_urusan ?? 0 . '-' . $row->urusan?->kd_bidang ?? 0) }}">{{
                                $row->urusan?->nm_urusan ?? ''}}</a></td>

                        <td class="text-center">{{ $row->kd_urusan}}</td>
                        <td class="text-center">{{ $row->kd_bidang}}</td>
                        <td class="text-center">{{ $row->kd_fungsi }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $row->id }}"
                                data-nama="{{ $row->nm_bidang }}" data-urusan="{{ $row->kd_urusan }}"
                                data-bidang="{{ $row->kd_bidang }}" data-fungsi="{{ $row->kd_fungsi }}">
                                <i class="fa fa-edit"></i>
                            </button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        <hr>
        {{ $bidangs->links('vendor.pagination.bootstrap-first-last') }}

    </div>
</div>

<div class="modal fade" id="modalBidang">
    <div class="modal-dialog">
        <form id="formBidang">

            @csrf
            <input type="hidden" id="id">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Update Bidang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Kode Urusan</label>
                        <select id="kd_urusan" class="form-control">
                            <option value="">-- Pilih Urusan --</option>
                            @foreach($urusans as $urusan)
                            <option value="{{ $urusan->kd_urusan }}">
                                {{ $urusan->kd_urusan }} - {{ $urusan->nm_urusan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Kode Bidang</label>
                        <input type="text" id="kd_bidang" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Nama Bidang</label>
                        <input type="text" id="nm_bidang" class="form-control">
                    </div>


                    <div class="mb-3">
                        <label>Kode Fungsi</label>
                        <input type="text" id="kd_fungsi" class="form-control">
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
    $('.select2').select2({ width: '100%' });
});
</script>
<script>
    // buka modal edit
$('.btn-edit').click(function(){
    $('#modalBidang').modal('show');
    $('#id').val($(this).data('id'));
    $('#nm_bidang').val($(this).data('nama'));
    $('#kd_urusan').val($(this).data('urusan')).trigger('change');
    $('#kd_bidang').val($(this).data('bidang'));
    $('#kd_fungsi').val($(this).data('fungsi'));
});

// submit update
$('#formBidang').submit(function(e){

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
            $('#btnUpdate').attr('disabled',true);
            $('#btnUpdate .spinner-border').removeClass('d-none');
            $('#btnUpdate .btn-text').text('Menyimpan...');

            $.ajax({

                url:'/master/bidang/'+id,
                type:'PUT',

                data:{
                    _token:'{{ csrf_token() }}',
                    nm_bidang:$('#nm_bidang').val(),
                    kd_urusan:$('#kd_urusan').val(),
                    kd_bidang:$('#kd_bidang').val(),
                    kd_fungsi:$('#kd_fungsi').val()
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

                error:function(){

                    Swal.fire(
                        'Error',
                        'Terjadi kesalahan',
                        'error'
                    );

                },

                complete:function(){

                    $('#btnUpdate').attr('disabled',false);
                    $('#btnUpdate .spinner-border').addClass('d-none');
                    $('#btnUpdate .btn-text').text('Update');

                }

            });

        }

    });

});

</script>
@endpush