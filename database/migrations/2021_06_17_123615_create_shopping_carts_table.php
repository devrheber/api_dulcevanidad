<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->id();
            $table->string('url', 150);
            $table->boolean('state')->default(1);
            $table->string('code', 20)->unique();
            $table->string('voucher', 50);
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->timestamps();

            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_carts');
    }
}
