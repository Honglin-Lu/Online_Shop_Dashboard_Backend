<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 100)->comment('the name of the customer');
            $table->string('phone', 50)->comment('the phone of the customer');
            $table->string('email', 200)->unique()->comment('the email of the customer');
            $table->string('address', 200)->comment('the address of the customer');
            $table->integer('status')->default(0)->comment('0: normal, 1: unnormal');
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
        Schema::dropIfExists('customers');
    }
}
