<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\OrderStatus;
use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        /*$statuses = Status::withCount('counts')
            ->where('id', '!=', 1)
            ->get();*/

        $statuses = Status::all();

        $order_status = OrderStatus::all()->where('success', 0);

        $result =[];
        foreach ($order_status as $order) {
            foreach ($statuses as $k => $v) {
                $count = 0;
                if ($v->id == $order->status_id) {
                    $result[$k] = $v;
                    $result[$k]['count'] = $count + 1;
                }else {
                    $result[$k] = $v;
                }
            }
        }

        $result = collect($result);

        //return StatusResource::collection($statuses);
        return json_encode($result);
    }
}
