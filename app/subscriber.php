<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscriber extends Model
{
    /**
     * City relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
