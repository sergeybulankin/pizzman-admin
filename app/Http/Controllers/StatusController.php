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
        $statuses = Status::withCount('counts')->get();

        return StatusResource::collection($statuses);
    }
}
