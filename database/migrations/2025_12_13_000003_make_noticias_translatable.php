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
        // 1. Convert columns to LONGTEXT (for JSON)
        Schema::table('noticias', function (Blueprint $table) {
            $table->longText('titulo')->change();
            $table->longText('contenido')->change();
            $table->longText('descripcion')->nullable()->change();
        });

        // 2. Migrate existing data (Wrap in 'es')
        $items = DB::table('noticias')->get();

        foreach ($items as $item) {
            $updates = [];
            $fields = ['titulo', 'contenido', 'descripcion'];

            foreach ($fields as $field) {
                $esValue = $item->$field;
                
                if (is_null($esValue)) {
                    continue;
                }

                // Check if already translated to avoid double migration
                if (str_starts_with($esValue, '{"es":')) {
                    continue; 
                }

                $json = [
                    'es' => $esValue,
                    'en' => ''
                ];
                
                $updates[$field] = json_encode($json, JSON_UNESCAPED_UNICODE);
            }

            if (!empty($updates)) {
                DB::table('noticias')->where('id', $item->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down needed
    }
};
