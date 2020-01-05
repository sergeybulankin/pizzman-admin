<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $orders = Order::whereHas('order_status', function ($query) {
            $query->where('status_id', 2);
        })->get();

        return OrderResource::collection($orders);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select_order_by_status(Request $request)
    {
        $id = $request->id;

        $orders = Order::whereHas('order_status', function ($query) use($id) {
            $query->where('status_id', $id);
        })->get();

        return OrderResource::collection($orders);
    }
}
