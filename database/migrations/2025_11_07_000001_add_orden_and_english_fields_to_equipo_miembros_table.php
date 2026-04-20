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
        Schema::table('equipo_miembros', function (Blueprint $table) {
            // Add orden column if it doesn't exist
            if (!Schema::hasColumn('equipo_miembros', 'orden')) {
                $table->integer('orden')->nullable()->after('tipo');
            }
            
            // Add English translation fields if they don't exist
            if (!Schema::hasColumn('equipo_miembros', 'titulo_en')) {
                $table->string('titulo_en')->nullable()->after('titulo');
            }
            
            if (!Schema::hasColumn('equipo_miembros', 'biografia_en')) {
                $table->text('biografia_en')->nullable()->after('biografia');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipo_miembros', function (Blueprint $table) {
            if (Schema::hasColumn('equipo_miembros', 'orden')) {
                $table->dropColumn('orden');
            }
            
            if (Schema::hasColumn('equipo_miembros', 'titulo_en')) {
                $table->dropColumn('titulo_en');
            }
            
            if (Schema::hasColumn('equipo_miembros', 'biografia_en')) {
                $table->dropColumn('biografia_en');
            }
        });
    }
};


