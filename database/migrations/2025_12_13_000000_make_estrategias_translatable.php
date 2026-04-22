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
        // 1. Convert columns to JSON (or LONGTEXT which acts as JSON)
        Schema::table('estrategias', function (Blueprint $table) {
            // We use longText to ensure JSON compatibility and space
            $table->longText('titulo')->change();
            $table->longText('subtitulo')->change();
            $table->longText('contenido')->change();
            $table->longText('programas')->change();
            $table->longText('colaboradores')->change();
            $table->longText('lugar')->change();
            $table->longText('campo_opcional_1')->change();
            $table->longText('campo_opcional_1_titulo')->change();
            $table->longText('campo_opcional_2')->change();
            $table->longText('campo_opcional_2_titulo')->change();
            $table->longText('campo_opcional_3')->change();
            $table->longText('campo_opcional_3_titulo')->change();
            $table->longText('campo_opcional_4')->change();
            $table->longText('campo_opcional_4_titulo')->change();
            $table->longText('campo_opcional_5')->change();
            $table->longText('campo_opcional_5_titulo')->change();
        });

        // 2. Migrate existing data
        $estrategias = DB::table('estrategias')->get();

        foreach ($estrategias as $estrategia) {
            $updates = [];
            $fields = [
                'titulo', 'subtitulo', 'contenido', 'programas', 'colaboradores', 'lugar',
                'campo_opcional_1', 'campo_opcional_1_titulo',
                'campo_opcional_2', 'campo_opcional_2_titulo',
                'campo_opcional_3', 'campo_opcional_3_titulo',
                'campo_opcional_4', 'campo_opcional_4_titulo',
                'campo_opcional_5', 'campo_opcional_5_titulo'
            ];

            foreach ($fields as $field) {
                $enField = $field . '_en';
                // Handle special cases for optional titles if they follow a different naming convention
                if (str_contains($field, 'campo_opcional') && str_contains($field, '_titulo')) {
                     // e.g. campo_opcional_1_titulo -> campo_opcional_1_en_titulo based on model
                     $parts = explode('_titulo', $field);
                     $enField = $parts[0] . '_en_titulo';
                } elseif(str_contains($field, 'campo_opcional')) {
                    // campo_opcional_1 -> campo_opcional_1_en
                    $enField = $field . '_en';
                }

                $esValue = $estrategia->$field;
                $enValue = $estrategia->$enField ?? '';

                // If it's already JSON (check for {), skip or handle carefully. 
                // Assuming currently plain text.
                $json = [
                    'es' => $esValue,
                    'en' => $enValue
                ];
                
                $updates[$field] = json_encode($json, JSON_UNESCAPED_UNICODE);
            }

            DB::table('estrategias')->where('id', $estrategia->id)->update($updates);
        }

        // 3. Drop English columns
        Schema::table('estrategias', function (Blueprint $table) {
            $table->dropColumn([
                'titulo_en', 'subtitulo_en', 'contenido_en', 
                'programas_en', 'colaboradores_en', 'lugar_en', 'fecha_en',
                'campo_opcional_1_en', 'campo_opcional_1_en_titulo',
                'campo_opcional_2_en', 'campo_opcional_2_en_titulo',
                'campo_opcional_3_en', 'campo_opcional_3_en_titulo',
                'campo_opcional_4_en', 'campo_opcional_4_en_titulo',
                'campo_opcional_5_en', 'campo_opcional_5_en_titulo',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert is complex, might imply data loss if not careful. 
        // For now, we skip detailed down logic for prototype speed, 
        // relying on backup/restore for safety.
    }
};
