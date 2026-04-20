<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {
            // Add column only if it doesn't exist
            if (!Schema::hasColumn('publicaciones', 'exposicion_id')) {
                $table->unsignedBigInteger('exposicion_id')->nullable()->after('id');
            }
        });

        // Add foreign key only if it doesn't exist
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'publicaciones'
            AND COLUMN_NAME = 'exposicion_id'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (empty($foreignKeys)) {
            Schema::table('publicaciones', function (Blueprint $table) {
                $table->foreign('exposicion_id')->references('id')->on('exposiciones')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {
            // Drop foreign key if it exists (using column name)
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = 'publicaciones'
                AND COLUMN_NAME = 'exposicion_id'
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            
            if (!empty($foreignKeys)) {
                $table->dropForeign(['exposicion_id']);
            }
            
            // Drop column if it exists
            if (Schema::hasColumn('publicaciones', 'exposicion_id')) {
                $table->dropColumn('exposicion_id');
            }
        });
    }
}; 