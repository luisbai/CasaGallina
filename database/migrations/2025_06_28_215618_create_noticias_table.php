<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['articulo', 'cronica', 'entrevista', 'otras_experiencias', 'resena_invitacion', 'noticias', 'enlaces', 'newsletter']);
            $table->string('titulo');
            $table->longText('contenido');
            $table->text('descripcion')->nullable();
            $table->text('palabras_clave')->nullable();
            $table->json('enlaces_externos')->nullable();
            $table->string('video_url')->nullable();
            $table->longText('transcripcion')->nullable();
            $table->json('datos_evento')->nullable();
            $table->string('autor')->nullable();
            $table->timestamp('fecha_publicacion');
            $table->boolean('activo')->default(true);
            $table->string('slug')->unique();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
