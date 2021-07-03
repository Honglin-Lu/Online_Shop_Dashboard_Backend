<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id');
            $table->integer('customer_id');
            $table->json('product_quantity');
            $table->decimal('subtotal')->comment('the subtotal price of this order, exclude the tax');
            $table->integer('vat_id');
            $table->integer('status')->default(0)->comment('0: processing, 1: completed, 2: closed');
            $table->integer('add_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->integer('delete_user')->nullable();
            $table->ipAddress('ip')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
