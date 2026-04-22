# Content Blueprints

This document outlines the blueprints to be created for each collection, defining the fields and their configurations.

## Blueprint Creation Process

Blueprints can be created either through the Control Panel or by creating YAML files directly. Here's how to create a blueprint via CLI:

```bash
php please make:blueprint programa
```

## Collection Blueprints

### 1. Program Blueprints (formerly Estrategias)

The Programa collection requires two blueprints to handle its hierarchical structure:

#### Program Category Blueprint

```yaml
# resources/blueprints/collections/programa/category.yaml
title: Programa Category
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
          validate:
            - required
      -
        handle: description
        field:
          type: markdown
          display: Description
          localizable: true
      -
        handle: program_type
        field:
          type: terms
          taxonomies:
            - program_types
          display: Program Type
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
      -
        handle: featured_image
        field:
          type: assets
          container: images
          max_files: 1
          mode: grid
      -
        handle: original_id
        field:
          type: text
          display: Original ID
  seo:
    display: SEO
    fields:
      -
        handle: meta_title
        field:
          type: text
          display: Meta Title
          localizable: true
      -
        handle: meta_description
        field:
          type: textarea
          display: Meta Description
          localizable: true
      -
        handle: tags
        field:
          type: terms
          taxonomies:
            - tags
          display: Tags
```

#### Program Activity Blueprint

```yaml
# resources/blueprints/collections/programa/activity.yaml
title: Programa Activity
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
          validate:
            - required
      -
        handle: content
        field:
          type: markdown
          display: Content
          localizable: true
      -
        handle: date
        field:
          type: date
          display: Start Date
          time_enabled: true
      -
        handle: end_date
        field:
          type: date
          display: End Date
          time_enabled: true
      -
        handle: location
        field:
          type: text
          display: Location
          localizable: true
      -
        handle: format
        field:
          type: select
          options:
            online: Online
            presencial: Presencial
            mixto: Mixto
          display: Format
      -
        handle: partners
        field:
          type: terms
          taxonomies:
            - partners
          display: Partners/Aliados
      -
        handle: facilitators
        field:
          type: textarea
          display: Facilitators
          localizable: true
      -
        handle: participants
        field:
          type: textarea
          display: Participants
          localizable: true
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
      -
        handle: parent
        field:
          type: entries
          collections:
            - programa
          max_items: 1
          display: Parent Program
      -
        handle: activity_type
        field:
          type: terms
          taxonomies:
            - activity_types
          display: Activity Type
      -
        handle: multimedia
        field:
          type: assets
          container: images
          max_files: 10
          mode: grid
  seo:
    display: SEO
    fields:
      -
        handle: meta_title
        field:
          type: text
          display: Meta Title
          localizable: true
      -
        handle: meta_description
        field:
          type: textarea
          display: Meta Description
          localizable: true
      -
        handle: tags
        field:
          type: terms
          taxonomies:
            - tags
          display: Tags
```

### 2. Publications Blueprint

```yaml
# resources/blueprints/collections/publicaciones/publicacion.yaml
title: Publicación
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
          validate:
            - required
      -
        handle: subtitle
        field:
          type: text
          localizable: true
      -
        handle: publication_date
        field:
          type: date
          display: Publication Date
      -
        handle: type
        field:
          type: select
          options:
            digital: Digital
            print: Print
            both: Digital and Print
      -
        handle: editorial_coordination
        field:
          type: text
          localizable: true
      -
        handle: design
        field:
          type: text
          localizable: true
      -
        handle: page_count
        field:
          type: integer
      -
        handle: texts
        field:
          type: textarea
          localizable: true
      -
        handle: synopsis
        field:
          type: markdown
          localizable: true
  authors:
    display: Authors
    fields:
      -
        handle: authors
        field:
          type: grid
          display: Authors
          add_row: Add Author
          fields:
            -
              handle: name
              field:
                type: text
                display: Name
            -
              handle: role
              field:
                type: text
                display: Role
            -
              handle: bio
              field:
                type: textarea
                display: Biography
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
      -
        handle: featured_image
        field:
          type: assets
          container: images
          max_files: 1
      -
        handle: multimedia
        field:
          type: assets
          container: images
      -
        handle: download_file
        field:
          type: assets
          container: documents
      -
        handle: original_id
        field:
          type: text
          display: Original ID
  seo:
    display: SEO
    fields:
      -
        handle: meta_title
        field:
          type: text
          display: Meta Title
          localizable: true
      -
        handle: meta_description
        field:
          type: textarea
          display: Meta Description
          localizable: true
      -
        handle: tags
        field:
          type: terms
          taxonomies:
            - tags
          display: Tags
```

### 3. News Blueprint

```yaml
# resources/blueprints/collections/noticias/noticia.yaml
title: Noticia
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
      -
        handle: content
        field:
          type: markdown
          localizable: true
      -
        handle: date
        field:
          type: date
          time_enabled: true
          time_required: true
          earliest_date: '2000-01-01'
      -
        handle: author
        field:
          type: text
          localizable: true
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
      -
        handle: featured_image
        field:
          type: assets
          container: images
          max_files: 1
      -
        handle: categories
        field:
          type: terms
          taxonomies:
            - tags
  seo:
    display: SEO
    fields:
      -
        handle: meta_title
        field:
          type: text
          localizable: true
      -
        handle: meta_description
        field:
          type: textarea
          localizable: true
```

### 4. Downloadable Materials Blueprint

```yaml
# resources/blueprints/collections/materiales/material.yaml
title: Material Descargable
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
      -
        handle: description
        field:
          type: markdown
          localizable: true
      -
        handle: file_type
        field:
          type: select
          options:
            pdf: PDF
            doc: Word Document
            xls: Excel Spreadsheet
            ppt: PowerPoint
            other: Other
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
      -
        handle: download_file
        field:
          type: assets
          container: documents
          max_files: 1
      -
        handle: requires_lead_capture
        field:
          type: toggle
          display: Require Lead Capture
  seo:
    display: SEO
    fields:
      -
        handle: meta_title
        field:
          type: text
          localizable: true
      -
        handle: meta_description
        field:
          type: textarea
          localizable: true
```

### 5. Impact Blueprint

```yaml
# resources/blueprints/collections/impacto/impacto.yaml
title: Impacto
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
      -
        handle: content
        field:
          type: markdown
          localizable: true
      -
        handle: statistics
        field:
          type: grid
          display: Statistics
          add_row: Add Statistic
          fields:
            -
              handle: label
              field:
                type: text
                display: Label
                localizable: true
            -
              handle: value
              field:
                type: text
                display: Value
            -
              handle: icon
              field:
                type: assets
                container: images
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
      -
        handle: visualization_type
        field:
          type: select
          options:
            table: Table
            chart: Chart
            cards: Cards
  seo:
    display: SEO
    fields:
      -
        handle: meta_title
        field:
          type: text
          localizable: true
      -
        handle: meta_description
        field:
          type: textarea
          localizable: true
```

## Global Set Blueprints

### 1. Popup Announcements Blueprint

```yaml
# resources/blueprints/globals/popup.yaml
title: Popup Announcements
sections:
  main:
    display: Main
    fields:
      -
        handle: enabled
        field:
          type: toggle
          display: Enabled
      -
        handle: title
        field:
          type: text
          display: Title
          localizable: true
      -
        handle: content
        field:
          type: markdown
          display: Content
          localizable: true
      -
        handle: link
        field:
          type: text
          display: Link URL
      -
        handle: image
        field:
          type: assets
          container: images
          max_files: 1
      -
        handle: start_date
        field:
          type: date
          display: Start Date
          time_enabled: true
      -
        handle: end_date
        field:
          type: date
          display: End Date
          time_enabled: true
```

### 2. Site Settings Blueprint

```yaml
# resources/blueprints/globals/site_settings.yaml
title: Site Settings
sections:
  main:
    display: Main
    fields:
      -
        handle: site_name
        field:
          type: text
          localizable: true
      -
        handle: contact_email
        field:
          type: text
      -
        handle: contact_phone
        field:
          type: text
      -
        handle: address
        field:
          type: textarea
          localizable: true
  social:
    display: Social Media
    fields:
      -
        handle: social_links
        field:
          type: grid
          add_row: Add Social Link
          fields:
            -
              handle: platform
              field:
                type: select
                options:
                  facebook: Facebook
                  instagram: Instagram
                  twitter: Twitter
                  youtube: YouTube
            -
              handle: url
              field:
                type: text
  seo:
    display: SEO
    fields:
      -
        handle: default_meta_title
        field:
          type: text
          localizable: true
      -
        handle: default_meta_description
        field:
          type: textarea
          localizable: true
      -
        handle: default_image
        field:
          type: assets
          container: images
          max_files: 1
```

## Taxonomy Blueprints

### Program Types Blueprint

```yaml
# resources/blueprints/taxonomies/program_types/program_type.yaml
title: Program Type
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
      -
        handle: description
        field:
          type: textarea
          localizable: true
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
```

### Activity Types Blueprint

```yaml
# resources/blueprints/taxonomies/activity_types/activity_type.yaml
title: Activity Type
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
      -
        handle: description
        field:
          type: textarea
          localizable: true
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
```

### Partners Blueprint

```yaml
# resources/blueprints/taxonomies/partners/partner.yaml
title: Partner
sections:
  main:
    display: Main
    fields:
      -
        handle: title
        field:
          type: text
          required: true
          localizable: true
      -
        handle: website
        field:
          type: text
      -
        handle: description
        field:
          type: textarea
          localizable: true
  sidebar:
    display: Sidebar
    fields:
      -
        handle: slug
        field:
          type: slug
          localizable: true
      -
        handle: logo
        field:
          type: assets
          container: images
          max_files: 1
``` 