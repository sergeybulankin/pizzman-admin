<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class FoodInOrder extends Model
{
    protected $table = 'foods_in_orders';

    protected $appends = [
        'updated_utc'
    ];

    protected $dates =[
        'updated_utc'
    ];

    /**
     * @return Date
     */
    public function getUpdatedUtcAttribute()
    {
        $timeZone = 'Asia/Yekaterinburg';

        return Date::createFromFormat('Y-m-d H:i:s', $this->getOriginal('updated_at'))->timezone($timeZone);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function food_additives()
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
