<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToppingSizePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topping_size_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('topping_id')->unsigned();
            $table->integer('size_id')->unsigned();
            $table->float('price');
            $table->timestamps();


            //FK
            $table->foreign('topping_id')
            ->references('id')
            ->on('toppings')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            //FK
            $table->foreign('size_id')
            ->references('id')
            ->on('sizes')
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
        Schema::dropIfExists('topping_size_prices');
    }
}
