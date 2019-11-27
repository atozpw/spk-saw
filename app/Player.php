<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    public function position() {
        return $this->belongsTo('App\Position');
    }
}
