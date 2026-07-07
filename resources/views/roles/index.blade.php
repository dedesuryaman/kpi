@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-user-shield text-primary me-2"></i>
                Role Management
            </h4>
            <p class="text-muted mb-0">
                Manage system roles and their assigned permissions.
            </p>
        </div>

        @can('role.create')
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Add Role
        </a>
        @endcan

    </div>

    <!-- Card -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-semibold">
                Role List
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle table-hover">

                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="220">Role</th>
                            <th>Permissions</th>
                            <th width="180" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($roles as $role)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center">

                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                                        style="width:40px;height:40px;">

                                        <i class="fas fa-user-shield"></i>

                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $role->name }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $role->permissions->count() }}
                                            Permission(s)
                                        </small>
                                    </div>

                                </div>
                            </td>

                            <td>

                                @forelse($role->permissions as $permission)

                                <span class="badge bg-light text-dark border me-1 mb-1">
                                    {{ $permission->name }}
                                </span>

                                @empty

                                <span class="text-muted">
                                    No permissions assigned
                                </span>

                                @endforelse

                            </td>

                            <td class="text-center">

                                <div class="btn-group">

                                    <a href="{{ route('roles.edit',$role) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                        data-url="{{ route('roles.destroy', $role) }}" data-name="{{ $role->name }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="4">

                                <div class="text-center py-5">

                                    <i class="fas fa-user-shield fa-3x text-muted mb-3"></i>

                                    <h6 class="fw-semibold">
                                        No Roles Found
                                    </h6>

                                    <p class="text-muted mb-0">
                                        Start by creating your first role.
                                    </p>

                                </div>

                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-delete').forEach(button => {

        button.addEventListener('click', function () {

            const url = this.dataset.url;
            const name = this.dataset.name;

            Swal.fire({
                title: 'Delete Role?',
                html: `Role <b>${name}</b> will be permanently deleted.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545'
            }).then((result) => {

                if (result.isConfirmed) {

                    const form = document.createElement('form');

                    form.method = 'POST';
                    form.action = url;

                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;

                    document.body.appendChild(form);

                    form.submit();
                }

            });

        });

    });

});
</script>
@endpush