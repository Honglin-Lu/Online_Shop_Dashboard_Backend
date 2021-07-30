<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_answers', function (Blueprint $table) {
            $table->id('id');
            $table->integer('feedback_id');
            $table->text('answer')->comment('the answer of the feedback from the user');
            $table->integer('add_user_type')->default(0)->comment('0:employee, 1:customer');
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
        Schema::dropIfExists('feedback_answers');
    }
}
