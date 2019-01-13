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

    public function getOrderPage(){

        $types = PizzaType::all();
        $pizzas = Pizza::all();
        $sizes = Size::all();
        $toppings = Topping::all();

        return view('pages.order_page',compact('pizzas','types', 'toppings'));

    }

    public function getPizza(Request $request){

        $rules = ['id' => 'required|numeric'];

        $this->validate($request, $rules);

        $id = $request->id;

        $pizzas = Pizza::orderBy('name', 'desc')
            ->where('pizza_type_id', $id)
            ->get();

        return response()->json($pizzas);
    }

    public function getSizePrice(Request $request){

        $rules = ['id' => 'required|numeric'];

        $this->validate($request, $rules);

        $id = $request->id;

        $pizza = Pizza::find($id);



        $sizePrice = $pizza->sizePrice;


        //add size to collection
        $sizes = [];

        foreach ($sizePrice as $size) {
                $sizes[] = $size->size;  
        }    


        return response()->json($sizePrice);

    }

    public function getToppingPrice(Request $request){
        
        $rules = ['id' => 'required|numeric'];

        $this->validate($request, $rules);

        $id = $request->id;

        //price
        $sizePrice = ToppingSizePrice::where('size_id', $id)->get();

        //get size
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
