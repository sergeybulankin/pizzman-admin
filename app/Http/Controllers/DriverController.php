<?php

namespace App\Http\Controllers;

use App\FoodAdditive;
use App\FoodInOrder;
use App\Http\Resources\DriverResource;
use App\Order;
use App\OrderCourier;
use App\OrderStatus;
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
            $current_orders = OrderStatus::select('order_id')
                ->where('order_id', $v['order_id'])
                ->where('status_id', 5)
                ->where('success', 0)
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
                $order[$k]['count'] = $v->count;
                $order[$k]['address'] = Order::with('address')->where('id', $v->order_id)->first();
                $order[$k]['address_id'] = $order[$k]['address']['address_id'];
                $order_status_id = OrderStatus::select('id')->where('order_id', $v->order_id)->where('status_id', 5)->first();
                $order[$k]['order_status_id'] = $order_status_id['id'];
            }
        }

        $result = collect($order)->groupBy('address_id');

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
        $user_orders = OrderCourier::with('order_status')
            ->where('user_id', $request->user)
            ->get();

        $count_orders = 0;
        foreach ($user_orders as $k => $v) {
            foreach ($v->order_status as $status) {
                if ($status->success == 0) {
                    $count_orders = $count_orders + 1;
                }
            }
        }

        return json_encode($count_orders);
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

        $account = User::with('account')->where('id', $user)->first();

        $roles = Role::all();

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $user_orders = OrderCourier::with('order_status', 'order')
            ->where('user_id', $user)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('components.driver.archive', compact('user_orders', 'roles', 'account', 'role_id'));
    }
}
