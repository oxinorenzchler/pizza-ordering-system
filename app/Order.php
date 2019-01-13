<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderPizza(){
    	return $this->belongsTo('App\OrderPizza', 'order_pizza_id');
    }
   
}
