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
            $table->id('id');
            $table->string('name', 100)->comment('the name of the product');
            $table->decimal('buying_price')->comment('the buying price of the product');
            $table->decimal('selling_price')->comment('the selling price of the product');
            $table->integer('product_category_id');
            $table->integer('supplier_id');
            $table->integer('quantity')->comment('the quantity of the product');
            $table->string('description', 200)->nullable()->comment('the description of the product');
            $table->json('photo')->nullable()->comment('all the photos related to this product');
            $table->integer('status')->default(0)->comment('0: on-sale, 1: off-shelf');
            $table->integer('add_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->integer('delete_user')->nullable();
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
