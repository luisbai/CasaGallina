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
        Schema::create('noticia_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('noticia_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('filename');
            $table->string('stored_filename');
            $table->string('thumbnail')->nullable();
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticia_archivos');
    }
};
