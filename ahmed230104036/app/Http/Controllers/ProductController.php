<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('products.index', compact('products'));
    }

   
    public function buy(Product $product)
    {
        $user = Auth::user();

        if (!$user->isCustomer()) {
            abort(403, 'Unauthorized');
        }

        if ($user->credit < $product->price) {
            return redirect()->route('products.index')->with('error', 'Insufficient credit to buy this product.');
        }

        if ($product->stock < 1) {
            return redirect()->route('products.index')->with('error', 'This product is out of stock.');
        }


        $user->credit -= $product->price;
        $user->save();

        $product->stock -= 1;
        $product->save();

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'price' => $product->price,
        ]);

        return redirect()->route('products.index')->with('success', 'Product purchased successfully!');
    }

   
    public function create()
    {
        if (!Auth::user()->isEmployee()) {
            abort(403, 'Unauthorized');
        }
        return view('products.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isEmployee()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.1',
            'stock' => 'required|integer|min:1',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    
    public function edit(Product $product)
    {
        if (!Auth::user()->isEmployee()) {
            abort(403, 'Unauthorized');
        }
        return view('products.edit', compact('product'));
    }

  
    public function update(Request $request, Product $product)
    {
        if (!Auth::user()->isEmployee()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.1',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    
    public function destroy(Product $product)
    {
        if (!Auth::user()->isEmployee()) {
            abort(403, 'Unauthorized');
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
