<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function updateOwnPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = Auth::user(); 

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('users.profile', $user->id)->with('success', 'Password updated successfully!');
    }
    public function showChangePasswordForm()
{
    return view('users.change_password');
}

}
