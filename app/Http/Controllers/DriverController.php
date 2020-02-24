<?php

namespace App\Http\Controllers;

use App\FoodAdditive;
use App\FoodInOrder;
use App\Http\Resources\DriverResource;
use App\Order;
use App\OrderCourier;
use App\OrderStatus;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $orders = OrderCourier::all()
            ->where('user_id', $request->user);

        $current_orders = [];
        foreach ($orders as $k => $v) {
            $current_orders = OrderStatus::select('order_id')
                ->where('order_id', $v['order_id'])
                ->where('status_id', 5)
                ->get();
        }

        $foods_in_orders = [];
        foreach ($current_orders as $k => $v) {
            $foods_in_orders = FoodInOrder::with('food_additive')
                ->where('order_id', $v['order_id'])
                ->get();
        }

        $order = [];
        foreach ($foods_in_orders as $k => $v) {
            foreach ($v['food_additive'] as $key => $value) {
                $order[$k]['food'] = FoodAdditive::with('food', 'additive')->where('id', $v->food_id)->get();
                $order[$k]['additive'][$key] = FoodAdditive::with('food', 'additive')->where('id', $value->additive_id)->get();
                $order[$k]['count'] = $v->count;
                $order[$k]['address'] = Order::with('address')->where('id', $v->order_id)->first();
            }
        }

        return json_encode($order);
    }
}
