# Statamic CMS Migration Specification

This document outlines the steps required to migrate the Casa Gallina application from its current custom CMS implementation to Statamic CMS within the same codebase.

## Table of Contents

1. [Overview](#overview)
2. [Requirements](#requirements)
3. [Migration Strategy](#migration-strategy)
4. [Pre-Migration Tasks](#pre-migration-tasks)
5. [Installation](#installation)
6. [Content Structure Changes](#content-structure-changes)
7. [Content Migration](#content-migration)
8. [Template Migration](#template-migration)
9. [Feature Enhancements](#feature-enhancements)
10. [Custom Functionality Migration](#custom-functionality-migration)
11. [URL Structure Migration](#url-structure-migration)
12. [Testing](#testing)
13. [Final Steps and Launch](#final-steps-and-launch)
14. [Migration Timeline](#migration-timeline)

## Overview

The current application is a Laravel-based custom CMS for Casa Gallina, handling content management for various sections including Estrategias, Publicaciones, Boletines, and more. The migration aims to leverage Statamic CMS while preserving existing functionality and data, along with implementing 22 specific enhancements to improve user experience, SEO, and administrative capabilities.

### Current Website Structure

- **Home (Inicio)**: Features highlighted strategies, publications, and collaboration spaces
- **The House (La Casa)**: Information about Casa Gallina and team members
- **Strategies (Estrategias)**: Projects and initiatives with multimedia content
- **Publications (Publicaciones)**: Digital and printed materials
- **Newsletters (Boletines)**: Historical newsletter archives
- **Donations (Donaciones)**: Donation methods and campaigns

### Technical Limitations to Address

1. URLs include numeric IDs (e.g., `/publicacion/slug-name/35`)
2. Inconsistent URL naming between list and detail views
3. Limited metadata management for SEO
4. No structured data implementation (schema.org)
5. Limited content organization capabilities
6. No popup/announcement functionality
7. Limited donation campaign flexibility

## Requirements

### Server Requirements

- PHP 8.1 or higher (current app is already compatible)
- BCMath PHP Extension
- Ctype PHP Extension
- Exif PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD Library or ImageMagick
- Composer

### Statamic Requirements

- Statamic 5.x (compatible with Laravel 10+)
- Statamic Pro license for production use (if admin features are needed)

## Migration Strategy

We'll adopt an incremental migration approach:

1. Install Statamic alongside the existing application
2. Set up Statamic collections and blueprints mirroring the current data models
3. Migrate content from the existing database to Statamic
4. Adapt templates to use Statamic tags and structures
5. Implement custom functionality with Statamic addons or custom code
6. Test extensively
7. Switch to Statamic-powered routes and controllers

## Pre-Migration Tasks

1. **Database Backup**
   - Create a full backup of the current database
   - Document current database schema

2. **Code Backup**
   - Create a Git branch for the migration
   - Ensure all changes are committed

3. **Content Inventory**
   - Document all content types in the system:
     - Estrategias (to be renamed to "Programa")
     - Publicaciones
     - Boletines
     - Espacios
     - Miembros
     - Multimedia assets

4. **Functionality Assessment**
   - Document all custom functionality:
     - Multi-language support (English/Spanish)
     - Admin panel capabilities
     - File uploads and management
     - Public facing site structure
     - Donation system

## Installation

1. **Prepare Composer Configuration**

   Update `composer.json` to add Statamic installation scripts:

   ```json
   "scripts": {
       "pre-update-cmd": [
           "Statamic\\Console\\Composer\\Scripts::preUpdateCmd"
       ],
       "post-autoload-dump": [
           "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
           "@php artisan package:discover --ansi",
           "@php artisan statamic:install --ansi"
       ]
   }
   ```

2. **Install Statamic**

   ```bash
   php artisan config:clear
   composer require statamic/cms --with-dependencies
   ```

3. **Publish Configuration Files**

   ```bash
   php artisan vendor:publish --tag=statamic-config
   ```

4. **Configure Statamic**

   Update the Statamic config files in `config/statamic/`:
   - Set appropriate site name
   - Configure multi-site setup for English/Spanish
   - Set up control panel access

5. **Generate Auth Migration (if necessary)**

   ```bash
   php please auth:migration
   ```

## Content Structure Changes

The migration will include several key structural changes:

1. **Section Renaming**
   - "Estrategias" renamed to "Programa"
   - "Numeralia" renamed to "Impacto"

2. **New Sections**
   - "Noticias" (News) section
   - "Materiales Descargables" (Downloadable Materials) section

3. **Reorganized Program Structure**
   - Main "Programa" collection with subcategories:
     - Exposiciones (Exhibitions)
     - Proyectos Artísticos (Artistic Projects)
     - Programa Local (Local Program)
       - Huerto (Garden)
       - Cocina (Kitchen)
       - Infancias (Children)
     - Programa Externo (External Program)
       - Mapeos (Mappings)

4. **Year-based Taxonomies**
   - Adding year-based organization for all content types

## Content Migration

### 1. Create Statamic Collections

Create collections for each content type in the current system:

1. **Program Collection (formerly Estrategias)**

   ```bash
   php please make:collection programa
   ```

   Configure in `content/collections/programa.yaml`:
   ```yaml
   title: Programa
   route: '/programa/{slug}'
   structure:
     max_depth: 3
     tree:
       - entry
   sites:
     - es
     - en
   ```

2. **Publications Collection**

   ```bash
   php please make:collection publicaciones
   ```

   Configure in `content/collections/publicaciones.yaml`:
   ```yaml
   title: Publicaciones
   route: '/publicaciones/{slug}'
   structure:
     max_depth: 1
     tree:
       - entry
   sites:
     - es
     - en
   ```

3. **News Collection**

   ```bash
   php please make:collection noticias
   ```

   Configure in `content/collections/noticias.yaml`:
   ```yaml
   title: Noticias
   route: '/noticias/{slug}'
   sites:
     - es
     - en
   ```

4. **Downloadable Materials Collection**

   ```bash
   php please make:collection materiales
   ```

   Configure in `content/collections/materiales.yaml`:
   ```yaml
   title: Materiales Descargables
   route: '/materiales/{slug}'
   sites:
     - es
     - en
   ```

5. **Impact Page (formerly Numeralia)**

   ```bash
   php please make:collection impacto
   ```

   Configure in `content/collections/impacto.yaml`:
   ```yaml
   title: Impacto
   route: '/impacto/{slug}'
   sites:
     - es
     - en
   ```

6. **Additional Collections**
   - Boletines
   - Miembros
   - Espacios

### 2. Create Taxonomies

Create taxonomies for organizing content:

1. **Years Taxonomy**

   ```bash
   php please make:taxonomy years
   ```

   Configure in `content/taxonomies/years.yaml`:
   ```yaml
   title: Years
   sites:
     - es
     - en
   ```

2. **Program Types Taxonomy**

   ```bash
   php please make:taxonomy program_types
   ```

   Configure in `content/taxonomies/program_types.yaml`:
   ```yaml
   title: Tipos de Programa
   sites:
     - es
     - en
   ```

3. **Tags Taxonomy**

   ```bash
   php please make:taxonomy tags
   ```

   Configure in `content/taxonomies/tags.yaml`:
   ```yaml
   title: Tags
   sites:
     - es
     - en
   ```

### 3. Create Blueprints

Create blueprints for each content type with enhanced fields:

1. **Program Blueprint (formerly Estrategias)**

   Include fields for:
   - status
   - title/title_en
   - subtitle/subtitle_en
   - content/content_en
   - program_type (taxonomy)
   - collaborators/collaborators_en
   - date/date_en
   - location/location_en
   - optional fields
   - multimedia relationships
   - SEO metadata section
   - tags for related content

2. **Publications Blueprint**

   Enhanced with:
   - status
   - title/title_en
   - subtitle/subtitle_en
   - publication_date/publication_date_en
   - type
   - enhanced author fields
   - editorial information
   - synopsis/synopsis_en
   - optional fields
   - multimedia relationships
   - SEO metadata section
   - tags for related content

3. **News Blueprint**

   Including:
   - title/title_en
   - content/content_en
   - date
   - featured image
   - categories
   - author
   - SEO metadata section
   - tags for related content

4. **Downloadable Materials Blueprint**

   With fields for:
   - title/title_en
   - description/description_en
   - file type
   - download file
   - lead capture requirements
   - SEO metadata section

5. **Impact Blueprint**

   With fields for:
   - title/title_en
   - content/content_en
   - statistics
   - visualization options
   - SEO metadata section

### 4. Create Global Sets

Create global sets for site-wide content:

1. **Site Settings**

   ```bash
   php please make:global site_settings
   ```

   With fields for site name, contact information, social media, etc.

2. **Popup Announcements**

   ```bash
   php please make:global popup
   ```

   With fields for:
   - enabled toggle
   - title
   - content
   - link URL
   - image
   - start/end dates

3. **Privacy Policy**

   ```bash
   php please make:global privacy_policy
   ```

   With versioning and last updated date

4. **Navigation Menus**

   For main navigation, footer, and other menus

### 5. Create Asset Containers

Create asset containers for different media types:

```bash
php please make:asset-container images
php please make:asset-container documents
php please make:asset-container videos
```

### 6. Data Migration

Create a data migration script to transfer content from the database to Statamic:

```php
// app/Console/Commands/MigrateToStatamic.php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Estrategia;
use App\Models\Publicacion;
use App\Models\Boletin;
use App\Models\Espacio;
use App\Models\Miembro;
use App\Models\Multimedia;
use Statamic\Facades\Entry;
use Statamic\Facades\Asset;
use Statamic\Facades\Term;
use Illuminate\Support\Str;

class MigrateToStatamic extends Command
{
    protected $signature = 'migrate:statamic {type?}';
    protected $description = 'Migrate content from database to Statamic';

    public function handle()
    {
        $type = $this->argument('type');
        
        if (!$type || $type === 'programa') {
            $this->migratePrograma();
        }
        
        if (!$type || $type === 'publicaciones') {
            $this->migratePublicaciones();
        }
        
        if (!$type || $type === 'boletines') {
            $this->migrateBoletines();
        }
        
        // Add methods for other content types
        
        $this->info('Migration complete!');
    }
    
    protected function migratePrograma()
    {
        $this->info('Migrating Estrategias to Programa...');
        
        $estrategias = Estrategia::with('destacada_multimedia', 'multimedia')->get();
        
        foreach ($estrategias as $estrategia) {
            // Determine program type
            $programType = $this->determineProgramType($estrategia);
            
            // Create term if it doesn't exist
            $term = Term::findBySlug($programType, 'program_types') ?? 
                   Term::make()->taxonomy('program_types')->slug($programType)->save();
            
            // Create entry for Spanish
            $entry = Entry::make()
                ->collection('programa')
                ->locale('es')
                ->slug(Str::slug($estrategia->titulo))
                ->data([
                    'title' => $estrategia->titulo,
                    'status' => $estrategia->status,
                    'subtitle' => $estrategia->subtitulo,
                    'content' => $estrategia->contenido,
                    'program_type' => [$term->id()],
                    'collaborators' => $estrategia->colaboradores,
                    'date' => $estrategia->fecha,
                    'location' => $estrategia->lugar,
                    // Add remaining fields
                    'original_id' => $estrategia->id,
                    // SEO metadata
                    'meta_title' => $estrategia->titulo,
                    'meta_description' => Str::limit(strip_tags($estrategia->contenido), 160),
                ]);
            
            $entry->save();
            
            // Create entry for English
            $entryEn = Entry::make()
                ->collection('programa')
                ->locale('en')
                ->slug(Str::slug($estrategia->titulo_en))
                ->data([
                    'title' => $estrategia->titulo_en,
                    'status' => $estrategia->status,
                    'subtitle' => $estrategia->subtitulo_en,
                    'content' => $estrategia->contenido_en,
                    'program_type' => [$term->id()],
                    'collaborators' => $estrategia->colaboradores_en,
                    'date' => $estrategia->fecha_en,
                    'location' => $estrategia->lugar_en,
                    // Add remaining fields
                    'original_id' => $estrategia->id,
                    // SEO metadata
                    'meta_title' => $estrategia->titulo_en,
                    'meta_description' => Str::limit(strip_tags($estrategia->contenido_en), 160),
                ]);
            
            $entryEn->save();
            
            // Associate the two entries as translations
            $entry->addLocalization($entryEn);
            $entry->save();
            
            $this->info("Migrated: {$estrategia->titulo}");
        }
    }
    
    // Helper method to determine program type
    protected function determineProgramType($estrategia)
    {
        // Logic to determine program type based on estrategia content
        // This will need to be customized based on actual data structure
        if (Str::contains($estrategia->contenido, ['exposición', 'exposiciones', 'exhibit'])) {
            return 'exposiciones';
        } elseif (Str::contains($estrategia->contenido, ['huerto', 'garden', 'planta'])) {
            return 'huerto';
        }
        // Add more conditions as needed
        return 'general';
    }
    
    protected function migratePublicaciones()
    {
        $this->info('Migrating Publicaciones...');
        
        $publicaciones = Publicacion::with('publicacion_multimedia', 'publicacion_thumbnail')->get();
        
        foreach ($publicaciones as $publicacion) {
            // Create entry for Spanish
            $entry = Entry::make()
                ->collection('publicaciones')
                ->locale('es')
                ->slug(Str::slug($publicacion->titulo))
                ->data([
                    'title' => $publicacion->titulo,
                    'status' => $publicacion->status,
                    'subtitle' => $publicacion->subtitulo,
                    'publication_date' => $publicacion->fecha_publicacion,
                    'editorial_coordination' => $publicacion->coordinacion_editorial,
                    'design' => $publicacion->diseno,
                    'page_count' => $publicacion->numero_paginas,
                    'type' => $publicacion->tipo,
                    'texts' => $publicacion->textos,
                    'synopsis' => $publicacion->sinopsis,
                    // Add remaining fields including optional fields
                    'original_id' => $publicacion->id,
                    // SEO metadata
                    'meta_title' => $publicacion->titulo,
                    'meta_description' => Str::limit(strip_tags($publicacion->sinopsis), 160),
                ]);
            
            $entry->save();
            
            // Create entry for English
            $entryEn = Entry::make()
                ->collection('publicaciones')
                ->locale('en')
                ->slug(Str::slug($publicacion->titulo_en))
                ->data([
                    'title' => $publicacion->titulo_en,
                    'status' => $publicacion->status,
                    'subtitle' => $publicacion->subtitulo_en,
                    'publication_date' => $publicacion->fecha_publicacion_en,
                    'editorial_coordination' => $publicacion->coordinacion_editorial_en,
                    'design' => $publicacion->diseno_en,
                    'texts' => $publicacion->textos_en,
                    'synopsis' => $publicacion->sinopsis_en,
                    // Add remaining fields including optional fields
                    'original_id' => $publicacion->id,
                    // SEO metadata
                    'meta_title' => $publicacion->titulo_en,
                    'meta_description' => Str::limit(strip_tags($publicacion->sinopsis_en), 160),
                ]);
            
            $entryEn->save();
            
            // Associate the two entries as translations
            $entry->addLocalization($entryEn);
            $entry->save();
            
            $this->info("Migrated: {$publicacion->titulo}");
        }
    }
    
    // Add methods for other content types
}
```

## Template Migration

### 1. Create Layouts

Create Statamic layouts based on current templates:

```
resources/views/statamic/layouts/main.antlers.html
```

### 2. Create Templates

Create templates for each content type:
- `resources/views/statamic/programa/show.antlers.html`
- `resources/views/statamic/programa/index.antlers.html`
- `resources/views/statamic/publicaciones/show.antlers.html`
- `resources/views/statamic/publicaciones/index.antlers.html`
- `resources/views/statamic/noticias/show.antlers.html`
- `resources/views/statamic/noticias/index.antlers.html`
- `resources/views/statamic/materiales/show.antlers.html`
- `resources/views/statamic/materiales/index.antlers.html`
- `resources/views/statamic/impacto/show.antlers.html`
- etc.

### 3. Create Components

Create reusable components for consistency:

- `resources/views/statamic/components/related-content.antlers.html`
- `resources/views/statamic/components/donation-form.antlers.html`
- `resources/views/statamic/components/newsletter-signup.antlers.html`
- `resources/views/statamic/components/popup-announcement.antlers.html`
- `resources/views/statamic/components/seo-metadata.antlers.html`
- `resources/views/statamic/components/lead-capture-form.antlers.html`
- `resources/views/statamic/components/map.antlers.html`

### 4. Adapt Content Rendering

Convert Blade syntax to Antlers templates, adapting the current functionality:

```html
{{# Original Blade #}}
@foreach ($estrategias as $estrategia)
<div class="estrategia-item col-md-6 col-lg-4">
    <div class="estrategia-image"
        style="background-image: url('/storage/cache/{{ $estrategia->destacada_multimedia->filename  }}')"
        onclick="window.location = '/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}'">
    </div>
    <div class="estrategia-title">
        <a href="/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}">{{ $estrategia->titulo }}</a>
    </div>
</div>
@endforeach

{{# Converted to Antlers #}}
{{ collection:programa locale="{locale}" program_type="exposiciones" }}
<div class="programa-item col-md-6 col-lg-4">
    <div class="programa-image"
        style="background-image: url('{{ featured_image }}')"
        onclick="window.location = '{{ url }}'">
    </div>
    <div class="programa-title">
        <a href="{{ url }}">{{ title }}</a>
    </div>
</div>
{{ /collection:programa }}
```

## Feature Enhancements

This section outlines the 22 specific enhancements to be implemented as part of the migration.

### 1. Rename Sections and Change URLs

- Rename "Numeralia" to "Impacto"
- Rename "Estrategias" to "Programa" 
- Update all related templates, routes, and navigation items
- Configure 301 redirects from old to new URLs

### 2. Consistent URL Structure for Publications

- Standardize URLs to use consistent pluralization and remove IDs
- Create 301 redirects from old URLs (e.g., `/publicacion/slug-name/35` → `/publicaciones/slug-name`)

### 3. Popup Announcement Feature

Implement popup announcement functionality:

```html
{{# In the main layout #}}
{{ globals:popup }}
  {{ if enabled && (current_date >= start_date && current_date <= end_date) }}
    <div class="popup-announcement" id="popup-announcement">
      <div class="popup-content">
        <h3>{{ title }}</h3>
        {{ content }}
        {{ if link }}<a href="{{ link }}" class="popup-btn">{{ trans:labels.learn_more }}</a>{{ /if }}
        <button class="close-popup" onclick="closePopup()">&times;</button>
      </div>
    </div>
    <script>
      function closePopup() {
        document.getElementById('popup-announcement').style.display = 'none';
        localStorage.setItem('popup-closed-{{ date format="Ymd" }}', 'true');
      }
      
      // Check if popup was already closed today
      if (localStorage.getItem('popup-closed-{{ date format="Ymd" }}') !== 'true') {
        setTimeout(function() {
          document.getElementById('popup-announcement').style.display = 'flex';
        }, 2000);
      }
    </script>
  {{ /if }}
{{ /globals:popup }}
```

### 4. Program Section Reorganization

- Implement hierarchical structure for Program section
- Create appropriate taxonomies and categories 
- Design templates to properly display the hierarchical structure

### 5. Enhanced SEO Metadata Management

- Add SEO partial to all templates:

```html
{{ partial:components/seo-metadata
   title="{meta_title ?? title} | {{ site:name }}"
   description="{meta_description}"
   image="{og_image ?? featured_image ?? site:default_image}"
}}
```

- Implement schema.org structured data for all content types

### 6. Homepage Reorganization

- Create customizable homepage sections using replicator fieldtype
- Allow control panel users to reorder and customize homepage content

### 7. Publications Encoding Review

- Add UTF-8 encoding checks to migration scripts
- Implement character encoding fixes during content migration

### 8. Publication Lead Form Improvements

- Redesign lead capture flow to require form submission before download
- Implement as reusable component:

```html
{{ partial:components/lead-capture-form
   asset_to_download="{file}"
   title="{title}"
   collection="publications"
   id="{id}"
}}
```

### 9. Schema.org Implementation

- Add schema.org markup for all content types:
  - Organization schema for Casa Gallina
  - Article schema for publications and news
  - Event schema for exhibitions and activities
  - CreativeWork schema for artistic projects

### 10. Enhanced Donation Pages

- Create separate templates for different donation types
- Implement reusable donation component:

```html
{{ partial:components/donation-form
   type="{type}"
   campaign="{campaign}"
}}
```

### 11. US Fiscal Donation Page

- Create new template for US-specific donations
- Implement with appropriate legal language and tax information

### 12. Newsletter Subscription Enhancement

- Create dedicated newsletter signup page and popup
- Implement double opt-in process
- Add fields for name, email, and interests

### 13. News Section Creation

- Implement "Noticias" section with appropriate templates
- Create listing and detail view templates
- Add to main navigation

### 14. Robots.txt Configuration

- Configure robots.txt with appropriate rules:

```
User-agent: *
Disallow: /cp/
Disallow: /admin/

User-agent: GPTBot
Disallow: /private-content/

User-agent: ChatGPT-User
Disallow: /private-content/
```

### 15. Sitemap.xml Implementation

- Enable Statamic's sitemap generation
- Configure sitemap settings in `config/statamic/seo.php`

### 16. Privacy Policy Update

- Create global for privacy policy content
- Add versioning and last updated date display

### 17. Related Content Sidebar

- Create related content component based on tags:

```html
{{ partial:components/related-content
   current_id="{id}"
   tags="{tags}"
   limit="5"
}}
```

### 18. Internal Search Functionality

- Implement search page and results template
- Configure Statamic's search functionality
- Add search form to navigation

### 19. Allies Section Update

- Redesign Allies section with enhanced profiles
- Implement contact form for partnership inquiries

### 20. Expanded Publication Author Fields

- Enhance publication blueprint with comprehensive author fields
- Update templates to display full author information

### 21. Downloadable Materials Repository

- Create dedicated section for downloadable materials
- Implement similar interface to publications section
- Add lead capture capability

### 22. Enhanced Maps for Allies and Initiatives

- Create interactive map component with location information
- Allow filtering by location type
- Add detailed popups for each location

## Custom Functionality Migration

### 1. Multi-language Support

Use Statamic's built-in multi-site capabilities:

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

### 2. Admin Panel

Leverage Statamic's Control Panel with appropriate roles and permissions:

```php
// config/statamic/cp.php
<?php

return [
    'enabled' => true,
    'route' => 'admin',
    // Other CP configurations
];
```

### 3. Custom Routes

Adapt the current routing structure to work with Statamic:

```php
// routes/web.php
Route::statamic('/programa/{slug}', 'programa.show', [
    'title' => 'Programa',
]);

Route::statamic('/publicaciones/{slug}', 'publicaciones.show', [
    'title' => 'Publicación',
]);

// Add other custom routes
```

### 4. Custom Addons (if needed)

Develop Statamic addons for functionality not covered by core features:

```bash
php please make:addon DonationsManager
```

## URL Structure Migration

The URL structure will change significantly. A comprehensive 301 redirect map will be implemented to maintain SEO value:

```php
// app/Http/Middleware/RedirectOldUrls.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Estrategia;
use App\Models\Publicacion;

class RedirectOldUrls
{
    public function handle(Request $request, Closure $next)
    {
        // Extract the current path
        $path = $request->path();

        // Estrategia to Programa redirect
        if (preg_match('#^estrategia/([^/]+)/(\d+)$#', $path, $matches)) {
            return redirect("/programa/{$matches[1]}", 301);
        }

        // Estrategias to Programa redirect
        if ($path === 'estrategias') {
            return redirect('/programa', 301);
        }

        // Publicacion to Publicaciones redirect
        if (preg_match('#^publicacion/([^/]+)/(\d+)$#', $path, $matches)) {
            return redirect("/publicaciones/{$matches[1]}", 301);
        }

        // Numeralia to Impacto redirect
        if ($path === 'numeralia') {
            return redirect('/impacto', 301);
        }

        // Handle English routes similarly
        if (preg_match('#^en/strategy/([^/]+)/(\d+)$#', $path, $matches)) {
            return redirect("/en/program/{$matches[1]}", 301);
        }

        return $next($request);
    }
}
```

Register the middleware:

```php
// app/Http/Kernel.php
protected $middleware = [
    // ...
    \App\Http\Middleware\RedirectOldUrls::class,
];
```

## Testing

1. **Functional Testing**
   - Verify all pages render correctly
   - Test all interactive elements
   - Confirm multi-language functionality

2. **Content Management Testing**
   - Test creating and editing all content types
   - Verify media uploads and management
   - Test user roles and permissions

3. **Performance Testing**
   - Compare page load times
   - Check memory usage
   - Optimize as needed

4. **SEO and Accessibility Testing**
   - Test structured data with Google's testing tool
   - Verify metadata on all pages
   - Run accessibility checks

5. **Form and Lead Capture Testing**
   - Test all forms including:
     - Lead capture
     - Newsletter signup
     - Donation forms
     - Contact forms

## Final Steps and Launch

1. **URL Structure Preservation**
   - Ensure all current URLs continue to work
   - Set up redirects if needed

2. **Search Engine Optimization**
   - Verify meta tags
   - Test canonical URLs
   - Check structured data

3. **Launch Checklist**
   - Final database backup
   - Verify all functionality
   - Update DNS if needed
   - Monitor for any issues

4. **Post-Launch Tasks**
   - Train content editors
   - Document new workflows
   - Monitor performance

## Migration Timeline

1. **Phase 1: Planning and Setup** (2 weeks)
   - Statamic installation and configuration
   - Content structure design
   - Blueprint creation

2. **Phase 2: Data Migration** (3 weeks)
   - Content export and transformation
   - Media migration
   - URL structure implementation

3. **Phase 3: Frontend Development** (4 weeks)
   - Template creation
   - Component development
   - Responsive design implementation

4. **Phase 4: Feature Implementation** (6 weeks)
   - Implementation of 22 requested changes
   - Form functionality
   - Interactive elements

5. **Phase 5: Testing and Refinement** (3 weeks)
   - Cross-browser testing
   - Performance optimization
   - Content review

6. **Phase 6: Deployment and Launch** (2 weeks)
   - Server setup
   - Launch preparation
   - Go-live and monitoring

## Conclusion

This migration approach allows for a gradual transition from the custom CMS to Statamic while maintaining the existing codebase and ensuring content integrity. The flexibility of Statamic as a Laravel package makes it ideal for this type of in-place migration.

By following these steps, we can successfully transition to Statamic CMS while preserving all existing functionality, implementing the 22 requested enhancements, and improving the content management experience. 