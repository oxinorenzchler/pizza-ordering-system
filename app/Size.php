<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    public function pizzas(){
    	return $this->hasMany('App\PizzaSizePrice');
    }

    public function toppings(){
    	return $this->hasMany('App\ToppingSizePrice');
    }

    public function orderPizza(){
    	return $this->hasMany('App\OrderPizza');
    }
}
