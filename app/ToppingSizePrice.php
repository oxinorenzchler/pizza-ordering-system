<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToppingSizePrice extends Model
{

	public function topping(){
		return $this->belongsTo('App\Topping');
	} 

    public function size(){
    	return $this->belongsTo('App\Size');
    }

    public function combinations(){
    	return $this->belongsTo('App\Combination');
    }
}
