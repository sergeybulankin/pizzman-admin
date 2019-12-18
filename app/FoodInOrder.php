<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodInOrder extends Model
{
    protected $table = 'foods_in_orders';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function food_additive()
    {
        return $this->hasMany(FoodAdditive::class, 'id', 'food_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pizzman_address()
    {
        return $this->hasMany(PizzmanAddressFood::class, 'food_id', 'food_id');
    }
}
