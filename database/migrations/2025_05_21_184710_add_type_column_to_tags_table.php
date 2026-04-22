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
            // Add type column first
            if (!Schema::hasColumn('tags', 'type')) {
                $table->string('type')->nullable()->after('slug');
            }
            // Only add columns that don't exist yet
            if (!Schema::hasColumn('tags', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('type');
            }
            if (!Schema::hasColumn('tags', 'texto')) {
                $table->text('texto')->nullable()->after('descripcion');
            }
            if (!Schema::hasColumn('tags', 'multimedia_id')) {
                $table->unsignedBigInteger('multimedia_id')->nullable()->after('texto');
                $table->foreign('multimedia_id')->references('id')->on('multimedia')->onDelete('set null');
            }
            if (!Schema::hasColumn('tags', 'sidebar')) {
                $table->text('sidebar')->nullable()->after('multimedia_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('sidebar');
        });
    }
};
