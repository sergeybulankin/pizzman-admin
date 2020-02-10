<?php

namespace App\Http\Controllers;

use App\Additive;
use App\Food;
use App\FoodAdditive;
use App\FoodInOrder;
use App\Http\Resources\OrderResource;
use App\Order;
use App\OrderCourier;
use App\OrderStatus;
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
        })
            ->orderBy('created_at', 'DESC')
            ->get();

        /*
        $order = [];
        foreach ($orders as $k => $v) {
            $foods_in_orders = FoodInOrder::with('food_additive')->where('order_id', $v['id'])->get();

            $food_additive = FoodAdditive::all()->where('food_id', $foods_in_orders[0]->food_id);

            $order[$k]['id'] = $foods_in_orders[0]->order_id;
            $order[$k]['food'] = Food::all()->where('id', $foods_in_orders[0]->food_id);

            foreach ($foods_in_orders[0]->food_additive as $key => $value) {
                $order[$k][$key]['additive'] = Additive::all()->where('id', $value['additive_id']);
            }

            $order[$k]['additive'] = Additive::all()->where('id', $foods_in_orders[0]->additive_id);
        }

        $formattedOrder = [];
        foreach ($order as $item) {
            $formattedOrder[] = (object) $item;
        }

        $orders = collect($formattedOrder);
        */

        return OrderResource::collection($orders);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function selectOrderByStatus(Request $request)
    {
        $id = $request->id;

        $orders = Order::whereHas('order_status', function ($query) use($id) {
            $query->where('status_id', $id);
        })->get();

        return OrderResource::collection($orders);
    }


    /**
     * @param Request $request
     */
    public function nextStage(Request $request)
    {
        $order = OrderStatus::all()->where('order_id', $request->id)->first();

        $order->status_id = $order->status_id + 1;
        $order->save();
    }
    

    /**
     * @param Request $request
     */
    public function sendOrderToCourier(Request $request)
    {
        $order_courier = new OrderCourier();
        $order_courier->order_id = $request->order_id;
        $order_courier->user_id = $request->driver;

        $order_courier->save();
    }
}
