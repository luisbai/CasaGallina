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
        // 1. Convert columns to LONGTEXT (for JSON) if they aren't already suitable
        Schema::table('exposiciones', function (Blueprint $table) {
            $table->longText('titulo')->change();
            $table->longText('contenido')->change();
            $table->longText('metadatos')->nullable()->change();
        });

        // 2. Migrate existing data (Wrap in 'es')
        $items = DB::table('exposiciones')->get();

        foreach ($items as $item) {
            $updates = [];
            $fields = ['titulo', 'contenido', 'metadatos'];

            foreach ($fields as $field) {
                $esValue = $item->$field;
                
                // Skip if null (though titulo/contenido likely not null)
                if (is_null($esValue)) {
                    continue;
                }

                // If metadatos is already JSON string, we keep it as the 'es' value (raw string or decoded? Spatie expects array/string)
                // For 'metadatos' being an 'array' cast in model, the raw DB value is JSON string.
                // We want: {"es": <original_value>, "en": ""}
                // If original_value is a JSON string "[...]", then "es" => "[...]"? 
                // No, Spatie stores values. If `metadatos` is structured, it's tricky.
                // BUT, if `metadatos` is just a text field in UI, then treating it as string is fine.
                // Given Page.php treats it as string, let's wrap it as string.
                
                // Check if it's already translated (starts with {"es":) to avoid double migration? 
                // Unlikely for clean run, but good practice.
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
                DB::table('exposiciones')->where('id', $item->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Complex to reverse without losing English data
    }
};
