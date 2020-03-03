<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCourier extends Model
{
    protected $table = 'orders_courier';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_status()
    {
        //return $this->hasManyThrough(Status::class, OrderStatus::class, 'id', 'order_id', 'order_id');
    }

    /**
     * @return $this
     */
    public function counts()
    {
        return $this->hasMany(OrderStatus::class, 'order_id', 'order_id')
            ->where('success', 0)
            ->where('status_id', 5);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
