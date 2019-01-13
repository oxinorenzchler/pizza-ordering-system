<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@getOrderPage')->name('order.page');
// get pizza
Route::get('/get-pizza', 'HomeController@getPizza')->name('get.pizza');
//get pizza size price
Route::get('/get-pizza-size', 'HomeController@getSizePrice')->name('get.sizePrice');
//get topping size and price
Route::get('/get-topping-price', 'HomeController@getToppingPrice')->name('get.toppingPrice');
//store order
Route::post('/submit-order', 'OrderController@store')->name('store.order');

Route::middleware(['auth'])->group(function(){
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

	Route::get('/get-combinations','DashboardController@getCombinations')->name('get.combinations');
});