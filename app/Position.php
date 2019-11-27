<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = [];

    public function criterias() {
        return $this->hasMany('App\Criteria', 'position_id');
    }
}
