<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstrategiasToProgramasSeeder extends Seeder
{
    public function run()
    {
        $estrategias = DB::table('estrategias')->get();

        if ($estrategias->isEmpty()) {
            echo "⚠️ La tabla 'estrategias' está vacía.\n";
            return;
        }

        echo "🚀 INICIANDO INSERCIÓN REAL DE PROGRAMAS CON EMPAREJAMIENTO BLINDADO\n";
        echo "====================================================================\n";

        foreach ($estrategias as $estrategia) {
            $htmlEs = $estrategia->programas ?? $estrategia->contenido ?? '';
            $htmlEn = $estrategia->programas_en ?? $estrategia->contenido_en ?? '';

            $actividadesEs = $this->extraerActividadesEs($htmlEs);
            $bloquesEn = $this->extraerBloquesRawEn($htmlEn);

            if (empty($actividadesEs)) {
                continue;
            }

            echo "📂 Procesando Estrategia ID {$estrategia->id}...\n";

            foreach ($actividadesEs as $indexEs => $actividadEs) {
                $tituloEs = $actividadEs['titulo'];
                
                // Buscar par ideal usando el algoritmo de votación con desempate por nombres de ficha
                $parejaEn = $this->buscarVerdaderoParEnConVotacionDefinitiva($actividadEs, $indexEs, $bloquesEn);

                if ($parejaEn) {
                    $tituloEn = !empty($parejaEn['titulo']) ? $parejaEn['titulo'] : $tituloEs;
                    $fichaEn = $this->construirFichaConBaseEstructura($actividadEs['ficha_estructura'], $parejaEn['metadatos_valores']);
                    $contenidoEn = $parejaEn['contenido'];
                    echo "   ✅ Emparejado: \"{$tituloEs}\" -> \"{$tituloEn}\"\n";
                } else {
                    $tituloEn = $tituloEs;
                    $fichaEn = '';
                    $contenidoEn = '';
                    echo "   ⚠️ Sin traducción óptima: \"{$tituloEs}\" (Se respalda con ES)\n";
                }

                // Generar JSON estructurados para la tabla final
                $jsonTitulo    = json_encode(['es' => $tituloEs, 'en' => $tituloEn], JSON_UNESCAPED_UNICODE);
                $jsonContenido = json_encode(['es' => $actividadEs['contenido'], 'en' => $contenidoEn], JSON_UNESCAPED_UNICODE);
                $jsonMetadatos = json_encode(['es' => $actividadEs['ficha'], 'en' => $fichaEn], JSON_UNESCAPED_UNICODE);

                if (strlen($jsonTitulo) > 255) {
                    $jsonTitulo = json_encode(['es' => mb_substr($tituloEs, 0, 100), 'en' => mb_substr($tituloEn, 0, 100)], JSON_UNESCAPED_UNICODE);
                }

                $fechaCalculada = $this->calcularFechaCronologica($actividadEs['texto_plano_ficha']);
                $currentTime = now();

                // INSERCIÓN REAL EN LA BASE DE DATOS
                DB::table('programas')->insert([
                    'estado'                  => 'public',
                    'tipo'                    => 'externo', 
                    'fecha'                   => $fechaCalculada, 
                    'titulo'                  => $jsonTitulo,       
                    'contenido'               => $jsonContenido,  
                    'titulo_en'               => null,              
                    'contenido_en'            => null,              
                    'metadatos'               => $jsonMetadatos,        
                    'metadatos_en'            => null,              
                    'assign_to_expo_proyecto' => 1,                 
                    'created_at'              => $estrategia->created_at ?? $currentTime,
                    'updated_at'              => $estrategia->updated_at ?? $currentTime,
                ]);
            }
        }

        echo "====================================================================\n";
        echo "🎉 ¡Seeder finalizado! Todos los datos fueron migrados y emparejados.\n";
    }

    private function buscarVerdaderoParEnConVotacionDefinitiva($actividadEs, $indexEs, $bloquesEn)
    {
        if (empty($bloquesEn)) return null;

        $mejorBloque = null;
        $maxPuntuacion = -1;

        $tituloEsLimpio = mb_strtolower($actividadEs['titulo']);
        $textoPlanoFichaEs = mb_strtolower($actividadEs['texto_plano_ficha']);
        $cuerpoEsCrudo = mb_strtolower($actividadEs['titulo'] . ' ' . $actividadEs['texto_plano_ficha'] . ' ' . strip_tags($actividadEs['contenido']));

        preg_match_all('/\b\d+\b/', $actividadEs['texto_plano_ficha'], $numEsMatches);
        $numerosEs = $numEsMatches[0] ?? [];

        foreach ($bloquesEn as $indexEn => $bloqueEn) {
            $puntuacion = 0;
            $tituloEnLimpio = mb_strtolower($bloqueEn['titulo']);
            $textoFichaEnCrudo = mb_strtolower(implode(' ', $bloqueEn['metadatos_valores']));
            $cuerpoEnCrudo = mb_strtolower($bloqueEn['titulo'] . ' ' . $textoFichaEnCrudo . ' ' . strip_tags($bloqueEn['contenido']));

            // 1. Similitud de Títulos
            similar_text($tituloEsLimpio, $tituloEnLimpio, $porcentajeTitulo);
            $puntuacion += $porcentajeTitulo * 1.5;

            // 2. Diccionario de Conceptos Humanos
            $diccionarioConceptos = [
                'milpa' => 'maizefield',
                'maíz' => 'maize',
                'niñas' => 'workshop',
                'niños' => 'food',
                'huerta' => 'agroecology',
                'taller' => 'workshop',
                'encuentro' => 'encounter',
                'sabor' => 'flavor',
                'verde' => 'green',
                'nopal' => 'nopal'
            ];
            foreach ($diccionarioConceptos as $esKeyword => $enKeyword) {
                if (str_contains($tituloEsLimpio, $esKeyword) && str_contains($tituloEnLimpio, $enKeyword)) {
                    $puntuacion += 50; 
                }
            }

            // 3. CRITERIO DE DESEMPATE CRÍTICO: Buscar nombres propios de facilitadores/aliados de la ficha ES en la ficha EN
            $palabrasEs = array_filter(explode(' ', preg_replace('/[^\w\s]/u', '', $textoPlanoFichaEs)), function($w) { 
                return mb_strlen($w) > 5 && !in_array($w, ['fecha', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre', 'habitantes', 'santa', 'maría', 'ribera', 'presencial']); 
            });
            
            foreach ($palabrasEs as $palabra) {
                if (str_contains($textoFichaEnCrudo, $palabra)) {
                    $puntuacion += 60; // Gran peso acumulativo por coincidencia exacta de nombres en la ficha técnica
                }
            }

            // 4. Coincidencia de Números (fechas y cantidades)
            preg_match_all('/\b\d+\b/', $textoFichaEnCrudo, $numEnMatches);
            $numerosEn = $numEnMatches[0] ?? [];
            $coincidenciasNumericas = array_intersect($numerosEs, $numerosEn);
            $puntuacion += count($coincidenciasNumericas) * 35;

            // 5. Orden relativo original
            if ($indexEs === $indexEn) {
                $puntuacion += 15;
            }

            if ($puntuacion > $maxPuntuacion) {
                $maxPuntuacion = $puntuacion;
                $mejorBloque = $bloqueEn;
            }
        }

        if ($maxPuntuacion < 20) {
            return null;
        }

        return $mejorBloque;
    }

    private function extraerActividadesEs($html)
    {
        if (empty(trim($html))) return [];
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8"><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $actividades = []; $actividadActual = null;
        $nodoPrincipal = $dom->getElementsByTagName('div')->item(0);
        if (!$nodoPrincipal) return [];
        foreach ($nodoPrincipal->childNodes as $nodo) {
            if ($nodo->nodeType === XML_TEXT_NODE && empty(trim($nodo->nodeValue))) continue;
            $tag = strtolower($nodo->nodeName); $texto = trim($nodo->nodeValue); if (empty($texto)) continue;
            if (in_array($tag, ['h1', 'h2', 'h3'])) {
                if ($actividadActual) { $actividades[] = $this->finalizarActividadEs($actividadActual); }
                $actividadActual = ['titulo' => $texto, 'ficha_lineas' => [], 'ficha_estructura' => [], 'contenido_lineas' => [], 'texto_plano_ficha' => ''];
                continue;
            }
            if ($actividadActual) {
                if (str_contains($texto, ':') && !preg_match('/^https?:\/\//i', $texto)) {
                    $partes = explode(':', $texto, 2); $llave = trim($partes[0]); $valor = trim($partes[1] ?? '');
                    $actividadActual['ficha_lineas'][] = "<p><strong>" . ucfirst($llave) . ":</strong> " . $valor . "</p>";
                    $actividadActual['ficha_estructura'][] = $llave; $actividadActual['texto_plano_ficha'] .= ' ' . $texto;
                } else { $actividadActual['contenido_lineas'][] = $dom->saveHTML($nodo); }
            }
        }
        if ($actividadActual) { $actividades[] = $this->finalizarActividadEs($actividadActual); }
        return $actividades;
    }

    private function finalizarActividadEs($act) {
        return ['titulo' => $act['titulo'], 'ficha' => implode('', $act['ficha_lineas']), 'ficha_estructura' => $act['ficha_estructura'], 'contenido' => implode('', $act['contenido_lineas']), 'texto_plano_ficha' => $act['texto_plano_ficha']];
    }

    private function extraerBloquesRawEn($html)
    {
        if (empty(trim($html))) return [];
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8"><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $bloques = []; $bloqueActual = null;
        $nodoPrincipal = $dom->getElementsByTagName('div')->item(0);
        if (!$nodoPrincipal) return [];
        foreach ($nodoPrincipal->childNodes as $nodo) {
            if ($nodo->nodeType === XML_TEXT_NODE && empty(trim($nodo->nodeValue))) continue;
            $tag = strtolower($nodo->nodeName); $texto = trim($nodo->nodeValue); if (empty($texto)) continue;
            if (in_array($tag, ['h1', 'h2', 'h3'])) {
                if ($bloqueActual) { $bloques[] = $this->finalizarBloqueEn($bloqueActual); }
                $bloqueActual = ['titulo' => $texto, 'valores_metadatos' => [], 'contenido_lineas' => []];
                continue;
            }
            if ($bloqueActual) {
                if (str_contains($texto, ':') && !preg_match('/^https?:\/\//i', $texto)) {
                    $partes = explode(':', $texto, 2); $bloqueActual['valores_metadatos'][] = trim($partes[1] ?? '');
                } else { $bloqueActual['contenido_lineas'][] = $dom->saveHTML($nodo); }
            }
        }
        if ($bloqueActual) { $bloques[] = $this->finalizarBloqueEn($bloqueActual); }
        return $bloques;
    }

    private function finalizarBloqueEn($bloque) {
        return ['titulo' => $bloque['titulo'], 'metadatos_valores' => $bloque['valores_metadatos'], 'contenido' => implode('', $bloque['contenido_lineas'])];
    }

    private function construirFichaConBaseEstructura($estructuraEs, $valoresEn)
    {
        $htmlFicha = '';
        $diccionario = [
            'fecha' => 'Date',
            'mediadores' => 'Mediators',
            'facilitador' => 'Facilitator',
            'facilitadora' => 'Facilitator',
            'facilitadores' => 'Facilitators',
            'ilustradores' => 'Illustrated by',
            'aliados' => 'Allies',
            'aliado' => 'Ally',
            'participantes' => 'Participants',
            'participan' => 'Participants',
            'formato' => 'Format',
            'coordina' => 'Coordinated by',
            'monitores' => 'Monitors',
            'productoras' => 'Producers'
        ];

        foreach ($estructuraEs as $index => $llaveEs) {
            $llaveLimpia = mb_strtolower(trim($llaveEs));
            $labelEn = isset($diccionario[$llaveLimpia]) ? $diccionario[$llaveLimpia] : ucfirst($llaveEs);
            $valorEn = isset($valoresEn[$index]) ? $valoresEn[$index] : '';

            if (!empty($valorEn)) {
                $htmlFicha .= "<p><strong>{$labelEn}:</strong> {$valorEn}</p>";
            }
        }

        return $htmlFicha;
    }

    private function calcularFechaCronologica($textoFicha)
    {
        $texto = mb_strtolower($textoFicha);
        $ano = 2023; // Año base detectado en la mayoría de tus fichas
        if (preg_match('/\b(20\d{2}|19\d{2})\b/', $texto, $match)) { $ano = intval($match[1]); }
        $meses = ['enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04', 'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08', 'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'];
        $mesSeleccionado = '01';
        foreach ($meses as $nombre => $num) { if (str_contains($texto, $nombre)) { $mesSeleccionado = $num; } }
        preg_match_all('/\b(\d{1,2})\b/', $texto, $matchesDias);
        $diasValidos = [];
        foreach ($matchesDias[1] as $posibleDia) { $d = intval($posibleDia); if ($d >= 1 && $d <= 31) { $diasValidos[] = $d; } }
        if (!empty($diasValidos)) { return sprintf("%04d-%02d-%02d", $ano, $mesSeleccionado, end($diasValidos)); }
        return "{$ano}-{$mesSeleccionado}-01";
    }
}