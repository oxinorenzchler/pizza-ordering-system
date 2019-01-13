<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combinations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_pizza_id')->unsigned();
            $table->integer('topping_size_price_id')->unsigned();
            $table->float('subtotal');
            $table->timestamps();

              //FK
            $table->foreign('order_pizza_id')
            ->references('id')
            ->on('order_pizzas')
            ->onDelete('restrict')
            ->onUpdate('cascade');

             //FK
            $table->foreign('topping_size_price_id')
            ->references('id')
            ->on('topping_size_prices')
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
        Schema::dropIfExists('combinations');
    }
}
