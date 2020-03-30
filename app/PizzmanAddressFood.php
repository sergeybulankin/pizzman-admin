<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzmanAddressFood extends Model
{
    protected $table = 'pizzmans_addresses_foods';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function food()
    {
        return $this->hasOne(Food::class, 'id', 'food_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pizzman_address()
    {
        return $this->hasOne(PizzmanAddress::class, 'id', 'pizzman_address_id');
    }
}
