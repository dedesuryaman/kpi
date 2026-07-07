@extends('layouts.admin.app')
@push('title', 'Master >> Urusan')
@push('css')

@endpush
@push('styles')

@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Urusan</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Urusan</a></li>
                    <li class="breadcrumb-item active">Urusan</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="card shadow shadow-sm">
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Kode Urusan</th>
                    <th>Nama Urusan</th>
                    <th class="text-center">Jumlah Bidang</th>

                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($urusans as $urusan)
                <tr>
                    <td>{{ $urusan->kd_urusan }}</td>
                    <td><a href="{{ url('master/bidang?urusan=' . $urusan->kd_urusan ) }}">{{ $urusan->nm_urusan }}</a>
                    </td>
                    <td class="text-center">{{ $urusan->bidangs->count() }}</td>
                    <td>

                        <button class="btn btn-sm btn-secondary btn-edit" data-id="{{ $urusan->id }}"
                            data-kode="{{ $urusan->kd_urusan }}" data-nama="{{ $urusan->nm_urusan }}"
                            data-bs-toggle="modal" data-bs-target="#modalEditUrusan">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modalEditUrusan" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEditUrusan">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Urusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Kode Urusan</label>
                        <input type="text" id="edit_kd_urusan" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Nama Urusan</label>
                        <input type="text" id="edit_nm_urusan" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit" id="btnSimpan">
                        <span class="btn-text">Update</span>
                        <span class="spinner-border spinner-border-sm d-none" id="spinnerBtn"></span>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $('.btn-edit').click(function(){

    let id = $(this).data('id');
    let kode = $(this).data('kode');
    let nama = $(this).data('nama');

    $('#edit_id').val(id);
    $('#edit_kd_urusan').val(kode);
    $('#edit_nm_urusan').val(nama);

});


$('#formEditUrusan').submit(function(e){

    e.preventDefault();

    let id = $('#edit_id').val();

    Swal.fire({
        title: 'Yakin update data?',
        text: "Data urusan akan diperbarui",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if(result.isConfirmed){
            // tampilkan spinner
            $('#btnSimpan').attr('disabled', true);
            $('#spinnerBtn').removeClass('d-none');
            $('.btn-text').text('Menyimpan...');

            $.ajax({
                url: '/master/urusan/' + id,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    kd_urusan: $('#edit_kd_urusan').val(),
                    nm_urusan: $('#edit_nm_urusan').val()
                },

                success: function(response){

                    Swal.fire(
                        'Berhasil!',
                        'Data berhasil diupdate',
                        'success'
                    ).then(()=>{
                        location.reload();
                    });

                },

                error: function(){
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan',
                        'error'
                    );
                },
                
                complete:function(){
                
                    // kembalikan tombol normal
                    $('#btnSimpan').attr('disabled', false);
                    $('#spinnerBtn').addClass('d-none');
                    $('.btn-text').text('Update');
                    
                }

            });

        }

    });

});

</script>
@endpush