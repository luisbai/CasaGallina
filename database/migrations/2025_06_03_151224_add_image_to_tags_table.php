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
            // Only add column if it doesn't exist
            // Note: multimedia_id may have been added in a previous migration (2025_05_21_184710)
            if (!Schema::hasColumn('tags', 'multimedia_id')) {
                $table->bigInteger('multimedia_id')->unsigned()->nullable()->after('sidebar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            // Only drop column if it exists
            if (Schema::hasColumn('tags', 'multimedia_id')) {
                $table->dropColumn('multimedia_id');
            }
        });
    }
};
