<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_image', function (Blueprint $table) {
            $table->id('image_id');
            $table->unsignedBigInteger('files_id')->nullable();
            $table->string('image');
            $table->timestamps();

//            $table->foreign('files_id')->references('files_id')->on('files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_image');
    }
}
