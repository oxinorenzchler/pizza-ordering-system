<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SizeType extends Model
{
    public function orderPizza(){
    	return $this->hasMany('App\OrderPizza');
    }
}
