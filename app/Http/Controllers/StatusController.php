<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Status;

class StatusController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $statuses = Status::withCount('counts')
            ->where('id', '!=', 1)
            ->get();

        return StatusResource::collection($statuses);
    }
}
