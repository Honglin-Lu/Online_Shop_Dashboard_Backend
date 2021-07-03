<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 100)->comment('the name of the employee');
            $table->string('phone', 50)->comment('the phone number of the employee');
            $table->date('birthdate')->comment('the birth dte of the employee');
            $table->string('email', 200)->unique()->comment('the email of the employee ');
            $table->string('address', 200)->nullable()->comment('the address of the employee');
            $table->integer('contract_id')->comment('the primary key of the contracts table');
            $table->integer('department_id')->comment('the primary key of the departments table');
            $table->integer('status')->default(0)->comment('0：on_work, 1: off_work, 2: on_vacation');
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
        Schema::dropIfExists('employees');
    }
}
