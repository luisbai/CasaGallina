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
        // First, update any NULL values to empty string
        DB::table('programas')->whereNull('metadatos')->update(['metadatos' => '{}']);
        
        // Convert JSON data to string representation
        $programas = DB::table('programas')->whereNotNull('metadatos')->get();
        foreach ($programas as $programa) {
            $jsonData = json_decode($programa->metadatos, true);
            $stringData = is_array($jsonData) ? json_encode($jsonData) : (string) $programa->metadatos;
            DB::table('programas')->where('id', $programa->id)->update(['metadatos' => $stringData]);
        }
        
        // Now change the column type to longText
        Schema::table('programas', function (Blueprint $table) {
            $table->longText('metadatos')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->json('metadatos')->nullable()->change();
        });
    }
};
