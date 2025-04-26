<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        if (Auth::user()->isEmployee()) {
            $users = User::where('role', 'Customer')->get();
        } elseif (Auth::user()->isAdmin()) {
            $users = User::all();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('users.index', compact('users'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function createEmployee()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('users.create_employee');
    }

    public function storeEmployee(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Employee',
        ]);

        return redirect()->route('users.index')->with('success', 'Employee created successfully.');
    }

    public function chargeCredit(Request $request, User $user)
    {
        if (!Auth::user()->isEmployee()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user->credit += $request->amount;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Credit added successfully.');
    }
}



























