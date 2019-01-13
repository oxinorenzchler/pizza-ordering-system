<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    public function sizePrice(){
    	return $this->hasMany('App\ToppingSizePrice');
    }
    public function combinations(){
    	return $this->hasMany('App\Combination');
    } 
}
