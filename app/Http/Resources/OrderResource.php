<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,

            'address' => $this->address[0],
            'user' => $this->user,
            'status' => $this->order_status,
            'last_status' => $this->order_status_last,
            'courier' => $this->courier
        ];
    }
}
