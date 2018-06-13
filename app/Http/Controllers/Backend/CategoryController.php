<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\Backend\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::orderBy('created_at', 'desc')->paginate(10);
        foreach ($categories as $cat) {
            $cat['parent_name'] = $cat->parent();
        }

        return view('backend.categories.categoryList', compact('categories', 'products'));
    }

    public function show($id)
    {
        $category = Category::find($id);
        $categories = Category::where('status', 1)->get();

        return view('backend.categories.showCategory', compact('categories', 'category'));
    }

    public function add()
    {
        $categories = Category::orderBy('created_at', 'desc')->where('status', 1)->get();

        return view('backend.categories.addCategory', compact('categories'));
    }

    /**
     * Xử lý thêm mới danh mục
     * @param CategoryEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adding(CategoryRequest $request)
    {
        $name = $request->get('category_name');
        $parent_id = $request->get('category_parent');
        $slug = $request->get('category_slug');
        if (empty($slug)) {
            $slug = str_slug($name);
        }

        $data = array(
                'name'        => $name,
                'parent_id'   => $parent_id,
                'slug'        => $slug,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
        );

        if (Category::insert($data)) {
            $message = "Create successfully!";
            return redirect()->route('admin.categories')
                             ->withInput()
                             ->with('message', $message);
        } else {
            $message_fail = "Update fail!";
            return redirect()->back()
                             ->withInput()
                             ->with('message_fail', $message_fail);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::where('status', 1)->get();

        return view('backend.categories.editCategory', compact('category', 'categories'));
    }

    /**
     * Xử lý Sửa thông tin danh mục
     * @param unknown $id
     * @param CategoryEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editting($id, CategoryRequest $request)
    {
        $name = $request->get('category_name');
        $parent_id = $request->get('category_parent');
        $slug = $request->get('category_slug');
        if (empty($slug)) {
            $slug = str_slug($name);
        }
        $update = Category::where('id', $id)
        ->update(['name' => $name, 'parent_id' => $parent_id, 'slug' => $slug]);

        if ($update) {
            $message = "Update successfully!";
            return redirect()->back()
            ->withInput()
            ->with('message', $message);
        } else {
            $message_fail = "Update fail!";
            return redirect()->back()
            ->withInput()
            ->with('message_fail', $message_fail);
        }
    }

    /**
     * Xóa danh mục
     * @param unknown $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $del = Category::where('id', $id)
        ->update(['status' => 0]);

        if ($del) {
            if (isset($del)) {
                $message = "Delete successfully!";
                return redirect()->back()
                ->withInput()
                ->with('message', $message);
            } else {
                $message_fail = "Delete fail!";
                return redirect()->back()
                ->withInput()
                ->with('message_fail', $message_fail);
            }
        } else {
            $message_fail = "This category not found!";
            return redirect()->back()
            ->withInput()
            ->with(['message_fail', $message_fail]);
        }
    }

    /**
     * Xóa danh mục
     * @param unknown $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $restore = Category::where('id', $id)
        ->update(['status' => 1]);

        if ($restore) {
            if (isset($restore)) {
                $message = "Restore successfully!";
                return redirect()->back()
                ->withInput()
                ->with('message', $message);
            } else {
                $message_fail = "Restore fail!";
                return redirect()->back()
                ->withInput()
                ->with('message_fail', $message_fail);
            }
        } else {
            $message_fail = "This category not found!";
            return redirect()->back()
            ->withInput()
            ->with(['message_fail', $message_fail]);
        }
    }
}
