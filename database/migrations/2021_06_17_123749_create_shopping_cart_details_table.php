<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shopping_cart_id');
            $table->unsignedBigInteger('article_id');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('shopping_cart_id')->references('id')->on('shopping_carts');
            $table->foreign('article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_cart_details');
    }
}
