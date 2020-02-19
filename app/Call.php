<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $table = 'calls';

    /**
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-d-m H:i:s', $date)->format('Y-d-m H:i');
    }
}
