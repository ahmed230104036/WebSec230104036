<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    
    public function create(Request $request, Product $product)
    {
        return view('reviews.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $review = new Review();
        $review->product_id = $product->id;
        $review->user_id = auth()->id();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->route('products_list')->with('success', 'Review added successfully!');
    }
}
