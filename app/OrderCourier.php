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
}
