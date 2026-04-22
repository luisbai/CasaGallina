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
            $table->bigInteger('thumbnail_id')->unsigned()->nullable()->after('multimedia_id');
            $table->foreign('thumbnail_id')->references('id')->on('multimedia')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['thumbnail_id']);
            if (Schema::hasColumn('tags', 'thumbnail_id')) {
                $table->dropColumn('thumbnail_id');
            }
        });
    }
};
