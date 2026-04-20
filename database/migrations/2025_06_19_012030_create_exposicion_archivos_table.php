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
        Schema::create('exposicion_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exposicion_id')->constrained('exposiciones')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('filename'); // Original filename
            $table->string('stored_filename'); // Filename as stored on disk
            $table->string('mime_type');
            $table->bigInteger('file_size'); // Size in bytes
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exposicion_archivos');
    }
};
