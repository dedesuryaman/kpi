<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {

        return view('roles.index', [
            'roles' => Role::with('permissions')
                ->whereNotIn('name', ['sys_admin', 'super_admin'])
                ->get()
        ]);
    }

    public function create()
    {
        $permissions = Permission::query()
            ->orderBy('name')

            ->when(
                !auth()->user()->hasAnyRole(['sys_admin', 'super_admin']),
                function ($q) {
                    $q->whereNotIn('name', [
                        'role.view',
                        'role.create',
                        'role.edit',
                        'role.delete',
                        'role.assign-permission',
                        'role.revoke-permission',
                        'permission.view',
                        'permission.create',
                        'permission.edit',
                        'permission.delete',
                    ]);
                }
            )

            ->get()

            ->groupBy(function ($p) {
                return explode('.', $p->name, 2)[0];
            });

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role dibuat');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::query()
            ->when(
                !auth()->user()->hasAnyRole(['sys_admin', 'super_admin']),
                function ($q) {
                    $q->whereNotIn('name', [
                        'role.view',
                        'role.create',
                        'role.edit',
                        'role.delete',
                        'role.assign-permission',
                        'role.revoke-permission',
                        'permission.view',
                        'permission.create',
                        'permission.edit',
                        'permission.delete',
                    ]);
                }
            )
            ->orderBy('name')
            ->get()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role diupdate');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'super_admin') {
            abort(403);
        }

        $role->delete();
        return back()->with('success', 'Role dihapus');
    }
}
