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
use App\User;
use App\UserPoint;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $user = $request->user;

        $user_pizzman_point = UserPoint::select('pizzman_address_id')
            ->where('user_id', $user)
            ->first();

        $orders = Order::whereHas('order_status', function ($query) use($user_pizzman_point) {
            $query->where('status_id', 2)
                ->where('success', 0)
                ->where('pizzman_address_id', $user_pizzman_point->pizzman_address_id)
                ->orderBy('status_id', 'DESC');
        })
            ->orderBy('created_at', 'DESC')
            ->get();

        return OrderResource::collection($orders);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function listFood(Request $request)
    {
        $foods_in_orders = FoodInOrder::with('food_additives')
            ->where('order_id', $request->id)
            ->get();

        $order = [];
        foreach ($foods_in_orders as $k => $v) {
            foreach ($v['food_additives'] as $key => $value) {
                $order[$k]['food'] = FoodAdditive::with('food', 'additive')->where('id', $v->food_id)->get();
                $order[$k]['count'] = $v->count;
                $order[$k]['food_key'] = $v->u_id;
            }
        }

        $group_order = collect($order)->groupBy('food_key');

        $result =[];
        foreach ($group_order as $k => $v) {
            foreach ($v as $key => $value) {
                foreach ($value['food'] as $food_key => $food_value) {
                    $result[$k]['food'] = $value['food'][0]['food'];
                    $result[$k]['additive'][$key] = $food_value['additive'];
                    $result[$k]['count'] = $value['count'];
                }
            }
        }

        return json_encode($result);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function selectOrderByStatus(Request $request)
    {
        $id = $request->id;

        $user = $request->user;

        $user_pizzman_point = UserPoint::select('pizzman_address_id')
            ->where('user_id', $user)
            ->first();

        $orders = Order::whereHas('order_status', function ($query) use($id, $user_pizzman_point) {
            $query->where('status_id', $id)
                ->where('success', 0)
                ->where('pizzman_address_id', $user_pizzman_point->pizzman_address_id)
                ->orderBy('status_id', 'DESC');
        })
            ->with('order_status_last')
            ->get();

        return OrderResource::collection($orders);
    }


    /**
     * @param Request $request
     */
    public function nextStage(Request $request)
    {
        $order = OrderStatus::all()->where('order_id', $request->id)->last();

        $order_id = $order->order_id;
        $status_stage = $order->status_id + 1;

        $order->success = 1;
        $order->save();

        $newStage = new OrderStatus();
        $newStage->order_id = $order_id;
        $newStage->status_id = $status_stage;
        $newStage->success = 0;
        $newStage->save();
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


    /**
     * @param Request $request
     * @return string
     */
    public function viewDriver(Request $request) {
        $driver = User::with('account')
            ->where('id', $request->driver)
            ->first();

        return json_encode($driver);
    }
}
