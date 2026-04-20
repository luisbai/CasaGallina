<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspaciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espacios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('url');
            $table->string('status');
            $table->string('ubicacion');
            $table->string('ubicacion_lat');
            $table->string('ubicacion_long');
            $table->unsignedBigInteger('multimedia_id');
            $table->timestamps();

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
        Schema::dropIfExists('espacios');
    }
}
