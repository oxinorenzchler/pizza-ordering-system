<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Combination extends Model
{
    public function toppingSizePrice(){
    	return $this->belongsTo('App\ToppingSizePrice', 'topping_size_price_id');
    }
    public function orderPrice(){
    	return $this->belongsTo('App\OrderPrice');
    }

    public function topping(){
    	return $this->belongsTo('App\Topping');
    }
}
