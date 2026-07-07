<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function index()
	{
		$users = User::latest()
			->paginate(10);

		return view('users.index', compact('users'));
	}

	public function create()
	{
		$employees = Employee::orderBy('name')->get();

		$roles = Role::orderBy('name')->get();

		return view(
			'users.create',
			compact(
				'employees',
				'roles'
			)
		);
	}

	public function store(Request $request)
	{
		$request->validate([
			'employee_id' => 'required|exists:employees,id',
			'username'    => 'required|string|max:255|unique:users,username',
			'email'       => 'required|email|unique:users,email',
			'password'    => 'required|min:6',
			'roles'       => 'required|array',
			'roles.*'     => 'exists:roles,id',
		]);

		$user = User::create([
			'employee_id' => $request->employee_id,
			'username'    => $request->username,
			'email'       => $request->email,
			'password'    => Hash::make($request->password),
			'status'      => $request->status ?? 'active',
		]);

		$user->roles()->sync(
			$request->roles
		);

		return redirect()
			->route('users.index')
			->with(
				'success',
				'User created successfully.'
			);
	}

	public function show(User $user)
	{
		$user->load([
			'employee',
			'roles'
		]);

		return view(
			'users.show',
			compact('user')
		);
	}

	public function edit(User $user)
	{
		$employees = Employee::orderBy('name')->get();

		$roles = Role::orderBy('name')->get();

		$selectedRoles = $user
			->roles
			->pluck('id')
			->toArray();

		return view(
			'users.edit',
			compact(
				'user',
				'employees',
				'roles',
				'selectedRoles'
			)
		);
	}

	public function update(
		Request $request,
		User $user
	) {
		$request->validate([
			'employee_id' => 'required|exists:employees,id',
			'username'    => 'required|string|max:255|unique:users,username,' . $user->id,
			'email'       => 'required|email|unique:users,email,' . $user->id,
			'roles'       => 'required|array',
			'roles.*'     => 'exists:roles,id',
		]);

		$data = [
			'employee_id' => $request->employee_id,
			'username'    => $request->username,
			'email'       => $request->email,
			'status'      => $request->status ?? 'active',
		];

		if ($request->filled('password')) {

			$data['password'] = Hash::make(
				$request->password
			);
		}

		$user->update($data);

		$user->roles()->sync(
			$request->roles
		);

		return redirect()
			->route('users.index')
			->with(
				'success',
				'User updated successfully.'
			);
	}

	public function destroy(User $user)
	{
		if ($user->id === auth()->id()) {

			return back()->with(
				'error',
				'You cannot delete your own account.'
			);
		}

		$user->roles()->detach();

		$user->delete();

		return redirect()
			->route('users.index')
			->with(
				'success',
				'User deleted successfully.'
			);
	}

	public function resetPassword(User $user)
	{
		$user->update([
			'password' => Hash::make('12345678')
		]);

		return back()->with(
			'success',
			'Password reset successfully. New password: 12345678'
		);
	}

	public function toggleStatus(User $user)
	{
		$user->update([
			'status' => $user->status === 'active'
				? 'inactive'
				: 'active'
		]);

		return back()->with(
			'success',
			'User status updated.'
		);
	}
}
