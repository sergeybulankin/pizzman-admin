<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function type()
    {
        return $this->belongsToMany(Type::class, 'foods_types');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function additive()
    {
        return $this->belongsToMany(Additive::class, 'foods_additives');
    }
}
