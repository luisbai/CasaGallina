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
        Schema::create('homepage_banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('background_image_id')->nullable();
            $table->text('content_es');
            $table->text('content_en');
            $table->string('cta_text_es')->nullable();
            $table->string('cta_text_en')->nullable();
            $table->string('cta_url_es')->nullable();
            $table->string('cta_url_en')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('background_image_id')->references('id')->on('multimedia')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_banners');
    }
};
