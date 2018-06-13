<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

class ProductController extends Controller
{
    /**
     * Get all records and return view all with this data
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $dataCat = new CategoryRepositoryEloquent();
        $dataCP = new CouponProgramRepositoryEloquent();
        $dataPA = new ProductAttributeRepositoryEloquent();

        $pas = $dataPA->getImagesAll(100);
        $products = Product::orderBy('created_at', 'desc')->get();
        $categories = Category::where('status', 1)->get();
        $parentIds = $dataCat->getCategoryByParentId(100);
        $parentNulls = $dataCat->getCategoryByParentIdIsNull();
        $coupons = $dataCP->getCoupon(100);

        return view('frontend.products.product', compact('products', 'categories', 'parentIds', 'parentNulls', 'coupons', 'pas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show($slug)
    {
        $dataPA = new ProductAttributeRepositoryEloquent();
        $dataCat = new CategoryRepositoryEloquent();
        $dataCMT = new CommentRepositoryEloquent();
        $dataCP = new CouponProgramRepositoryEloquent();

        $user = Sentinel::getUser();
        $pas = $dataPA->getImages(100, $slug);
        $paColors = $dataPA->getColor(100, $slug);
        $product = Product::where('slug', $slug)->first();
        $p = $product->id;
        $interested = Product::where('slug', '!=', $slug)->get()->random(4);
        $colors = Color::all();
        $categories = Category::where('status', 1)->get();
        $products = Product::all();
        $parentIds = $dataCat->getCategoryByParentId(100);
        $parentNulls = $dataCat->getCategoryByParentIdIsNull();
        $cmts = Comment::where('comment_id', '=', $p)->where('parent_id', '=', null)->where('comment_type', '=', 1)->get();
        $comments = $dataCMT->getAll($p);
        $commentP = $dataCMT->getCommentProduct($p);
        $commentQ = $dataCMT->getCommentQuestion($p);
        $rates = Rate::where('product_id', '=', $p)->get();
        $images = Image::all();
        $coupons = $dataCP->getCoupon(100);

        $productattributes = ProductAttribute::where('product_id', $p)->get();
        foreach ($productattributes as $pttr) {
            $at = $pttr->id;
            $orderdetail = OrderDetail::where('product_attribute_id', '=', $at)->first();
        }


        return view('frontend.products.showProduct', compact('product', 'interested', 'colors', 'categories', 'products', 'parentIds', 'parentNulls', 'pas', 'paColors', 'comments', 'cmts', 'rates', 'user', 'commentP', 'commentQ', 'orderdetail', 'images','coupons'));
    }
    /**
     * @param  interger $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showPrdByCatId($id)
    {
        $data = new ProductRepositoryEloquent();
        $dataCat = new CategoryRepositoryEloquent();

        $dataCP = new CouponProgramRepositoryEloquent();
        $coupons = $dataCP->getCoupon(100);
        $categories = Category::where('id', $id)->orwhere('parent_id', $id)->orderBy('created_at', 'desc')->get();

        $categoryId = Category::find($id);
        $param = 6;
        $products = $data->getProductByCategoryId($param, $id);
        $parentIds = $dataCat->getCategoryByParentId($id);
        $parentNulls = $dataCat->getCategoryByParentIdIsNull();
        $images = Image::all();

        return view('frontend.categories.showCategory', compact('categories', 'categoryId', 'products', 'parentIds', 'parentNulls', 'coupons', 'images'));
    }

    /**
     * Tìm kiếm sản phẩm theo các tiêu chí như : ten san pham
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function search(Request $request)
    {
        $userAd = Sentinel::getUser();
        $search= $request->input('search');
        $products = Product::where('name', 'like', "%".$search."%")->get();
        $count = $products->count();

        $products = Product::where('name', 'like', "%".$search."%")->paginate(9);

        $dataCat = new CategoryRepositoryEloquent();
        $dataCP = new CouponProgramRepositoryEloquent();
        $dataPA = new ProductAttributeRepositoryEloquent();

        $pas = $dataPA->getImagesAll(100);
        $categories = Category::where('status', 1)->get();
        $parentIds = $dataCat->getCategoryByParentId(100);
        $parentNulls = $dataCat->getCategoryByParentIdIsNull();
        $coupons = $dataCP->getCoupon(100);

        return view('frontend.products.search', compact('products', 'categories', 'parentIds', 'parentNulls', 'coupons', 'pas', 'count'));
    }
}
