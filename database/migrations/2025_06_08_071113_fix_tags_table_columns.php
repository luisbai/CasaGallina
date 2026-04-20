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
            // Add sidebar column if it doesn't exist
            if (!Schema::hasColumn('tags', 'sidebar')) {
                $table->text('sidebar')->nullable()->after('descripcion');
            }
            
            // Add multimedia_id column if it doesn't exist
            if (!Schema::hasColumn('tags', 'multimedia_id')) {
                $table->bigInteger('multimedia_id')->unsigned()->nullable()->after('sidebar');
            }
            
            // Add texto column if it doesn't exist
            if (!Schema::hasColumn('tags', 'texto')) {
                $table->text('texto')->nullable()->after('descripcion');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            if (Schema::hasColumn('tags', 'sidebar')) {
                $table->dropColumn('sidebar');
            }
            if (Schema::hasColumn('tags', 'multimedia_id')) {
                $table->dropColumn('multimedia_id');
            }
            if (Schema::hasColumn('tags', 'texto')) {
                $table->dropColumn('texto');
            }
        });
    }
};
