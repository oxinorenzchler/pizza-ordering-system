<?php

namespace App\Http\Controllers;

use Mail;
use Session;
use App\Order;
use App\OrderPizza;
use App\Combination;
use App\ToppingSizePrice;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	public function store(Request $request){

		$rules = [
			'pizzatype' => 'required|numeric',
			'pizzaitems' => 'required|numeric',//op
			'sizetype' => 'required|numeric',
			'pizzainfo' =>'required|numeric',//op
			'pizzatotal' => 'required|numeric',//op
			'toppings' => 'nullable',
			'toppingscost' => 'nullable',//com
			'totalprice' => 'required|numeric',//o
			'name' => 'required|string',
			'email' => 'required|email',
			'contact' => 'required|string',
			'address' => 'required|string'
		];

		$this->validate($request, $rules);

		//store order_pizza
		$op = new OrderPizza;

		$op->pizza_id = $request->pizzaitems;
		$op->size_id = $request->sizetype + 1;
		$op->size_type_id = $request->sizetype + 1;
		$op->pizza_size_price_id = $request->pizzainfo;
		$op->toppings_price = $request->toppingscost;
		$op->pizza_price = $request->pizzatotal;

		if($op->save()){

			//check if there is combination
			if($request->toppings != null){


				foreach ($request->toppings as $topping) {

					$combination = new Combination;

					$combination->order_pizza_id = $op->id;

					$combination->topping_size_price_id = $topping;

					$toppings = ToppingSizePrice::find($topping);

					$combination->subtotal = $toppings->price;

					$combination->save();


				} 

			}

			//store to order
			$order = new Order;

			$order->name = $request->name;
			$order->email = $request->email;
			$order->contact = $request->contact;
			$order->address = $request->address;
			$order->order_pizza_id = $op->id;
			$order->total = $request->totalprice;

			$order->save();

			$email = $order->email;
			$name = $order->name;
			$address = $order->address;
			$contact = $order->contact;
			$pizza = $op->pizza->name;
			$size = $op->size->size.'" '.$op->sizeType->size;
			$price = $op->pizza_price;
			$toppingsPrice = $op->toppings_price;
			$total = $order->total;


			    //Send inquiry to gmail account
			Mail::send('emails.confirmation', [
				'name'=> $name, 
				'email' => $email, 
				'address' => $address,
				'contact' => $contact,
				'pizza' => $pizza,
				'size' => $size,
				'price' => $price,
				'toppingsPrice' => $toppingsPrice,
				'total' => $total,
			],

			function($message) use ($email,$name, $address, $contact, $pizza, $size, $price, $toppingsPrice, $total) {
				$message->to($email, $name)
				->cc('support@pizzaza.com', null)
				->subject
				('Order Confirmation');
				$message->from('no-reply@pizzaza.com','Pizzaza');
			});
				

			Session::flash('success_msg', 'Order successfull.');

			return redirect()->back();

		};




	}


}
