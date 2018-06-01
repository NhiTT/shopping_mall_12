<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Get all records and return view all with this data
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $products = Product::paginate();
        $count = Product::count();
        
        return view('frontend.products.product', compact('products', 'count'));
    }
}
