<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function food()
    {
        return $this->hasMany(FoodInOrder::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_status()
    {
        return $this->hasMany(OrderStatus::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address()
    {
        return $this->hasMany(Address::class, 'id', 'address_id');
    }
}
