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
            $table->string('banner_articulo')->nullable();
            $table->string('banner_noticias')->nullable();
            $table->string('banner_entrevista')->nullable();
            $table->string('banner_cronica')->nullable();
            $table->string('banner_otras_experiencias')->nullable();
            $table->string('banner_resena_invitacion')->nullable();
            $table->string('banner_enlaces')->nullable();
            $table->string('banner_newsletter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noticias', function (Blueprint $table) {
            $table->dropColumn([
                'banner_articulo',
                'banner_noticias', 
                'banner_entrevista',
                'banner_cronica',
                'banner_otras_experiencias',
                'banner_resena_invitacion',
                'banner_enlaces',
                'banner_newsletter'
            ]);
        });
    }
};
