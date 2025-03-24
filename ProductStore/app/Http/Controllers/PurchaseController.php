<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller {
    public function buy(Product $product)
{
    $user = auth()->user();

    if ($user->credit < $product->price) {
        return view('errors.insufficient_credit');
    }

    if ($product->stock <= 0) {
        return back()->withErrors('Sorry, this product is out of stock!');
    }

    $user->credit -= $product->price;
    $user->save();

    $product->stock -= 1;
    $product->save();

    Purchase::create([
        'user_id' => $user->id,
        'product_id' => $product->id
    ]);

    return back()->with('success', 'Product purchased successfully!');
}
}