<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function create()
{
    if (auth()->user()->role !== 'Admin') {
        abort(403, 'Unauthorized');
    }

    return view('users.create');
}

public function store(Request $request)
{
    if (auth()->user()->role !== 'Admin') {
        abort(403, 'Unauthorized');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:User,Employee',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('users.index')->with('success', 'User created successfully.');



    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}

    
    public function profile()
    {
        return view('users.profile');
    }

    public function editProfile()
    {
        return view('users.edit_profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.profile')->with('success', 'Profile updated successfully.');
    }
    
        public function index()
        {
            if (!in_array(auth()->user()->role, ['Admin', 'Employee'])) {
                abort(403, 'Unauthorized');
            }
    
            $users = User::all();
            $roles = Role::all(); 
    
            return view('users.index', compact('users', 'roles'));
        }
    
    
    

public function edit(User $user)
{
    if (auth()->user()->role == 'Employee' && $user->role == 'Admin') {
        abort(403, 'Unauthorized action.');
    }

    return view('users.edit', compact('user'));
}

public function update(Request $request, User $user)
{

    if (auth()->user()->role == 'Employee' && $user->role == 'Admin') {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->update($request->only(['name', 'email']));

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}


public function destroy(User $user)
{
    if (auth()->user()->role !== 'Admin') {
        abort(403, 'Unauthorized'); 
    }

    $user->delete();
    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
}
}












































