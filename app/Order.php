<?php

namespace App;

use Jenssegers\Date\Date;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $appends = [
        'created_utc'
    ];

    protected $dates =[
        'created_utc'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function food()
    {
        return $this->hasMany(FoodInOrder::class, 'order_id', 'id');
    }

    public function food_additive()
    {
        //return $this->hasManyThrough(FoodAdditive::class, FoodInOrder::class, 'food_id', 'food_id', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_status()
    {
        return $this->hasMany(OrderStatus::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function order_status_last()
    {
        return $this->hasOne(OrderStatus::class, 'order_id', 'id')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address()
    {
        return $this->hasMany(Address::class, 'id', 'address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function courier()
    {
        return $this->hasOne(OrderCourier::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function courier_info()
    {
        return $this->hasManyThrough(User::class, OrderCourier::class, 'user_id', 'id', 'order_id');
    }

    /**
     * @return static
     */
    public function getCreatedUtcAttribute()
    {
        $timeZone = 'Asia/Yekaterinburg';

        return Date::createFromFormat('Y-m-d H:i:s', $this->getOriginal('created_at'))->timezone($timeZone);
    }
}
