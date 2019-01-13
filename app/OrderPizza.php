<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizza extends Model
{
    public function order(){
    	return $this->hasOne('App\Order');
    }

    public function pizza(){
    	return $this->belongsTo('App\Pizza');
    }

    public function size(){
    	return $this->belongsTo('App\Size');
    }

    public function sizeType(){
    	return $this->belongsTo('App\SizeType', 'size_type_id');
    }

    public function combinations(){
    	return $this->hasMany('App\Combination');
    }
}
