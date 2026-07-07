@extends('layouts.admin.app')

@section('content')

@php
$currentUser = auth()->user();

$myRoles = $currentUser
->getRoleNames()
->map(fn($role) => str_replace('_', ' ', $role))
->implode(', ');
@endphp

<div class="container-fluid">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="fas fa-users-cog text-primary me-2"></i>
                User Management
            </h4>

            <p class="text-muted mb-0">
                Manage user accounts, roles and access permissions.
            </p>

        </div>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Add User
        </a>

    </div>

    <!-- Current Access -->

    <div class="alert alert-primary border-0 shadow-sm">

        <div class="d-flex align-items-center">

            <i class="fas fa-user-shield me-3 fs-4"></i>

            <div>

                <strong>Your Roles</strong>

                <div>
                    {{ $myRoles ?: 'No Role Assigned' }}
                </div>

            </div>

        </div>

    </div>

    <!-- Card -->

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0">

            <div class="d-flex justify-content-between align-items-center">

                <h6 class="mb-0 fw-semibold">
                    User List
                </h6>

                <span class="badge bg-primary">
                    {{ $users->total() }} Users
                </span>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle table-hover">

                    <thead class="table-light">

                        <tr>

                            <th width="70">#</th>

                            <th>User</th>

                            <th>Email</th>

                            <th width="220">Roles</th>

                            <th width="150" class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                        <tr>

                            <td>

                                @if($user->avatar)

                                <img src="{{ asset('storage/'.$user->avatar) }}" class="rounded-circle" width="42"
                                    height="42">

                                @else

                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width:42px;height:42px;">

                                    {{ strtoupper(substr($user->name,0,1)) }}

                                </div>

                                @endif

                            </td>

                            <td>

                                <div class="fw-semibold">
                                    {{ $user->name }}
                                </div>

                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>

                                @forelse($user->getRoleNames() as $role)

                                <span class="badge bg-success me-1">
                                    {{ str_replace('_', ' ', $role) }}
                                </span>

                                @empty

                                <span class="badge bg-secondary">
                                    No Role
                                </span>

                                @endforelse

                            </td>

                            <td class="text-center">

                                <div class="btn-group">

                                    <a href="{{ route('users.show',$user) }}" class="btn btn-sm btn-outline-primary">

                                        <i class="fas fa-eye"></i>

                                    </a>
                                    <a href="{{ route('users.edit',$user) }}" class="btn btn-sm btn-outline-warning">

                                        <i class="fas fa-edit"></i>

                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-user"
                                        data-url="{{ route('users.destroy',$user) }}" data-name="{{ $user->name }}">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5">

                                <div class="text-center py-5">

                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>

                                    <h6>
                                        No Users Found
                                    </h6>

                                    <p class="text-muted mb-0">
                                        Start by creating your first user account.
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

    <div class="mt-3">
        {{ $users->links() }}
    </div>

</div>

@endsection

@push('scripts')

<script>
    $(function(){

    $('.btn-delete-user').on('click', function(){

        let url = $(this).data('url');
        let name = $(this).data('name');

        Swal.fire({

            title: 'Delete User?',
            html: `User <b>${name}</b> will be permanently deleted.`,
            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            confirmButtonText: 'Delete',

            cancelButtonText: 'Cancel'

        }).then((result)=>{

            if(result.isConfirmed){

                const form = $('<form>',{
                    action:url,
                    method:'POST'
                });

                form.append('@csrf');
                form.append('<input type="hidden" name="_method" value="DELETE">');

                $('body').append(form);

                form.submit();

            }

        });

    });

});

</script>

@endpush