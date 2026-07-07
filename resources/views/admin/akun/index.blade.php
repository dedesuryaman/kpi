@extends('layouts.admin.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0 font-size-18">Daftar Pengguna</h4>

			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Akun</a></li>
					<li class="breadcrumb-item active">Akun Pengguna</li>
				</ol>
			</div>

		</div>
	</div>
</div>
@php
$currentUser = auth()->user();
$myRoles = $currentUser->getRoleNames()->map(fn($r) => str_replace('_', ' ', $r))->implode(', ');
@endphp

<div class="row mb-3">
	<div class="col-12">
		<div class="alert alert-info">
			<strong>Hak Akses Anda:</strong> {{ $myRoles }}
		</div>
	</div>
</div>

@can('user.create')
<div class="row ">
	<div class="col-12 text-end mb-3">
		<a class="btn btn-primary btn-sm" href="{{ route('users.create') }}" type="button">Tambah Akun</a>
	</div>
</div>
@endcan

<div class="table-responsive">
	<table class="table align-middle table-nowrap table-hover">
		<thead class="table-light">
			<tr>
				<th scope="col" style="width: 70px;">#</th>
				<th scope="col">Name</th>
				<th scope="col">Email</th>
				<th scope="col">Roles</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>
					@if($user->avatar)
					<div class="avatar-xs">
						<img class="rounded-circle avatar-xs" src="{{ asset('storage/'.$user->avatar) }}" alt="">
					</div>
					@else
					<div class="avatar-xs">
						<span class="avatar-title rounded-circle">
							{{ strtoupper(substr($user->name ?? '?', 0, 1)) }}
						</span>
					</div>
					@endif
				</td>
				<td>
					<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{ $user->name }}</a>
					</h5>
					@foreach($user->kontraktors as $kon)
					<div class="">{{ $kon->name }}</div>
					@endforeach
					@foreach($user->opds as $opd)
					<div class="">{{ $opd->name }}</div>
					@endforeach
				</td>
				<td>{{ $user->email }}</td>
				<td>
					<div>
						@foreach($user->getRoleNames() as $role)
						<span class="badge bg-success">{{ str_replace('_', ' ', $role) }}</span>
						@endforeach
					</div>
				</td>

				<td>
					<ul class="list-inline font-size-20 contact-links mb-0">
						@can('user.edit')
						<li class="list-inline-item px-2">
							<a href="{{ route('users.show', $user )}}" title="Profile"><i
									class="bx bx-user-circle"></i></a>
						</li>
						@endcan
						@can('user.delete')
						<li class="list-inline-item px-2">
							<a href="#" class="btn-delete-user" data-url="{{ route('users.destroy', $user) }}"
								title="Delete User">
								<i class="bx bx-trash"></i>
							</a>
						</li>
						@endcan
					</ul>
				</td>
			</tr>
			@endforeach

		</tbody>
	</table>
</div>


<div class="mt-3">
	{{ $users->links() }}
</div>

@endsection

@push('scripts')

<script>
	$(document).ready(function() {
    $('.btn-delete-user').click(function(e) {
        e.preventDefault();

        const url = $(this).data('url');
		
		console.log(url);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit form dynamically for DELETE request
                const form = $('<form>', {
                    method: 'POST',
                    action: url
                });

                const token = $('meta[name="csrf-token"]').attr('content');

                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: token
                }));
                form.append($('<input>', {
                    type: 'hidden',
                    name: '_method',
                    value: 'DELETE'
                }));

                form.appendTo('body').submit();
            }
        });
    });
});
</script>

@endpush