<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Status extends Model
{
    protected $table = 'statuses';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function counts()
    {
        return $this->hasMany(OrderStatus::class, 'status_id')
            ->where('success', 0)
            ->where('status_id', '!=', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_status_last()
    {
        return $this->hasMany(OrderStatus::class, 'status_id', 'id')->latest();
    }
}
