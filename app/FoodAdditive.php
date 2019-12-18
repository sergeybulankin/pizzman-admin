<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodAdditive extends Model
{
    protected $table = 'foods_additives';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function food()
    {
        return $this->hasMany(Food::class, 'id', 'food_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function additive()
    {
        return $this->hasMany(Additive::class, 'id', 'additive_id');
    }
}
