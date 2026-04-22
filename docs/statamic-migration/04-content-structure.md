# Content Structure Changes

This document outlines the structural changes to be implemented during the migration to Statamic CMS.

## Key Content Structure Changes

1. **Section Renaming**
   - "Estrategias" renamed to "Programa"
   - "Numeralia" renamed to "Impacto"

2. **New Sections**
   - "Noticias" (News) section
   - "Materiales Descargables" (Downloadable Materials) section

3. **Reorganized Program Structure**
   - Main "Programa" collection with hierarchical structure:
     - Program Categories (formerly Estrategias)
       - Program Activities (activities within each estrategia)
   - Program Types taxonomy with categories:
     - Programa Local (Local Program)
       - Huerto (Garden)
       - Cocina (Kitchen)
       - Infancias (Children)
       - Talleres comunitarios (Community Workshops)
     - Programa Externo (External Program)
       - Mapeos (Mappings)
       - Intercambios territoriales (Territorial Exchanges)
     - Exposiciones (Exhibitions)
     - Proyectos Artísticos (Artistic Projects)

4. **Additional Taxonomies**
   - Year-based organization for all content types
   - Activity types
   - Locations
   - Partners

## Collection Setup

Create the following collections using the CLI or Control Panel:

### Program Collection (formerly Estrategias)

```bash
php please make:collection programa
```

Configure in `content/collections/programa.yaml`:
```yaml
title: Programa
route: '/programa/{parent_uri}/{slug}'
structure:
  max_depth: 3
  tree:
    - entry
sites:
  - es
  - en
```

### Publications Collection

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

### News Collection

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

### Downloadable Materials Collection

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

### Impact Collection (formerly Numeralia)

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

### Additional Collections
```bash
php please make:collection boletines  # Newsletters
php please make:collection miembros   # Team Members
php please make:collection espacios   # Spaces
```

## Taxonomy Setup

Create taxonomies for organizing content:

### Years Taxonomy

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

### Program Types Taxonomy

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

Initialize with structured types:
```yaml
# content/taxonomies/program_types/index.yaml
terms:
  - programa_local:
      title: Programa Local
      children:
        - huerto:
            title: Huerto
        - cocina:
            title: Cocina
        - infancias:
            title: Infancias
        - talleres_comunitarios:
            title: Talleres Comunitarios
  - programa_externo:
      title: Programa Externo
      children:
        - mapeos:
            title: Mapeos
        - intercambios_territoriales:
            title: Intercambios Territoriales
  - exposiciones:
      title: Exposiciones
  - proyectos_artisticos:
      title: Proyectos Artísticos
```

### Tags Taxonomy

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

### Activity Types Taxonomy

```bash
php please make:taxonomy activity_types
```

Configure in `content/taxonomies/activity_types.yaml`:
```yaml
title: Tipos de Actividad
sites:
  - es
  - en
```

### Locations Taxonomy

```bash
php please make:taxonomy locations
```

Configure in `content/taxonomies/locations.yaml`:
```yaml
title: Ubicaciones
sites:
  - es
  - en
```

### Partners Taxonomy

```bash
php please make:taxonomy partners
```

Configure in `content/taxonomies/partners.yaml`:
```yaml
title: Aliados
sites:
  - es
  - en
```

## Global Content Setup

Create global sets for site-wide content:

### Site Settings

```bash
php please make:global site_settings
```

With fields for site name, contact information, social media, etc.

### Popup Announcements

```bash
php please make:global popup
```

With fields for popup-related settings.

### Privacy Policy

```bash
php please make:global privacy_policy
```

With versioning and last updated date.

### Navigation Menus

```bash
php please make:global navigation
```

For main navigation, footer, and other menus.

## Asset Containers

Create asset containers for different media types:

```bash
php please make:asset-container images
php please make:asset-container documents
php please make:asset-container videos
``` 