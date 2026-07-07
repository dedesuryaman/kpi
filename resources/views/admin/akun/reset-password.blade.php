@extends('layouts.admin.app')
@push('title', 'Akun >> Change Password')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Akun Pengguna</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">Akun</li>
                    <li class="breadcrumb-item active">Reset Password</li>
                </ol>
            </div>
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

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>

                            <div class="input-group">

                                <input type="password" name="password" autocomplete="new-password" style="display:none">

                                <button type="button" class="btn btn-secondary btn-sm" id="togglePassword"
                                    title="Lihat / Sembunyikan">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <input type="password" class="form-control" id="newPassword" name="new-password-change"
                                    placeholder="Password baru" minlength="8" required
                                    autocomplete="new-password-change">

                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnCopy"
                                    title="Copy password">
                                    Copy
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnGenerate"
                                    title="Generate password">
                                    Generate
                                </button>
                            </div>

                            <small class="text-muted">
                                Minimal 8 karakter. Bisa diisi manual atau digenerate otomatis.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-save me-1"></i> Change Password
                        </button>
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

    const $passwordInput = $('#newPassword');
    const $successMsg = $('#successMsg');
    const $errorMsg = $('#errorMsg');

    function showSuccess(message) {
        $errorMsg.addClass('d-none');
        $successMsg.removeClass('d-none').text(message);
    }

    function showError(message) {
        $successMsg.addClass('d-none');
        $errorMsg.removeClass('d-none').text(message);
    }

    function generatePassword(length = 10) {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
        return Array.from({ length }, () =>
            chars.charAt(Math.floor(Math.random() * chars.length))
        ).join('');
    }

    function copyToClipboard(text, message) {
        if (!text) {
            showError('Password masih kosong.');
            return;
        }

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                showSuccess(message);
            }).catch(() => {
                showError('Gagal menyalin ke clipboard.');
            });
        } else {
            const temp = $('<input>');
            $('body').append(temp);
            temp.val(text).select();
            document.execCommand('copy');
            temp.remove();
            showSuccess(message);
        }
    }

    // 👁 Toggle show/hide password
    $('#togglePassword').on('click', function () {
        const type = $passwordInput.attr('type') === 'password' ? 'text' : 'password';
        $passwordInput.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // 🔐 Generate
    $('#btnGenerate').on('click', function () {
        const generated = generatePassword(10);
        $passwordInput.val(generated).focus();
        copyToClipboard(generated, 'Password berhasil digenerate & disalin ke clipboard.');
    });

    // 📋 Copy
    $('#btnCopy').on('click', function () {
        copyToClipboard(
            $passwordInput.val(),
            'Password berhasil disalin ke clipboard.'
        );
    });

    // 🚀 Submit
    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: `{{ route("admin.akun.update-password", $user->id) }}`,
            type: 'POST',
            data: {
                newPassword: $passwordInput.val(),
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                showSuccess(res.message);
                $passwordInput.val('');
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message || 'Terjadi kesalahan.');
            }
        });
    });

});
</script>
@endpush