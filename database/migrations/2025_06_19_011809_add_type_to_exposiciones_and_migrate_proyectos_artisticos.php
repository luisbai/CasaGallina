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
        // Step 1: Add type column to exposiciones table
        Schema::table('exposiciones', function (Blueprint $table) {
            $table->enum('type', ['exposicion', 'proyecto-artistico'])->default('exposicion')->after('estado');
        });

        // Step 2: Change fecha from date to string to match Programa model
        Schema::table('exposiciones', function (Blueprint $table) {
            $table->string('fecha')->change();
        });

        // Step 3: Migrate data from proyectos_artisticos to exposiciones
        $proyectosArtisticos = DB::table('proyectos_artisticos')->get();
        
        foreach ($proyectosArtisticos as $proyecto) {
            $exposicionId = DB::table('exposiciones')->insertGetId([
                'estado' => $proyecto->estado,
                'type' => 'proyecto-artistico',
                'fecha' => $proyecto->fecha,
                'titulo' => $proyecto->titulo,
                'metadatos' => $proyecto->metadatos,
                'contenido' => $proyecto->contenido,
                'created_at' => $proyecto->created_at,
                'updated_at' => $proyecto->updated_at,
            ]);

            // Migrate multimedia relationships
            $multimediaRelations = DB::table('proyecto_artistico_multimedia')
                ->where('proyecto_artistico_id', $proyecto->id)
                ->get();

            foreach ($multimediaRelations as $relation) {
                DB::table('exposicion_multimedia')->insert([
                    'exposicion_id' => $exposicionId,
                    'multimedia_id' => $relation->multimedia_id,
                    'created_at' => $relation->created_at,
                    'updated_at' => $relation->updated_at,
                ]);
            }

            // Migrate tag relationships
            $tagRelations = DB::table('proyecto_artistico_tag')
                ->where('proyecto_artistico_id', $proyecto->id)
                ->get();

            foreach ($tagRelations as $relation) {
                DB::table('exposicion_tag')->insert([
                    'exposicion_id' => $exposicionId,
                    'tag_id' => $relation->tag_id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove migrated proyecto-artistico records from exposiciones
        DB::table('exposiciones')->where('type', 'proyecto-artistico')->delete();
        
        // Remove type column
        Schema::table('exposiciones', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        // Change fecha back to date
        Schema::table('exposiciones', function (Blueprint $table) {
            $table->date('fecha')->change();
        });
    }
};
