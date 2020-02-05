<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzmanAddress extends Model
{
    protected $table = 'pizzmans_addresses';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pizzman_address_food()
    {
        return $this->hasOne(PizzmanAddressFood::class, 'id', 'address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address_delivery()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
