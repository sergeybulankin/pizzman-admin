<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Order;
use App\Status;
use App\UserPoint;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {        
        $pizzman_point = UserPoint::select('pizzman_address_id')
            ->where('user_id', $request->user)
            ->first();
        
        // собираем заказы для точки
        $orders = Order::with('status', 'order_status')
            ->where('pizzman_address_id', $pizzman_point->pizzman_address_id)
            ->get();

        // собираем статусы у заказов и групируем их по ID
        $statuses = [];
        foreach ($orders as $key => $value) {
            foreach ($value->status as $status) {
                $statuses[$key]['id'] = $status->id;
                $statuses[$key]['name'] = $status->name;
            }
        }
        $statuses = collect($statuses)->groupBy('id');

        // сортируем массив для того,
        // чтобы проще было бы отдавать его для сравнения со статусами из БД
        $sort_statuses = [];
        foreach ($statuses as $key => $value) {
            $sort_statuses[$key]['id'] = $value[0]['id'];
            $sort_statuses[$key]['count'] = count($value);
        }

        // забираем все статусы
        $all_statuses = Status::withCount('counts')
            ->where('id', '!=', 1)
            ->get();

        // если ID статусов из БД и сформированного массива совпадают
        // то добавляем поле с количество заказов на данной стадии
        foreach ($all_statuses as $key => $value) {
            foreach ($sort_statuses as $k => $v) {
                if ($v['id'] == $value->id) {
                    $all_statuses[$key]['counts'] = $v['count'];
                }
            }
        }

        return StatusResource::collection($all_statuses);
    }
}
