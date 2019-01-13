<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderPizza;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

    	$orders = Order::all();

    	return view('auth.dashboard',compact('orders'));

    }

    public function getCombinations(Request $request){
    	$op = OrderPizza::find($request->id);

    	$toppings = [];
    	foreach ($op->combinations as $value) {
    		$toppings[] = $value->toppingSizePrice->topping;
    	}

    	$price = [];
    	foreach ($toppings as $value) {
    		$price[] = $value->sizePrice;	
    	}
    	return response()->json($toppings);
    }
}
