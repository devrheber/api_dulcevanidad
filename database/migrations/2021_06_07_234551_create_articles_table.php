<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 100)->unique();
            $table->string('detail', 255)->nullable();
            $table->decimal('price1', 10, 2);
            $table->decimal('price2', 10, 2)->nullable()->default(0);
            $table->decimal('price3', 10, 2)->nullable()->default(0);
            $table->boolean('state')->default(1);
            $table->boolean('stateDiscount')->default(0);
            $table->integer('quantity');
            $table->string('image', 100)->default('articles/default.png');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
