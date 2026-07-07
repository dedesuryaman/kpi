<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('name')->get();

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission berhasil dibuat');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission berhasil diperbarui');
    }

    public function destroy(Permission $permission)
    {
        // Optional: proteksi permission inti
        if (in_array($permission->name, [
            'setting.manage',
            'dashboard.view'
        ])) {
            abort(403);
        }

        $permission->delete();

        return back()->with('success', 'Permission berhasil dihapus');
    }
}
