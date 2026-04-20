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
        Schema::table('tags', function (Blueprint $table) {
            $table->string('nombre_en')->nullable()->after('nombre');
            $table->string('slug_en')->nullable()->after('slug');
            $table->text('descripcion_en')->nullable()->after('descripcion');
            $table->text('texto_en')->nullable()->after('texto');
            $table->text('sidebar_en')->nullable()->after('sidebar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_en',
                'slug_en',
                'descripcion_en',
                'texto_en',
                'sidebar_en'
            ]);
        });
    }
};
