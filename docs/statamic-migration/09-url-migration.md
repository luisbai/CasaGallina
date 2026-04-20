# URL Structure Migration

This document outlines the changes to the URL structure as part of the migration to Statamic CMS and the implementation of redirects to maintain SEO value.

## Current URL Structure Issues

The current website has several URL structure issues that will be addressed:

1. **Numeric IDs in URLs**: URLs include IDs (e.g., `/publicacion/slug-name/35`)
2. **Inconsistent naming**: Single vs. plural forms (e.g., `/publicacion` vs. `/publicaciones`)
3. **Section name changes**: Renaming "Estrategias" to "Programa" and "Numeralia" to "Impacto"

## New URL Structure

The new URL structure will follow these patterns:

| Content Type | Current URL Pattern | New URL Pattern |
|--------------|---------------------|-----------------|
| Programs | `/estrategia/slug-name/id` | `/programa/slug-name` |
| Programs List | `/estrategias` | `/programa` |
| Publications | `/publicacion/slug-name/id` | `/publicaciones/slug-name` |
| Publications List | `/publicaciones` | `/publicaciones` |
| Newsletters | `/boletin/slug-name/id` | `/boletines/slug-name` |
| Newsletters List | `/boletines` | `/boletines` |
| Impact (formerly Numeralia) | `/numeralia` | `/impacto` |
| News (new section) | N/A | `/noticias/slug-name` |
| News List | N/A | `/noticias` |
| Materials (new section) | N/A | `/materiales/slug-name` |
| Materials List | N/A | `/materiales` |

## Redirect Implementation

To maintain SEO value and prevent broken links, a comprehensive redirect system will be implemented using Laravel middleware.

### Redirect Middleware

Create a middleware to handle all redirects from old URLs to new URLs:

```php
<?php
// app/Http/Middleware/RedirectOldUrls.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Estrategia;
use App\Models\Publicacion;
use App\Models\Boletin;

class RedirectOldUrls
{
    public function handle(Request $request, Closure $next)
    {
        // Extract the current path
        $path = $request->path();
        
        // Estrategia to Programa redirect
        if (preg_match('#^estrategia/([^/]+)/(\d+)$#', $path, $matches)) {
            $slug = $matches[1];
            $id = $matches[2];
            
            // Lookup the corresponding entry to ensure correct slug
            $estrategia = Estrategia::find($id);
            if ($estrategia) {
                // Use the original slug if available in Statamic
                $newSlug = $this->getStatamicSlug('programa', $id) ?? $slug;
                return redirect("/programa/{$newSlug}", 301);
            }
            
            // Fallback to the URL slug if entry not found
            return redirect("/programa/{$slug}", 301);
        }
        
        // Estrategias to Programa redirect (list page)
        if ($path === 'estrategias') {
            return redirect('/programa', 301);
        }
        
        // Publicacion to Publicaciones redirect
        if (preg_match('#^publicacion/([^/]+)/(\d+)$#', $path, $matches)) {
            $slug = $matches[1];
            $id = $matches[2];
            
            // Lookup the corresponding entry to ensure correct slug
            $publicacion = Publicacion::find($id);
            if ($publicacion) {
                // Use the original slug if available in Statamic
                $newSlug = $this->getStatamicSlug('publicaciones', $id) ?? $slug;
                return redirect("/publicaciones/{$newSlug}", 301);
            }
            
            // Fallback to the URL slug if entry not found
            return redirect("/publicaciones/{$slug}", 301);
        }
        
        // Boletin to Boletines redirect
        if (preg_match('#^boletin/([^/]+)/(\d+)$#', $path, $matches)) {
            $slug = $matches[1];
            $id = $matches[2];
            
            // Lookup the corresponding entry to ensure correct slug
            $boletin = Boletin::find($id);
            if ($boletin) {
                // Use the original slug if available in Statamic
                $newSlug = $this->getStatamicSlug('boletines', $id) ?? $slug;
                return redirect("/boletines/{$newSlug}", 301);
            }
            
            // Fallback to the URL slug if entry not found
            return redirect("/boletines/{$slug}", 301);
        }
        
        // Numeralia to Impacto redirect
        if ($path === 'numeralia') {
            return redirect('/impacto', 301);
        }
        
        // English versions
        
        // Strategy to Program redirect
        if (preg_match('#^en/strategy/([^/]+)/(\d+)$#', $path, $matches)) {
            $slug = $matches[1];
            $id = $matches[2];
            
            // Use the original slug if available in Statamic
            $newSlug = $this->getStatamicSlug('programa', $id, 'en') ?? $slug;
            return redirect("/en/program/{$newSlug}", 301);
        }
        
        // Strategies to Program redirect (list page)
        if ($path === 'en/strategies') {
            return redirect('/en/program', 301);
        }
        
        // Publication to Publications redirect
        if (preg_match('#^en/publication/([^/]+)/(\d+)$#', $path, $matches)) {
            $slug = $matches[1];
            $id = $matches[2];
            
            // Use the original slug if available in Statamic
            $newSlug = $this->getStatamicSlug('publicaciones', $id, 'en') ?? $slug;
            return redirect("/en/publications/{$newSlug}", 301);
        }
        
        // Newsletter to Newsletters redirect
        if (preg_match('#^en/newsletter/([^/]+)/(\d+)$#', $path, $matches)) {
            $slug = $matches[1];
            $id = $matches[2];
            
            // Use the original slug if available in Statamic
            $newSlug = $this->getStatamicSlug('boletines', $id, 'en') ?? $slug;
            return redirect("/en/newsletters/{$newSlug}", 301);
        }
        
        // Numeralia to Impact redirect
        if ($path === 'en/numeralia') {
            return redirect('/en/impact', 301);
        }
        
        return $next($request);
    }
    
    /**
     * Get the Statamic slug for a migrated entry
     */
    private function getStatamicSlug($collection, $originalId, $locale = 'es')
    {
        // Look up the Statamic entry by original ID
        $entry = \Statamic\Facades\Entry::query()
            ->where('collection', $collection)
            ->where('locale', $locale)
            ->where('data->original_id', $originalId)
            ->first();
        
        return $entry ? $entry->slug() : null;
    }
}
```

### Register the Middleware

Add the middleware to your HTTP kernel:

```php
// app/Http/Kernel.php
protected $middleware = [
    // ...
    \App\Http\Middleware\RedirectOldUrls::class,
];
```

## Collection Route Configuration

Configure the routes in Statamic collection YAML files:

```yaml
# content/collections/programa.yaml
route: '{locale}/{mount?}/{slug}'
mount: 'programa'
```

```yaml
# content/collections/publicaciones.yaml
route: '{locale}/{mount?}/{slug}'
mount: 'publicaciones'
```

```yaml
# content/collections/boletines.yaml
route: '{locale}/{mount?}/{slug}'
mount: 'boletines'
```

```yaml
# content/collections/noticias.yaml
route: '{locale}/{mount?}/{slug}'
mount: 'noticias'
```

```yaml
# content/collections/materiales.yaml
route: '{locale}/{mount?}/{slug}'
mount: 'materiales'
```

```yaml
# content/collections/impacto.yaml
route: '{locale}/{mount?}/{slug}'
mount: 'impacto'
```

## Multi-language URLs

For multi-language support, Statamic will handle the appropriate URL structure based on the site configuration:

```php
// config/statamic/sites.php
<?php

return [
    'sites' => [
        'es' => [
            'name' => 'Español',
            'locale' => 'es_MX',
            'url' => '/',
        ],
        'en' => [
            'name' => 'English',
            'locale' => 'en_US',
            'url' => '/en/',
        ],
    ],
];
```

This will result in URLs like:
- Spanish: `/programa/slug-name`
- English: `/en/program/slug-name`

## Managing Symlinks

If the current implementation uses symlinks for asset URLs, you'll need to ensure those are properly handled:

```php
/**
 * Symlink asset directories for Statamic
 */
public function linkStatamicAssets()
{
    $publicPath = public_path();
    $storagePath = storage_path('app/public');
    
    // Define symlinks to create
    $links = [
        'assets/images' => $storagePath . '/images',
        'assets/documents' => $storagePath . '/documents',
        'assets/videos' => $storagePath . '/videos',
    ];
    
    foreach ($links as $link => $target) {
        if (file_exists($publicPath . '/' . $link)) {
            continue;
        }
        
        symlink($target, $publicPath . '/' . $link);
    }
}
```

## Tracking 404 Errors

Implement 404 error tracking to catch any missed redirects:

```php
// app/Exceptions/Handler.php
public function render($request, Throwable $exception)
{
    if ($exception instanceof NotFoundHttpException) {
        // Log 404 errors
        \Log::channel('404s')->info('404 Error', [
            'url' => $request->fullUrl(),
            'referrer' => $request->server('HTTP_REFERER'),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'ip' => $request->ip(),
        ]);
    }
    
    return parent::render($request, $exception);
}
```

Configure a dedicated log channel:

```php
// config/logging.php
'404s' => [
    'driver' => 'daily',
    'path' => storage_path('logs/404s.log'),
    'level' => 'info',
    'days' => 30,
],
```

## URL Testing Plan

Before final deployment, create a testing plan to ensure all redirects work correctly:

1. Create a comprehensive list of current URLs
2. Create a test script that checks each URL and verifies the correct redirect
3. Check for proper status codes (301 for redirects)
4. Verify all URLs are accessible in both languages
5. Test edge cases (e.g., trailing slashes, query parameters)

Example test script:

```php
<?php
// tests/Feature/UrlRedirectTest.php

namespace Tests\Feature;

use Tests\TestCase;

class UrlRedirectTest extends TestCase
{
    /**
     * Test estrategia redirects to programa
     */
    public function testEstrategiaRedirect()
    {
        $response = $this->get('/estrategia/example-slug/123');
        $response->assertStatus(301);
        $response->assertRedirect('/programa/example-slug');
    }
    
    /**
     * Test estrategias list redirects to programa
     */
    public function testEstrategiasListRedirect()
    {
        $response = $this->get('/estrategias');
        $response->assertStatus(301);
        $response->assertRedirect('/programa');
    }
    
    // Add more tests for each redirect case
}
``` 