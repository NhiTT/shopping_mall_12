<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Rate;
use App\Models\Image;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\ProductController;
use Sentinel;
use Mail;
use \Cart as Cart;
use App\Repositories\ProductAttributeRepositoryEloquent;

class CommentController extends Controller
{
    public function index()
    {
        $user = Sentinel::getUser();
        $orders = Order::all();
        $order_details = OrderDetail::all();
        $product_attributes = ProductAttribute::all();
        $products = Product::all();
        $prds = new ProductAttributeRepositoryEloquent();
        $ps = $prds->getProductByPAId(100);
        $imgs = $prds->getImagesAll(100);

        return view('frontend.user.myReviews', compact('user', 'orders', 'order_details', 'products', 'product_attributes', 'ps', 'imgs'));
    }

    public function show($id)
    {
        $user = Sentinel::getUser();
        $userId = $user->id;
        $product = Product::where('id', $id)->firstOrFail();
        $pAttribute = ProductAttribute::where('product_id', $id)->firstOrFail();
        $p = $pAttribute->id;
        $img = Image::where('product_attributes_id', $p)->firstOrFail();
        $rates = Rate::all();
        $comment = Comment::where('user_id', $userId)->where('comment_id', $id)->first();
        $rate =  0;
        foreach ($rates as $rating) {
            if ($rating->user_id == $userId and $rating->product_id == $id) {
                $rate = $rating->rate_point;
            }
        }

        return view('frontend.user.singleReview', compact('user', 'product', 'img', 'rate', 'rates', 'comment'));
    }

    public function create(CommentRequest $request)
    {
        $comment = new Comment(array(
            'user_id' => $request->get('user_id'),
            'comment_id' => $request->get('comment_id'),
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ));
        $comment->save();
        $rate = new Rate(array(
            'rate_point' => $request->get('rated'),
            'user_id' => $request->get('user_id'),
            'product_id' => $request->get('comment_id')
        ));
        $rate->save();

        $rates = Rate::where('product_id', $request->get('comment_id'))->get();
        $p = 0;
        foreach ($rates as $r) {
            $p = $p + $r->rate_point;
        }
        if ($rates) {
            $point = $p/($rates->count());

            Product::where('id', $request->get('comment_id'))
            ->update(['rate_point' => $point]);
        }

        return  redirect()->back()->with('success_message',  'Your review has been created!');
    }

    public function updateReview(CommentRequest $request)
    {

        $title = $request->get('title');
        $content = $request->get('content');
        $rate_point = $request->get('rated');

        Comment::where('user_id', $request->get('user_id'))
        ->where('comment_id', $request->get('comment_id'))
        ->update(['title' => $title, 'content' => $content]);

        Rate::where('user_id', $request->get('user_id'))
        ->where('product_id', $request->get('comment_id'))
        ->update(['rate_point' => $rate_point]);

        $rates = Rate::where('product_id', $request->get('comment_id'))->get();
        $p = 0;
        foreach ($rates as $r) {
            $p = $p + $r->rate_point;
        }
        if ($rates) {
            $point = $p/($rates->count());

            Product::where('id', $request->get('comment_id'))
            ->update(['rate_point' => $point]);
        }

        return  redirect()->back()->with('success_message',  'Your review has been created!');
    }

    public function createQuestion(CommentRequest $request)
    {
        $comment = new Comment(array(
            'user_id' => $request->get('user_id'),
            'comment_id' => $request->get('product_id'),
            'title' => $request->get('title'),
            'parent_id' => $request->get('parent_id'),
            'content' => $request->get('content'),
            'comment_type' => 2
        ));
        $comment->save();

        return  redirect()->back()->with('success_message',  'Your Question has been created!');
    }

    public function delete($id)
    {
        $comment = Comment::find($id)->firstOrFail();
        $user = $comment->user_id;
        $product = $comment->comment_id;
        $rate = Rate::where('product_id', '=', 1)->where('user_id', '=', 1)->firstOrFail();
        dd($rate);

        // Comment::destroy($id);

        // Rate::destroy($id);

        return  redirect()->back()->with('success_message',  'Your Question has been deleted!');
    }
}
