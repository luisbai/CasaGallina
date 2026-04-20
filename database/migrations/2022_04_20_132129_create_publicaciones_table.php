<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('status');
            $table->string('titulo');

            $table->string('tipo');
           
            $table->string('fecha_publicacion')->nullable();
            $table->string('coordinacion_editorial')->nullable();
            $table->string('diseno')->nullable();
            $table->string('numero_paginas')->nullable();
            $table->string('textos')->nullable();

            $table->text('sinopsis')->nullable();

            $table->text('campo_opcional_1_titulo')->nullable();
            $table->text('campo_opcional_1')->nullable();

            $table->text('campo_opcional_2_titulo')->nullable();
            $table->text('campo_opcional_2')->nullable();

            $table->text('campo_opcional_3_titulo')->nullable();
            $table->text('campo_opcional_3')->nullable();

            $table->text('campo_opcional_4_titulo')->nullable();
            $table->text('campo_opcional_4')->nullable();

            $table->text('campo_opcional_5_titulo')->nullable();
            $table->text('campo_opcional_5')->nullable();

            $table->text('campo_opcional_6_titulo')->nullable();
            $table->text('campo_opcional_6')->nullable();

            $table->text('campo_opcional_7_titulo')->nullable();
            $table->text('campo_opcional_7')->nullable();

            $table->text('beneficios')->nullable();
            $table->text('participantes')->nullable();

            $table->string('titulo_en');

            $table->text('fecha_publicacion_en')->nullable();
            $table->text('coordinacion_editorial_en')->nullable();
            $table->text('diseno_en')->nullable();
            $table->string('textos_en')->nullable();

            $table->text('sinopsis_en')->nullable();

            $table->text('campo_opcional_1_en_titulo')->nullable();
            $table->text('campo_opcional_1_en')->nullable();

            $table->text('campo_opcional_2_en_titulo')->nullable();
            $table->text('campo_opcional_2_en')->nullable();

            $table->text('campo_opcional_3_en_titulo')->nullable();
            $table->text('campo_opcional_3_en')->nullable();

            $table->text('campo_opcional_4_en_titulo')->nullable();
            $table->text('campo_opcional_4_en')->nullable();

            $table->text('campo_opcional_5_en_titulo')->nullable();
            $table->text('campo_opcional_5_en')->nullable();

            $table->text('campo_opcional_6_en_titulo')->nullable();
            $table->text('campo_opcional_6_en')->nullable();

            $table->text('campo_opcional_7_en_titulo')->nullable();
            $table->text('campo_opcional_7_en')->nullable();

            $table->integer('downloads')->default(0);
            $table->integer('views')->default(0);

            $table->integer('orden');
            
            $table->unsignedBigInteger('publicacion_multimedia_id');
            $table->unsignedBigInteger('publicacion_thumbnail_id');
            $table->timestamps();
            
            $table->foreign('publicacion_multimedia_id')->references('id')->on('multimedia')->onDelete('cascade');
            $table->foreign('publicacion_thumbnail_id')->references('id')->on('multimedia')->onDelete('cascade');

            $table->boolean('previsualizacion')->default(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publicaciones');
    }
}
