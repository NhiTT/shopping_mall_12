<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Repositories\CouponProgramRepositoryEloquent;
use App\Http\Requests\Backend\CouponRequest;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(10);

        return view('backend.coupons.couponList', compact('coupons'));
    }

    public function show($id)
    {
        $coupon = Coupon::find($id);

        return view('backend.coupons.showCoupon', compact('coupon'));
    }

    public function add()
    {
        $coupon = Coupon::orderBy('created_at', 'desc')->where('status', 1)->get();

        return view('backend.coupons.addCoupon', compact('coupon'));
    }

    /**
     * Xử lý thêm mới danh mục
     * @param CategoryEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adding(CouponRequest $request)
    {
        $code = $request->coupon_code;
        $type = $request->coupon_type;
        $decrease = $request->decrease;
        $start_at = $request->start_at;
        $end_at = $request->end_at;

        $data = array(
            'code' => $code,
            'type' => $type,
            'decrease' => $decrease,
            'start_at' => $start_at,
            'end_at' => $end_at,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        if (Coupon::insert($data)) {
            $message = __('Create successfully!');
            return redirect()->route('admin.coupons')
                             ->withInput()
                             ->with('message', $message);
        } else {
            $message_fail = __('Update fail!');
            return redirect()->back()
                             ->withInput()
                             ->with('message_fail', $message_fail);
        }
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);

        return view('backend.coupons.editCoupon', compact('coupon'));
    }

    public function editting($id, CouponRequest $request)
    {
        $code = $request->coupon_code;
        $type = $request->coupon_type;
        $decrease = $request->decrease;
        $start_at = $request->start_at;
        $end_at = $request->end_at;

        $update = Coupon::where('id', $id)
            ->update([
                'code' => $code,
                'type' => $type,
                'decrease' => $decrease,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        if ($update) {
            $message = __('Update successfully!');

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

    public function delete($id)
    {
        $del = Coupon::where('id', $id)
        ->update(['status' => 0]);

        if ($del) {
            if (isset($del)) {
                $message = __('Delete successfully!');

                return redirect()->back()
                ->withInput()
                ->with('message', $message);
            } else {
                $message_fail = __('Delete fail!');

                return redirect()->back()
                ->withInput()
                ->with('message_fail', $message_fail);
            }
        } else {
            $message_fail = __('This category not found!');

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
        $restore = Coupon::where('id', $id)
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
