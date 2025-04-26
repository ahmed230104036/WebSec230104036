<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CreditController extends Controller {
    public function index() {
        $customers = User::where('role', 'customer')->get();
        return view('customers.index', compact('customers'));
    }

    public function addCredit(Request $request, User $user) {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $user->credit += $request->amount;
        $user->save();

        return back()->with('success', 'Credit added successfully!');
    }
}


















































