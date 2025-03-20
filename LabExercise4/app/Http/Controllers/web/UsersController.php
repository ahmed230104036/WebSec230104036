<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;


class UsersController extends Controller {

    public function register() {
        return view('users.register');
    }

    public function doRegister(Request $request) {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'security_question' => 'required|string',
            'security_answer' => 'required|string|min:3',
        ]);
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->security_question = $request->security_question;
        $user->security_answer = bcrypt($request->security_answer);
        $user->admin = 0;
        $user->save();
    
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
    
    public function login() {
        return view('users.login');
    }

    public function doLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->withErrors('Invalid login information.');
        }

        return redirect()->route('home');
    }

    public function doLogout() {
        Auth::logout();
        return redirect()->route('home');
    }

    public function show(User $user) {
        return view('users.show', compact('user'));
    }

    public function destroy(User $user) {
        if (auth()->user()->id === $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function forgotPassword() {
        return view('users.forgot_password');
    }

    public function verifySecurityAnswer(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found.');
        }

        return view('users.verify_security_answer', compact('user'));
    }

    public function resetPassword(User $user) {
        return view('users.reset_password', compact('user'));
    }

public function updatePassword(Request $request) {
    $request->validate([
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    ]);

    $user = Auth::user();

    $user->password = bcrypt($request->new_password);
    $user->save();

    return redirect()->route('profile', $user->id)->with('success', 'Password updated successfully!');
}


    public function index() {
        if (!auth()->user() || !auth()->user()->admin) {
            return redirect()->route('home')->with('error', 'Access Denied');
        }
    
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit(User $user) {
        if (!auth()->user() || !auth()->user()->admin) {
            return redirect()->route('home')->with('error', 'Access Denied');
        }
    
        return view('users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'User updated successfully!');
}

    
    public function profile($id) {
        $user = User::find($id);
    
        if (!$user) {
            abort(404, 'User not found');
        }
    
        return view('users.profile', compact('user'));
    }
    
    public function changePassword() {
        return view('users.change_password');
    }

    
}
