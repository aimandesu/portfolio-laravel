<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id('files_id');
            $table->unsignedBigInteger('education_id');
            $table->text('description')->nullable();
//            $table->string('image')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('education_id')->references('education_id')->on('education')->onDelete('cascade');
            $table->foreign('image_id')->references('image_id')->on('files_image')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}

