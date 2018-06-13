<?php

namespace App\Http\Controllers\Backend;

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
use App\Models\Coupon;
use App\Models\Comment;
use App\Models\ProductAttribute;
use App\Repositories\ProductRepositoryEloquent;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\CouponProgramRepositoryEloquent;
use App\Repositories\ProductAttributeRepositoryEloquent;
use App\Repositories\CommentRepositoryEloquent;
use App\Http\Requests\Backend\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $dataCat = new CategoryRepositoryEloquent();
        $dataCP = new CouponProgramRepositoryEloquent();
        $dataPA = new ProductAttributeRepositoryEloquent();
        $number = 10;

        $pas = $dataPA->getImagesAll(100);
        $products = Product::select('*', 'products.name as pname', 'products.id as pid', 'products.slug as pslug')->join('categories', 'categories.id', '=', 'products.category_id')->paginate($number);

        $categories = Category::where('status', 1)->get();
        $parentIds = $dataCat->getCategoryByParentId(100);
        $parentNulls = $dataCat->getCategoryByParentIdIsNull();
        $coupons = $dataCP->getCoupon(100);

        $colors = Color::join('product_attributes', 'colors.id', '=', 'product_attributes.color_id')->get();
        $images = Image::all();
        $proAttributes = ProductAttribute::orderBy('created_at', 'desc')->get();

        return view('backend.products.productList', compact('products', 'categories', 'parentIds', 'parentNulls', 'coupons', 'pas', 'proAttributes', 'colors', 'images'));
    }

    public function add()
    {
        $categories = Category::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $imageAll = Image::where('status', 1)->get();
        $coupons = Coupon::where('status', 1)->get();

        return view('backend.products.addProduct', compact('categories', 'colors', 'imageAll'));
    }

    /**
     * Xử lý thêm mới sản phẩm
     * @param ProductAddingRequest $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function adding(ProductRequest $request)
    {
        $product = new Product();
        $name = $request->get('name');
        $description = $request->get('description');
        $price = $request->get('price');
        $size = $request->get('size');
        $category_id = $request->get('category_id');
        $color = $request->get('color_id');
        $barcode = $request->get('barcode');
        $slug = $request->get('slug');
        // dd($request->all());
        if (empty($slug)) {
            $slug = str_slug($name);
        }

        $data = array(
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'price' => $price,
            'size' => $size,
            'category_id' => $category_id,
            'barcode' => $barcode,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($product->insert($data)) {
            // create product attribute
            $getProduct = Product::orderBy('created_at', 'desc')->first();
            $product_id = $getProduct->id;

            $check = ProductAttribute::where('color_id', $color)
                ->where('product_id', $product_id)->first();

            $pa = new ProductAttribute();
            $pa_id = '';
            $imageModel = new Image();
            if (!isset($check)) {
                //insert product attribute
                $dataPA = array(
                    'color_id' => $color,
                    'product_id' => $product_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $pa->insert($dataPA);
                $getPA = ProductAttribute::orderBy('created_at', 'desc')->first();
                $pa_id = $getPA->id;

                if (!isset($pa)) {
                    $message = "Create Color for Product fail";

                    return redirect()->back()
                             ->withInput()
                             ->with('message', $message);
                }
            } else {
                $pa_id = $check->id;
            }

            // create follow product attribute id
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach ($files  as $file) {
                    $newImg = new Image;
                    $path = '/images/' . uniqid() . '-' . $file->getClientOriginalName();
                    $newImg->img_path = $path;
                    $newImg->product_attributes_id = $pa_id;
                    $file->move('images/', $path);
                    $newImg->save();
                }
            }

            $message = "Created successfully!";

            return redirect()->back()
                             ->with('message', $message);
        } else {
            $message_fail = "Update failed!";
            return redirect()->back()
                             ->with('message_fail', $message_fail);
        }
    }

    public function searchAll(Request $request)
    {
        $userAd = Sentinel::getUser();
        $search= $request->input('search');
        $catId= $request->get('catId');
        $number= $request->get('number');
        $products = Product::select('*', 'products.name as pname', 'products.id as pid', 'products.slug as pslug')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->where('category_id', '=', $search)
        ->orwhere('products.name', 'like', "%".$search."%")
        ->paginate($number);

        $dataCat = new CategoryRepositoryEloquent();
        $dataCP = new CouponProgramRepositoryEloquent();
        $dataPA = new ProductAttributeRepositoryEloquent();

        $pas = $dataPA->getImagesAll(100);
        $categories = Category::where('status', 1)->get();
        $parentIds = $dataCat->getCategoryByParentId(100);
        $parentNulls = $dataCat->getCategoryByParentIdIsNull();
        $coupons = $dataCP->getCoupon(100);
        $colors = Color::join('product_attributes', 'colors.id', '=', 'product_attributes.color_id')->get();
        $images = Image::all();

        return view('backend.products.productList', compact('products', 'categories', 'parentIds', 'parentNulls', 'coupons', 'pas', 'attributes', 'colors', 'images'));
    }

    /**
     * xóa 1 sản phẩm trực tiếp từ danh sách sản phẩm
     * @param unknown $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $del = Product::where('id', $id)->update(['status' => 2]);
        if ($del) {
            if (isset($del)) {
                $message = __('Delete successfully!');

                return redirect()->back()->withInput()
                                 ->with('message', $message);
            } else {
                $message_fail = __('Delete fail!');

                return redirect()->back()
                                 ->withInput()
                                 ->with('message_fail', $message_fail);
            }
        } else {
            $message_fail = __('Product not found!');

            return redirect()->back()
                             ->withInput()
                             ->with(['message_fail', $message_fail]);
        }
    }

    public function edit($id)
    {
        $categories = Category::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $imageAll = Image::where('status', 1)->get();
        $coupons = Coupon::where('status', 1)->get();
        $product = Product::find($id);

        return view('backend.products.editProduct', compact('categories', 'colors', 'imageAll', 'product'));
    }

    /**
     * Hàm xử lý quá trình sửa sản phẩm
     * @param unknown $id
     * @param ProductUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editting($id, ProductRequest $request) {
        $product = Product::find($id);
        $images = new Image();
        $categoryId = new CategoryRepository();

        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $producer = $request->input('producer');
        $quantity= $request->input('quantity');
        $sale = $request->input('sale');
        $size = $request->input('size');
        $color = $request->input('color');
        $material = $request->input('material');
        $categoryId = $request->input('categoryId');
        $barcode= $request->input('barcode');
        //dua anh len server
        $nameimg = $_FILES["imageUpload"]["name"];

        if ($_FILES["imageUpload"]["error"] > 0)
            $tenfileanh = '';
        else {
            //lưu ảnh về forder images/products
            move_uploaded_file($_FILES["imageUpload"]["tmp_name"], "images/".$_FILES["imageUpload"]["name"]);
            // lấy tên file ảnh và đường dẫn
            $tenfileanh = "/images/$nameimg";

            //lưu ảnh vào Table Images
            $dataImg = array(
                    'name' => str_slug($nameimg),
                    'src' => $tenfileanh,
                    'product_id' => $id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
            );
            $images->insert($dataImg);
        }

        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->producer = $producer;
        $product->quantity = $quantity;
        $product->sale = $sale;
        $product->size = $size;
        $product->color = $color;
        $product->material = $material;
        $product->barcode = $barcode;
        $product->updated_at = date('Y-m-d H:i:s');

        if ($product->name == $name) {
            $product->slug = str_slug($name);
        }
        //nếu số lượng bằng 0 thì trạng thái chuyển sang hết hàng (0)
        if ($quantity == 0) {
            $product->status = 0;
        } else {
            $product->status = 1;
        }
        // nếu thay ảnh chính
        if (($tenfileanh != '') && ($tenfileanh != null))
            $product->image = $tenfileanh;

        //nếu danh mục thay đổi
        if ($categoryId != null)
            $product->category_id = $categoryId;

        if ($product->save()) {
            $message = "Updated successfully!";

            return redirect()->route('admin.productList')
            ->withInput()
            ->with('message', $message);
        } else {
            $message_fail = "Update failed!";

            return redirect()->back()
            ->withInput()
            ->with('message_fail', $message_fail);
        }
        $message_fail = "Product not found!";

        return redirect()->route('admin.productList')
                         ->with(['message_fail', $message_fail]);
    }
}
