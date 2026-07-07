<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cookie;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus cookie laravel_session
        Cookie::queue(Cookie::forget('laravel_session'));

        $roles = Role::orderBy('name')
            ->orderBy('name')
            ->get();

        return view('layouts.login', ['roles' => $roles]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();



        if ($user) {
            activity('auth')
                ->performedOn($user)
                ->causedBy($user)
                ->event('login')
                ->withProperties([
                    'user_id'    => $user->id,
                    'nama'       => $user->name,
                    'email'      => $user->email,
                    'role'       => $user->getRoleNames()->implode(', '),
                    'ip'         => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'login_at'   => now()->toDateTimeString(),
                ])
                ->log('Login sistem');
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            activity('auth')
                ->performedOn($user)
                ->causedBy($user)
                ->event('logout')
                ->withProperties([
                    'user_id'    => $user->id,
                    'nama'       => $user->name,
                    'email'      => $user->email,
                    'role'       => $user->getRoleNames()->implode(', '),
                    'ip'         => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'logout_at'  => now()->toDateTimeString(),
                ])
                ->log('Logout sistem');
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
