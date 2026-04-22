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
        Schema::create('estrategia_multimedia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estrategia_id')->constrained('estrategias')->onDelete('cascade');
            $table->foreignId('multimedia_id')->constrained('multimedia')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estrategia_multimedia');
    }
};
