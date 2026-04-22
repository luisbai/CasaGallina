<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstrategiaRedirectMiddleware
{
    private array $estrategiaRedirects = [
        'diversidad-biocultural' => '/programa/educacion-ambiental',
        're-conocer-los-territorios' => '/programa/mapeos-colectivos',
        'maiz-biodiversidad-y-cultura-en-el-consumo-cotidiano' => '/programa/educacion-ambiental',
        'nutricion-y-resiliencia-consumo-responsable-y-empatia-ambiental' => '/programa/cocina',
        'producir-y-recrear-la-escuela-modelos-para-fortalecer-los-saberes-escolares' => '/programa/escuelas',
        'entre-vecinos-encuentros-dialogos-e-intercambios' => '/programa/encuentros-vecinales',
        'repensando-el-consumo-cultura-de-la-reparacion' => '/programa/cultura-reparacion',
        'barrio-intercultural' => '/programa/educacion-ambiental',
        'engranar-la-energia-social-laboratorios-prototipos-y-proyectos-barriales' => '/programa/encuentros-vecinales',
        'saberes-intergeneracionales-y-procesos-de-educacion-no-formal' => '/programa/adultos-mayores',
        'resiliencia-en-comunidad-herramientas-y-redes-durante-el-distanciamiento-fisico' => '/programa/resiliencia-comunitaria'
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        // Check for old estrategia URLs: /estrategia/{slug}/{id} or /en/strategy/{slug}/{id}
        if (preg_match('#^(en/)?estrategia/([^/]+)/(\d+)#', $path, $matches) ||
            preg_match('#^(en/)?strategy/([^/]+)/(\d+)#', $path, $matches)) {

            $isEnglish = !empty($matches[1]);
            $slug = $matches[2];

            // Find redirect target
            if (isset($this->estrategiaRedirects[$slug])) {
                $redirectPath = $this->estrategiaRedirects[$slug];

                // Add English prefix if needed
                if ($isEnglish) {
                    $redirectPath = '/en' . str_replace('/programa/', '/program/', $redirectPath);
                }

                return redirect($redirectPath, 301);
            }
        }

        // Also handle direct /estrategias listing page
        if ($path === 'estrategias' || $path === 'en/strategies') {
            $redirectPath = $path === 'estrategias' ? '/programa' : '/en/program';
            return redirect($redirectPath, 301);
        }

        return $next($request);
    }
}
