<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaSizePrice extends Model
{
    public function pizza(){
    	return $this->belongsTo('App\Pizza');
    }

    public function size(){
    	return $this->belongsTo('App\Size');
    }

    public function topping(){
    	return $this->belongsTo('App\Topping');
    }
}
