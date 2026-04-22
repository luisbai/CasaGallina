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
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->enum('form_type', ['publication', 'newsletter', 'contact']);
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('organizacion')->nullable();
            $table->unsignedBigInteger('publicacion_id')->nullable();
            $table->boolean('subscribed_to_mailrelay')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('publicacion_id')->references('id')->on('publicaciones')->onDelete('set null');
            $table->index(['form_type', 'created_at']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
