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
        Schema::create('exposicion_multimedia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exposicion_id')->constrained('exposiciones')->onDelete('cascade');
            $table->foreignId('multimedia_id')->constrained('multimedia')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exposicion_multimedia');
    }
};
