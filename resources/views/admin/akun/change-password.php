@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Akun Pengguna</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Akun</a></li>
                    <li class="breadcrumb-item active">Reset Password</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="container mt-5">
    <h2 class="mb-4">Change Password</h2>

    <!-- Alert Messages -->
    <div id="successMsg" class="alert alert-success d-none"></div>
    <div id="errorMsg" class="alert alert-danger d-none"></div>

    <form id="changePasswordForm">
        @csrf
        <!-- Laravel CSRF token -->
        <div class="mb-3">
            <label for="currentPassword" class="form-label">Name</label>
            <input type="text" class="form-control" readonly value="{{ $user->name }}">
        </div>
        <div class="mb-3">
            <label for="currentPassword" class="form-label">Email</label>
            <input type="text" class="form-control" value="{{$user->email}}" readonly>
        </div>

        <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
        </div>

        <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
        </div>

        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>


@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#changePasswordForm').submit(function(e) {
            e.preventDefault();

            const data = {
                currentPassword: $('#currentPassword').val(),
                newPassword: $('#newPassword').val(),
                confirmPassword: $('#confirmPassword').val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: `{{ route("admin.akun.update-password", $user->id) }}`, // ganti dengan route Laravel
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#errorMsg').addClass('d-none');
                    $('#successMsg').removeClass('d-none').text(response.message);
                    $('#changePasswordForm')[0].reset();
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.message || 'Something went wrong';
                    $('#successMsg').addClass('d-none');
                    $('#errorMsg').removeClass('d-none').text(errors);
                }
            });
        });
    });
</script>
@endpush