<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img');
            $table->integer('price');
            $table->string('desc');
            $table->string('detail');
            $table->unsignedBigInteger('product_cat')->nullable();
            $table->foreign('product_cat')->references('id')->on('category')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_cat')->nullable();
            $table->foreign('supplier_cat')->references('id')->on('suppliers')->onDelete('cascade');
            $table->long('qty');
            $table->integer('total_price');
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
