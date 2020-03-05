<?php

namespace App\Http\Controllers;

use App\FoodAdditive;
use App\FoodInOrder;
use App\Http\Resources\DriverResource;
use App\Order;
use App\OrderCourier;
use App\OrderStatus;
use App\PizzmanAddress;
use App\Role;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    /**
     * Собираем информацию о заказе для водителя
     * и группируем его по пользователю
     *
     * @param Request $request
     * @return false|string
     */
    public function index(Request $request)
    {
        $orders = OrderCourier::all()
            ->where('user_id', $request->user);

        $current_orders = [];
        foreach ($orders as $k => $v) {
            $current_orders[] = OrderStatus::select('order_id')
                ->where('order_id', $v['order_id'])
                ->where('status_id', 5)
                ->where('success', 0)
                ->get();
        }

        $foods_in_orders = [];
        foreach (collect($current_orders)->collapse() as $k => $v) {
            $foods_in_orders[] = FoodInOrder::with('food_additive')
                ->where('order_id', $v['order_id'])
                ->get();
        }

        $order = [];
        foreach (collect($foods_in_orders)->collapse() as $k => $v) {
            foreach ($v['food_additive'] as $key => $value) {
                $order[$k]['food'] = FoodAdditive::with('food', 'additive')->where('id', $v->food_id)->get();
                $order[$k]['count'] = $v->count;
                $order[$k]['address'] = Order::with('address')->where('id', $v->order_id)->first();
                $order[$k]['address_id'] = $order[$k]['address']['address_id'];
                $order[$k]['pizzman_address'] = PizzmanAddress::all()->where('address_id', $order[$k]['address']['pizzman_address_id'])->first();
                $order_status_id = OrderStatus::select('id', 'order_id', 'updated_at')->where('order_id', $v->order_id)->where('status_id', 5)->first();
                $order[$k]['food_in_order_id'] = $v->id;
                $order[$k]['time_order'] = $v->updated_utc;
                $order[$k]['order_status_id'] = $order_status_id['id'];
                $order[$k]['order_id'] = $order_status_id['order_id'];
                $order[$k]['food_key'] = $v->u_id;
            }
        }

        $result = collect($order)->groupBy('order_id');

        $count_additive = [];
        foreach ($result->collapse() as $k => $v) {
            $count_additive[] = $v['food_key'];
        }

        $additives = [];
        foreach (array_count_values($count_additive) as $k => $count) {
            if ($count > 1) {
                $additives[] = $k;
            }
        }

        $additives_array = [];
        $orders = [];
        foreach ($result->collapse() as $k => $v) {
            foreach ($additives as $additive_key) {
                if ($additive_key == $v['food_key']) {
                    foreach ($v['food'] as $kk => $item) {
                        foreach ($item['additive'] as $key => $additive) {
                            $additive->food_key = $v['food_key'];
                            $additives_array[] = $additive;
                        }
                    }
                }
            }
        }

        $sort_additive_array = collect($additives_array)->groupBy('food_key');

        foreach ($result->collapse() as $k => $v) {
            foreach ($additives as $additive_key) {
                if ($additive_key == $v['food_key']) {
                    $orders[$k]['food'] = $v['food'][0]['food'];
                    $orders[$k]['additive'] = $sort_additive_array[$additive_key];
                }else {
                    $orders[$k]['food'] = $v['food'];
                    foreach ($v['food'] as $item) {
                        $orders[$k]['food'] = $item['food'];
                        $orders[$k]['additive'] = $item['additive'];
                    }
                }
            }

            $orders[$k]['count'] = $v['count'];
            $orders[$k]['address'] = $v['address'];
            $orders[$k]['address_id'] = $v['address_id'];
            $orders[$k]['pizzman_address'] = $v['pizzman_address'];
            $orders[$k]['food_in_order_id'] = $v['food_in_order_id'];
            $orders[$k]['time_order'] = $v['time_order'];
            $orders[$k]['order_status_id'] = $v['order_status_id'];
            $orders[$k]['order_id'] = $v['order_id'];
            $orders[$k]['food_key'] = $v['food_key'];
        }

        $result = collect($orders)->groupBy('order_id');

        return json_encode($result);
    }

    /**
     * подсчет количества активных заявок
     *
     * @param Request $request
     * @return false|string
     */
    public function countOrders(Request $request)
    {
        $user_orders = OrderCourier::all()->where('user_id', $request->user);

        $order_status =[];
        foreach ($user_orders as $k => $v) {
            $order_status[] = OrderStatus::select('id')
                ->where('order_id', $v->order_id)
                ->where('status_id', 5)
                ->where('success', 0)
                ->get();
        }

        $orders_count = collect($order_status)->collapse()->count();

        return json_encode($orders_count);
    }

    /**
     * подтверждение доставки товара клиенту
     *
     * @param Request $request
     */
    public function orderDelivered(Request $request)
    {
        $order_status = OrderStatus::all()
            ->where('id', $request->order_status)->first();

        $order_id = $order_status->order_id;
        $status_stage = $order_status->status_id + 1;

        $order_status->success = 1;
        $order_status->save();

        $newStage = new OrderStatus();
        $newStage->order_id = $order_id;
        $newStage->status_id = $status_stage;
        $newStage->success = 0;
        $newStage->save();
    }

    /**
     * Архив для водителя - все заказы
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $courier = OrderCourier::with('order')
            ->where('user_id', $user)
            ->get();

        $user_orders = [];
        foreach ($courier as $k => $v) {
            $user_orders[$k]['order'] = $v;
            $user_orders[$k]['status'] = OrderStatus::with('status')
                ->where('order_id',$v->order['id'])
                ->where('success', 0)
                ->get();
        }

        $user_orders = collect($user_orders);

        return view('components.driver.archive', compact('user_orders', 'role_id'));
    }
}
