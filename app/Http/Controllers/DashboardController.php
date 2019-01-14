<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderPizza;
use Illuminate\Http\Request;

class DashboardController extends Controller
{   
    /** 
    * Get dashboard view
    *
    *@param void
    *@return response
    */
    public function index(){

        //get all orders attach to response
    	$orders = Order::all();

    	return view('auth.dashboard',compact('orders'));

    }

    /** 
    * Get combinations
    *
    *@param HTTP Request $request
    *@return response
    */
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
