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
        // 1. Convert columns to JSON (or LONGTEXT)
        Schema::table('programas', function (Blueprint $table) {
            $table->longText('titulo')->change();
            $table->longText('contenido')->change();
            $table->longText('metadatos')->nullable()->change();
        });

        // 2. Migrate existing data
        $programas = DB::table('programas')->get();

        foreach ($programas as $programa) {
            $updates = [];
            $fields = ['titulo', 'contenido', 'metadatos'];

            foreach ($fields as $field) {
                $enField = $field . '_en';
                $esValue = $programa->$field;
                $enValue = $programa->$enField ?? '';

                $json = [
                    'es' => $esValue,
                    'en' => $enValue
                ];
                
                $updates[$field] = json_encode($json, JSON_UNESCAPED_UNICODE);
            }

            DB::table('programas')->where('id', $programa->id)->update($updates);
        }

        // 3. Drop English columns
        Schema::table('programas', function (Blueprint $table) {
            $table->dropColumn(['titulo_en', 'contenido_en', 'metadatos_en']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip down for now
    }
};
