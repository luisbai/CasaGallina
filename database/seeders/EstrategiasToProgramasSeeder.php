<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstrategiasToProgramasSeeder extends Seeder
{
    public function run()
    {
        // 1. OBTENER LOS REGISTROS VIEJOS
        $estrategias = DB::table('estrategias')->get();

        if ($estrategias->isEmpty()) {
            echo "⚠️ La tabla 'estrategias' está vacía.\n";
            return;
        }

        foreach ($estrategias as $estrategia) {

            $htmlEspanyol = $estrategia->programas ?? '';
            $htmlIngles   = $estrategia->programas_en ?? '';

            // 2. PRE-PROCESAMIENTO DINÁMICO E INYECCIÓN DE SALTOS
            $htmlEspanyol = $this->convertirLineasHuorfanasEnTitulos($htmlEspanyol);
            $htmlIngles   = $this->convertirLineasHuorfanasEnTitulos($htmlIngles);

            // 3. CORTE POR ENCABEZADOS
            $bloquesEs = preg_split('/(<h1[^>]*>.*?<\/h1>|<h2[^>]*>.*?<\/h2>|<h3[^>]*>.*?<\/h3>)/is', $htmlEspanyol, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            $bloquesEn = preg_split('/(<h1[^>]*>.*?<\/h1>|<h2[^>]*>.*?<\/h2>|<h3[^>]*>.*?<\/h3>)/is', $htmlIngles, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

            $entradasEs = [];
            $entradasEn = [];

            $tituloActualEs = 'Actividad sin título';
            foreach ($bloquesEs as $bloque) {
                $bloque = trim($bloque);
                if (empty($bloque) || strip_tags($bloque) === '') continue;
                
                if (preg_match('/<(h1|h2|h3)[^>]*>(.*?)<\/\1>/is', $bloque, $match)) {
                    $tituloActualEs = trim(strip_tags($match[2]));
                    continue;
                }
                
                if (mb_strlen($tituloActualEs) > 150) continue; 

                $entradasEs[] = ['titulo' => $tituloActualEs, 'cuerpo' => $bloque];
            }

            $tituloActualEn = 'Untitled Activity';
            foreach ($bloquesEn as $bloque) {
                $bloque = trim($bloque);
                if (empty($bloque) || strip_tags($bloque) === '') continue;
                
                if (preg_match('/<(h1|h2|h3)[^>]*>(.*?)<\/\1>/is', $bloque, $match)) {
                    $tituloActualEn = trim(strip_tags($match[2]));
                    continue;
                }
                
                if (mb_strlen($tituloActualEn) > 150) continue; 

                $entradasEn[] = [
                    'titulo_en' => $tituloActualEn, 
                    'cuerpo_en' => $bloque,
                    'texto_limpio' => strtolower(strip_tags($bloque))
                ];
            }

            // 4. MAPEO E INSERCIÓN CLON DE PRODUCCIÓN
            foreach ($entradasEs as $entradaEsData) {
                $tituloEs = $entradaEsData['titulo'];
                $cuerpoEs = $entradaEsData['cuerpo'];

                $mejorCoincidencia = -1;
                $bloqueInglesElegido = null;
                $tituloEn = ''; 
                $cuerpoEn = '';

                $textoLimpioEs = strtolower(strip_tags($cuerpoEs));

                foreach ($entradasEn as $entradaEn) {
                    similar_text($textoLimpioEs, $entradaEn['texto_limpio'], $porcentaje);
                    if ($porcentaje > $mejorCoincidencia) {
                        $mejorCoincidencia = $porcentaje;
                        $bloqueInglesElegido = $entradaEn;
                    }
                }

                if ($bloqueInglesElegido && $mejorCoincidencia > 15) { 
                    $tituloEn = $bloqueInglesElegido['titulo_en'];
                    $cuerpoEn = $bloqueInglesElegido['cuerpo_en'];
                }

                if (empty($tituloEn) || mb_strlen($tituloEn) > 150) {
                    $tituloEn = $tituloEs; 
                }

                // Determinar fecha real
                if (preg_match_all('/\b(20\d{2})\b/', $cuerpoEs, $matchesAnos)) {
                    $fechaRealMySql = max($matchesAnos[1]) . "-01-01"; 
                } else {
                    $fechaRealMySql = "2025-04-10"; 
                }

                // --- PROCESAR ESPAÑOL TOLERANTE A \N Y ETIQUETAS INLINE ---
                // Estandarizamos los saltos de línea de texto plano convirtiéndolos en HTML
                $cuerpoEsEstandarizado = str_replace(["\r\n", "\r", "\n"], '<br>', $cuerpoEs);
                $lineasEs = preg_split('/(<p[^>]*>|<\/p>|<br\s*\/?>)/i', $cuerpoEsEstandarizado, -1, PREG_SPLIT_NO_EMPTY);
                
                $fichaEsArray = [];
                $descripcionEsArray = [];

                foreach ($lineasEs as $linea) {
                    $lineaTrim = trim($linea);
                    if (empty($lineaTrim) || strip_tags($lineaTrim) === '') continue;

                    // Regex mejorada: detecta cualquier palabra clave seguida de ':' al inicio (limpia o con tags de estilo/strong)
                    if (preg_match('/^(?:<[^>]+>)*\s*([A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]{2,35})\s*(?:<\/[^>]+>)*\s*:\s*(.*)/u', $lineaTrim, $mFicha)) {
                        $llave = trim(strip_tags($mFicha[1]));
                        $valor = trim($mFicha[2]);
                        
                        if (mb_strlen($llave) < 40 && !empty($valor)) {
                            $fichaEsArray[] = "<p><strong>" . ucfirst($llave) . ":</strong> " . trim(strip_tags($valor, '<a><em>i<b><strong>')) . "</p>";
                            continue;
                        }
                    }

                    // Si no es un elemento llave-valor de ficha, va íntegro a la descripción
                    $descripcionEsArray[] = "<p>" . trim(strip_tags($lineaTrim, '<a><em>i<b><strong>')) . "</p>";
                }

                // --- PROCESAR INGLÉS TOLERANTE A \N Y ETIQUETAS INLINE ---
                $fichaEnArray = [];
                $descripcionEnArray = [];

                if (!empty($cuerpoEn)) {
                    $cuerpoEnEstandarizado = str_replace(["\r\n", "\r", "\n"], '<br>', $cuerpoEn);
                    $lineasEn = preg_split('/(<p[^>]*>|<\/p>|<br\s*\/?>)/i', $cuerpoEnEstandarizado, -1, PREG_SPLIT_NO_EMPTY);
                    
                    foreach ($lineasEn as $linea) {
                        $lineaTrim = trim($linea);
                        if (empty($lineaTrim) || strip_tags($lineaTrim) === '') continue;

                        if (preg_match('/^(?:<[^>]+>)*\s*([A-Za-z0-9\s]{2,35})\s*(?:<\/[^>]+>)*\s*:\s*(.*)/', $lineaTrim, $mFichaEn)) {
                            $llaveEn = trim(strip_tags($mFichaEn[1]));
                            $valorEn = trim($mFichaEn[2]);

                            if (mb_strlen($llaveEn) < 40 && !empty($valorEn)) {
                                $fichaEnArray[] = "<p><strong>" . ucfirst($llaveEn) . ":</strong> " . trim(strip_tags($valorEn, '<a><em>i<b><strong>')) . "</p>";
                                continue;
                            }
                        }

                        $descripcionEnArray[] = "<p>" . trim(strip_tags($lineaTrim, '<a><em>i<b><strong>')) . "</p>";
                    }
                }

                $fichaEsFinal = implode("", $fichaEsArray);
                $fichaEnFinal = implode("", $fichaEnArray);
                $descEsFinal  = implode("", $descripcionEsArray);
                $descEnFinal  = implode("", $descripcionEnArray);

                // Sanitización anti-imágenes rotas
                $fichaEsFinal = preg_replace('/<img[^>]*>/i', '', $fichaEsFinal);
                $fichaEnFinal = preg_replace('/<img[^>]*>/i', '', $fichaEnFinal);
                $descEsFinal  = preg_replace('/<img[^>]*>/i', '', $descEsFinal);
                $descEnFinal  = preg_replace('/<img[^>]*>/i', '', $descEnFinal);

                // CONSTRUCCIÓN DE JSONs INTEGRADOS 
                $jsonTitulo      = json_encode(['es' => "<p><em>" . $tituloEs . "</em>: activaciones comunitarias</p><p></p>", 'en' => "<p><em>" . $tituloEn . "</em>: community activations</p><p></p>"], JSON_UNESCAPED_UNICODE);
                $jsonDescripcion = json_encode(['es' => $descEsFinal, 'en' => $descEnFinal], JSON_UNESCAPED_UNICODE);
                $jsonFicha       = json_encode(['es' => $fichaEsFinal, 'en' => $fichaEnFinal], JSON_UNESCAPED_UNICODE);

                if (strlen($jsonTitulo) > 255) {
                    continue;
                }

                if (DB::table('programas')->where('titulo', $jsonTitulo)->exists()) {
                    continue;
                }

                $currentTime = now();

                // 5. INSERCIÓN TOTALMENTE RESILIENTE
                DB::table('programas')->insert([
                    'estado'                  => 'public',
                    'tipo'                    => 'externo', 
                    'fecha'                   => $fechaRealMySql, 
                    'titulo'                  => $jsonTitulo,       
                    'contenido'               => $jsonDescripcion,  
                    'titulo_en'               => null,              
                    'contenido_en'            => null,              
                    'metadatos'               => $jsonFicha,        
                    'metadatos_en'            => null,              
                    'assign_to_expo_proyecto' => 1,                 
                    'created_at'              => $currentTime,
                    'updated_at'              => $currentTime,
                ]);

                echo "🟢 Migrado con éxito (Limpieza de saltos \\n efectuada): " . mb_substr($tituloEs, 0, 40) . "...\n";
            }
        }
    }

    private function convertirLineasHuorfanasEnTitulos($html)
    {
        if (empty($html)) return '';
        $htmlEstandar = str_replace(["\r\n", "\r", "\n"], '<br>', $html);
        $lineas = preg_split('/(<p[^>]*>|<\/p>|<br\s*\/?>)/i', $htmlEstandar, -1, PREG_SPLIT_NO_EMPTY);
        $htmlModificado = [];

        foreach ($lineas as $linea) {
            $lineaLimpia = trim(strip_tags($linea));
            if (empty($lineaLimpia)) continue;

            if (mb_strlen($lineaLimpia) < 90 && 
                !str_ends_with($lineaLimpia, '.') && 
                !str_contains($lineaLimpia, ':')) {
                $htmlModificado[] = "<h1>" . trim(strip_tags($linea, '<a><em>i<b><strong>')) . "</h1>";
            } else {
                $htmlModificado[] = $linea;
            }
        }
        return implode("\n", $htmlModificado);
    }
}