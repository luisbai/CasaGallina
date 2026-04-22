<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('publicacion_multimedia_id')->nullable()->change();
            $table->unsignedBigInteger('publicacion_thumbnail_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {
            // Check if there are null values before reverting? 
            // For now, we just attempt to revert. If nulls exist, this will fail.
            $table->unsignedBigInteger('publicacion_multimedia_id')->nullable(false)->change();
            $table->unsignedBigInteger('publicacion_thumbnail_id')->nullable(false)->change();
        });
    }
};
