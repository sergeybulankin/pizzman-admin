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
            'type_of_time' => $this->type_of_time_id,
            'type_of_delivery' => $this->type_of_delivery,
            'date' => $this->date,

            'address' => $this->address,
            'user' => $this->user,
            'status' => $this->order_status,
            'last_status' => $this->order_status_last,
            'courier' => $this->courier
        ];
    }
}
