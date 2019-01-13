<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    public function type(){
    	return $this->belongsTo('App\PizzaType', 'pizza_type_id');
    }

    public function sizePrice(){
    	return $this->hasMany('App\PizzaSizePrice');

    }

    public function orderPizza(){
    	return $this->hasMany('App\OrderPizza');
    }
}
