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
            $table->boolean('assign_to_expo_proyecto')->default(false)->after('contenido');
            $table->unsignedBigInteger('exposicion_id')->nullable()->after('assign_to_expo_proyecto');
            
            $table->foreign('exposicion_id')->references('id')->on('exposiciones')->onDelete('set null');
            $table->index('exposicion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->dropForeign(['exposicion_id']);
            $table->dropIndex(['exposicion_id']);
            $table->dropColumn(['assign_to_expo_proyecto', 'exposicion_id']);
        });
    }
};