<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstrategiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estrategias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('subtitulo');
            $table->text('contenido');
            $table->text('programas')->nullable();

            $table->text('campo_opcional_1_titulo')->nullable();
            $table->text('campo_opcional_1')->nullable();

            $table->text('campo_opcional_2_titulo')->nullable();
            $table->text('campo_opcional_2')->nullable();

            $table->text('campo_opcional_3_titulo')->nullable();
            $table->text('campo_opcional_3')->nullable();

            $table->text('colaboradores')->nullable();
            $table->string('fecha')->nullable();
            $table->string('publico')->nullable();
            $table->string('lugar')->nullable();

            $table->text('campo_opcional_4_titulo')->nullable();
            $table->text('campo_opcional_4')->nullable();

            $table->text('campo_opcional_5_titulo')->nullable();
            $table->text('campo_opcional_5')->nullable();

            $table->text('beneficios')->nullable();
            $table->text('participantes')->nullable();

            $table->string('titulo_en');
            $table->text('subtitulo_en');
            $table->text('contenido_en');
            $table->text('programas_en')->nullable();

            $table->text('campo_opcional_1_en_titulo')->nullable();
            $table->text('campo_opcional_1_en')->nullable();

            $table->text('campo_opcional_2_en_titulo')->nullable();
            $table->text('campo_opcional_2_en')->nullable();

            $table->text('campo_opcional_3_en_titulo')->nullable();
            $table->text('campo_opcional_3_en')->nullable();

            $table->text('colaboradores_en')->nullable();
            $table->string('fecha_en')->nullable();
            $table->string('publico_en')->nullable();
            $table->string('lugar_en')->nullable();

            $table->text('campo_opcional_4_en_titulo')->nullable();
            $table->text('campo_opcional_4_en')->nullable();

            $table->text('campo_opcional_5_en_titulo')->nullable();
            $table->text('campo_opcional_5_en')->nullable();
            
            $table->unsignedBigInteger('destacada_multimedia_id');
            $table->timestamps();
            
            $table->foreign('destacada_multimedia_id')->references('id')->on('multimedia')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estrategias');
    }
}
