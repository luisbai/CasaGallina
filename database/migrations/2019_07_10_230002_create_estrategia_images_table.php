<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstrategiaImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estrategia_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estrategia_id');
            $table->unsignedBigInteger('multimedia_id');
            $table->timestamps();

            $table->foreign('estrategia_id')->references('id')->on('estrategias')->onDelete('cascade');
            $table->foreign('multimedia_id')->references('id')->on('multimedia')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estrategia_images');
    }
}
