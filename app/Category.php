<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product()
    {
        return $this->belongsToMany(Food::class);
    }
}
