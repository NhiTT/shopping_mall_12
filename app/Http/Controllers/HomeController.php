<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\User;
use App\Models\Image;
use App\Models\OrderDetail;
use App\Models\Rate;
use App\Models\Comment;
use App\Models\ProductAttribute;
use App\Repositories\ProductRepositoryEloquent;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\CouponProgramRepositoryEloquent;
use App\Repositories\ProductAttributeRepositoryEloquent;
use App\Repositories\CommentRepositoryEloquent;

class HomeController extends Controller
{
    /**
     * Home page
     */
    public function index()
    {

        $dataCat = new CategoryRepositoryEloquent();
        $dataCP = new CouponProgramRepositoryEloquent();
        $dataPA = new ProductAttributeRepositoryEloquent();

        $pas = $dataPA->getImagesAll(100);
        $productAll = $dataPA->getImageswithProduct(100);

        $products = Product::orderBy('products.created_at', 'desc')->paginate(12);
        // dd($products);
        $images = Image::all();

        $categories = Category::where('status', 1)->get();
        $parentIds = $dataCat->getCategoryByParentId(100);
        $parentNulls = $dataCat->getCategoryByParentIdIsNull();
        $coupons = $dataCP->getCoupon(100);

        return view('home', compact('products', 'categories', 'parentIds', 'parentNulls', 'coupons', 'pas', 'images', 'productAll'));
    }
}
