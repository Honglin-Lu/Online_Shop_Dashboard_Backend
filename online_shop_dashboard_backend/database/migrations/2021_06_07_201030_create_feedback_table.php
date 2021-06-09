<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 50)->comment('the name of the feedback offer');
            $table->string('email', 200)->comment('the email of the feedback offer');
            $table->string('subject', 200)->comment('the title of the feedback');
            $table->text('message')->comment('the content of the feedback');
            $table->tinyInteger('status')->default(0)->comment('0:unprocessed, 1:processed');
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
        Schema::dropIfExists('feedback');
    }
}
