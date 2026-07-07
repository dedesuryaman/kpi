<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class MyProfileController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;

        abort_if(!$employee, 404);

        return view('employees.my-profile.index', [
            'employee' => $employee,
            'user' => auth()->user(),
        ]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
