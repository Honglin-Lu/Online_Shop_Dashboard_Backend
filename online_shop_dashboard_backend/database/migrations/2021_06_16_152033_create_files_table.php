<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 200)->comment('the name of the file');
            $table->string('mime', 100)->comment('the MIME type of the file');
            $table->integer('size')->comment('the size of the file, and the unit is byte');
            $table->string('path', 200)->comment('the path of the file');
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
        Schema::dropIfExists('files');
    }
}
