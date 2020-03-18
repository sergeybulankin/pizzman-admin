<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\OrderStatus;
use App\Status;
use App\UserPoint;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $user = $request->user;

        $user_pizzman_point = UserPoint::select('pizzman_address_id')
            ->where('user_id', $user)
            ->first();

        $statuses = Status::withCount('counts')
            ->where('id', '!=', 1)
            ->get();

        return StatusResource::collection($statuses);
    }
}
