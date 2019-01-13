<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaType extends Model
{
    public function pizzas(){
    	return $this->hasMany('App\Pizza');
    }
}
