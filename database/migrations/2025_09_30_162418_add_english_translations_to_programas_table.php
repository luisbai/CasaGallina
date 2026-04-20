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
        Schema::table('programas', function (Blueprint $table) {
            $table->text('titulo_en')->nullable()->after('titulo');
            $table->text('metadatos_en')->nullable()->after('metadatos');
            $table->text('contenido_en')->nullable()->after('contenido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->dropColumn([
                'titulo_en',
                'metadatos_en',
                'contenido_en'
            ]);
        });
    }
};
