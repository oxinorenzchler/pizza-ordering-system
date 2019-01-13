<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPizzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pizzas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pizza_id')->unsigned();
            $table->integer('size_id')->unsigned();
            $table->integer('size_type_id')->unsigned();
            $table->integer('pizza_size_price_id')->unsigned();
            $table->float('toppings_price')->nullable();
            $table->float('pizza_price');
            $table->timestamps();

             //FK
            $table->foreign('pizza_id')
            ->references('id')
            ->on('pizzas')
            ->onDelete('restrict')
            ->onUpdate('cascade');

             //FK
            $table->foreign('size_id')
            ->references('id')
            ->on('sizes')
            ->onDelete('restrict')
            ->onUpdate('cascade');

              //FK
            $table->foreign('size_type_id')
            ->references('id')
            ->on('size_types')
            ->onDelete('restrict')
            ->onUpdate('cascade');

             //FK
            $table->foreign('pizza_size_price_id')
            ->references('id')
            ->on('pizza_size_prices')
            ->onDelete('restrict')
            ->onUpdate('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_pizzas');
    }
}
