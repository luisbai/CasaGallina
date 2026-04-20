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
            $table->text('donation_content')->nullable()->after('enable_donations');
            $table->unsignedBigInteger('donation_multimedia_id')->nullable()->after('donation_content');
            $table->foreign('donation_multimedia_id')->references('id')->on('multimedia')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noticias', function (Blueprint $table) {
            $table->dropForeign(['donation_multimedia_id']);
            $table->dropColumn(['donation_content', 'donation_multimedia_id']);
        });
    }
};
