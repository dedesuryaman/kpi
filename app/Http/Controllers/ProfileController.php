<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $employee = null;

        if ($user->employee_id) {
            $employee = Employee::with([
                'department',
                'position',
                'leader',
            ])->find($user->employee_id);
        }


        return view('profile.index', compact('user', 'employee'));
    }


    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        // Update akun
        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Jika memiliki employee, sinkronkan
        if ($user->employee) {
            $user->employee->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
