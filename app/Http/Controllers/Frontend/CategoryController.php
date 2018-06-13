<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Repositories\CouponProgramRepositoryEloquent;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->orderBy('created_at', 'desc')->first();
        $id = $category->id;
        $parent_id = $category->parent_id;
        $products = Product::where('category_id', $id)->orwhere('category_id', $parent_id)->orderBy('created_at', 'desc')->get();
        $categories = Category::all();

        return view('frontend.products.product', compact('products', 'categories'));
    }
}
