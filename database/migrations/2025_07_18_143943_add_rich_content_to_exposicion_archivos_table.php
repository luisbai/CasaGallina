<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ExposicionArchivo;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exposicion_archivos', function (Blueprint $table) {
            $table->longText('contenido')->nullable()->after('thumbnail');
        });

        // Migrate existing data: combine titulo and descripcion into contenido
        $archivos = ExposicionArchivo::all();
        foreach ($archivos as $archivo) {
            $contenido = '';
            
            if ($archivo->titulo) {
                $contenido .= '<h3>' . htmlspecialchars($archivo->titulo) . '</h3>';
            }
            
            if ($archivo->descripcion) {
                if ($contenido) {
                    $contenido .= '<br><br>';
                }
                $contenido .= '<p>' . nl2br(htmlspecialchars($archivo->descripcion)) . '</p>';
            }
            
            $archivo->update(['contenido' => $contenido]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exposicion_archivos', function (Blueprint $table) {
            $table->dropColumn('contenido');
        });
    }
};
