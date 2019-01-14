<?php

namespace App\Http\Controllers;

use App\ToppingSizePrice;
use App\PizzaSizePrice;
use App\PizzaType;
use App\SizeType;
use App\Topping;
use App\Pizza;
use App\Size;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
    * Get order page
    *
    *@param HTTP Request $request
    *@return response
    */
    public function getOrderPage(){

        //get all types and attach to response
        $types = PizzaType::all();

        return view('pages.order_page',compact('types'));

    }

    /**
    * Get pizzas
    *
    *@param HTTP Request $request
    *@return response
    */
    public function getPizza(Request $request){

        //validation
        $rules = ['id' => 'required|numeric'];

        $this->validate($request, $rules);

        $id = $request->id;

        //fetch and return pizzas
        $pizzas = Pizza::orderBy('name', 'desc')
            ->where('pizza_type_id', $id)
            ->get();

        return response()->json($pizzas);
    }

    /**
    * Get Pizza Size and Price
    *
    *@param HTTP Request $request
    *@return response
    */
    public function getSizePrice(Request $request){

        //validation
        $rules = ['id' => 'required|numeric'];

        $this->validate($request, $rules);

        $id = $request->id;

        //fetch and return pizza size and price
        $pizza = Pizza::find($id);

        $sizePrice = $pizza->sizePrice;


        //add size to collection
        $sizes = [];

        foreach ($sizePrice as $size) {
                $sizes[] = $size->size;  
        }    


        return response()->json($sizePrice);

    }

     /**
    * Get Topping Price
    *
    *@param HTTP Request $request
    *@return response
    */
    public function getToppingPrice(Request $request){

        //validation
        $rules = ['id' => 'required|numeric'];

        $this->validate($request, $rules);

        $id = $request->id;

        //fetch and return topping size and price
        $sizePrice = ToppingSizePrice::where('size_id', $id)->get();

        //get size and toppings add to collection
        $size = [];
        $toppings = [];
        
        foreach ($sizePrice as $size) {
                $sizes[] = $size->size;  
        }   

        foreach($sizePrice as $topping){
            $toppings[] = $topping->topping; 
        }

        return response()->json($sizePrice);

    }
}
