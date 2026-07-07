@extends('layouts.admin.app')
@push('title', 'Akun >> Change Password')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Akun Pengguna</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">Akun</li>
                <li class="breadcrumb-item active">Reset Password</li>
            </ol>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white d-flex align-items-center">
                    <i class="bx bx-user me-2"></i>
                    <h5 class="mb-0 text-light">Update Password</h5>
                </div>


                <div class="card-body">
                    <div id="successMsg" class="alert alert-success d-none"></div>
                    <div id="errorMsg" class="alert alert-danger d-none"></div>

                    <form id="changePasswordForm" autocomplete="off">
                        @csrf

                        {{-- decoy fields (anti autofill chrome) --}}
                        <input type="text" name="username" autocomplete="username" style="display:none">
                        <input type="password" name="password" autocomplete="current-password" style="display:none">

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="cp_x" required
                                autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="np_x" minlength="8"
                                required autocomplete="new-password">
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="cnp_x" minlength="8"
                                required autocomplete="new-password">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function () {

    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();

        const newPass = $('#newPassword').val();
        const confirmPass = $('#confirmPassword').val();

        if (newPass !== confirmPass) {
            $('#errorMsg').removeClass('d-none').text('Konfirmasi password tidak cocok');
            $('#successMsg').addClass('d-none');
            return;
        }

        $('#btnSubmit').prop('disabled', true).text('Processing...');

        $.ajax({
            url: '{{ route("update-password") }}',
            method: 'POST',
            data: {
                currentPassword: $('#currentPassword').val(),
                newPassword: newPass,
                confirmPassword : confirmPass,
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                $('#errorMsg').addClass('d-none');
                $('#successMsg').removeClass('d-none').text(res.message);
                $('#changePasswordForm')[0].reset();
            },
            error: function (xhr) {
                $('#successMsg').addClass('d-none');
                $('#errorMsg')
                    .removeClass('d-none')
                    .text(xhr.responseJSON?.message || 'Terjadi kesalahan');
            },
            complete: function () {
                $('#btnSubmit').prop('disabled', false).text('Change Password');
            }
        });
    });

});
</script>
@endpush