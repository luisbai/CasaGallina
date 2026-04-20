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
        Schema::table('noticias', function (Blueprint $table) {
            $table->string('titulo_en')->nullable()->after('titulo');
            $table->longText('contenido_en')->nullable()->after('contenido');
            $table->text('descripcion_en')->nullable()->after('descripcion');
            $table->string('slug_en')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noticias', function (Blueprint $table) {
            $table->dropColumn(['titulo_en', 'contenido_en', 'descripcion_en', 'slug_en']);
        });
    }
};
