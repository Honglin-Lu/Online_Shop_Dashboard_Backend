<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id('id');
            $table->string('code', 200)->unique()->comment('the contract code');
            $table->integer('type')->default(0)->comment('0: permanent, 1: fixed-term, 2: casual');
            $table->date('starting_date')->comment('the starting date of the contract');
            $table->date('ending_date')->comment('the ending date of the contract');
            $table->decimal('salary', $precision = 8, $scale = 2)->comment('the salary of the employee');
            $table->integer('employee_id')->comment('the primary key of the table employees');
            $table->integer('status')->default(0)->comment('0：active, 1: inactive');
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
        Schema::dropIfExists('contracts');
    }
}
