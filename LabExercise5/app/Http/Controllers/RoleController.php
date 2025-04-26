<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        return view('roles.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|unique:roles',
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
    public function editPermissions(Role $role)
{
    if (auth()->user()->role !== 'Admin') {
        abort(403, 'Unauthorized');
    }

    $permissions = Permission::all();
    return view('roles.permissions', compact('role', 'permissions'));
}

public function updatePermissions(Request $request, Role $role)
{
    if (auth()->user()->role !== 'Admin') {
        abort(403, 'Unauthorized');
    }

    $role->syncPermissions($request->permissions);

    return redirect()->route('roles.index')->with('success', 'Permissions updated successfully.');
}

}

















































