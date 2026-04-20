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
            $table->unsignedBigInteger('exposicion_id')->nullable()->after('activo');
            $table->foreign('exposicion_id')->references('id')->on('exposiciones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noticias', function (Blueprint $table) {
            $table->dropForeign(['exposicion_id']);
            $table->dropColumn('exposicion_id');
        });
    }
};
