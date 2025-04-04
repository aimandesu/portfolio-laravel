<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('education_id');
            $table->text('description')->nullable();
//            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('education_id')->references('id')->on('education');
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}

