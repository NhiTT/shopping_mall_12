<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepositoryEloquent;

class OrderController extends Controller
{
    public function index()
    {
        $data = new OrderRepositoryEloquent;
        $orders = $data->getAll(10);

        return view('backend.orders.orderList', compact('orders'));
    }
}
