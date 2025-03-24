<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
{
    $query = User::query();

    if ($request->has('search')) {
        $query->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
    }

    $users = $query->where('role', '!=', 'admin')->get();
    return view('users.index', compact('users'));
}


public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,employee,customer'
    ]);

    $user->update($request->all());
    return redirect()->route('users.index')->with('success', 'User updated successfully!');
}


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make('password123')]);
        return redirect()->route('users.index')->with('success', 'Password reset successfully!');
    }
    public function create()
{
    return view('users.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|in:customer,employee'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'credit' => 0
    ]);

    return redirect()->route('users.index')->with('success', 'User created successfully!');
}
public function edit(User $user)
{
    return view('users.edit', compact('user'));
}

}
