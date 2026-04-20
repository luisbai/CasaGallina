<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspacioEstrategiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espacio_estrategias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('espacio_id');
            $table->unsignedBigInteger('estrategia_id');
            $table->timestamps();

            $table->foreign('estrategia_id')->references('id')->on('estrategias')->onDelete('cascade');
            $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('espacio_estrategias');
    }
}
