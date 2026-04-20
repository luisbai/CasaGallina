# Template Migration

This document outlines the process of migrating existing Blade templates to Statamic's Antlers template syntax.

## Template Structure in Statamic

Statamic uses a slightly different template structure than typical Laravel Blade templates:

- **Layouts**: Base templates that contain the overall HTML structure
- **Templates**: Page-specific templates that extend layouts
- **Partials**: Reusable components that can be included in templates
- **Forms**: Form templates with validation and submission handling

## Creating Layouts

Create a main layout that will serve as the base for most pages:

```html
<!-- resources/views/statamic/layouts/main.antlers.html -->
<!DOCTYPE html>
<html lang="{{ site:short_locale }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ meta_title ?? title ?? site:name }}</title>
    <meta name="description" content="{{ meta_description ?? site:description }}">
    
    <!-- SEO Metadata -->
    {{ partial:components/seo-metadata }}
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix src='css/app.css' }}">
    
    <!-- Scripts -->
    <script src="{{ mix src='js/app.js' }}" defer></script>
</head>
<body class="{{ page_class ?? template }}">
    <!-- Navigation -->
    {{ partial:components/navigation }}
    
    <!-- Popup Announcements -->
    {{ partial:components/popup-announcement }}
    
    <!-- Content -->
    <main>
        {{ template_content }}
    </main>
    
    <!-- Footer -->
    {{ partial:components/footer }}
    
    <!-- Scripts -->
    {{ yield:scripts }}
</body>
</html>
```

## Creating Collection Templates

Create templates for each collection:

### Program (formerly Estrategias) Templates

```html
<!-- resources/views/statamic/templates/programa/index.antlers.html -->
{{ partial:components/page-header title="Programa" }}

<div class="programa-filters container">
    {{ taxonomy:program_types }}
        <a href="{{ url }}" class="filter-link {{ if is_current }}active{{ /if }}">
            {{ title }}
        </a>
    {{ /taxonomy:program_types }}
    
    {{ taxonomy:years }}
        <a href="{{ url }}" class="filter-link {{ if is_current }}active{{ /if }}">
            {{ title }}
        </a>
    {{ /taxonomy:years }}
</div>

<div class="programa-grid container">
    <div class="row">
        {{ collection:programa limit="12" paginate="true" sort="date:desc" }}
            <div class="col-md-6 col-lg-4 programa-item">
                <div class="card">
                    {{ if featured_image }}
                        <div class="card-image" style="background-image: url({{ featured_image }})"></div>
                    {{ /if }}
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="{{ url }}">{{ title }}</a>
                        </h3>
                        {{ if subtitle }}<p class="card-subtitle">{{ subtitle }}</p>{{ /if }}
                        
                        {{ if date }}
                            <div class="card-meta">
                                <span class="date">{{ date format="F j, Y" }}</span>
                            </div>
                        {{ /if }}
                    </div>
                </div>
            </div>
            
            {{ if no_results }}
                <div class="col-12 no-results">
                    <p>No programs found.</p>
                </div>
            {{ /if }}
            
            {{ partial:components/pagination }}
        {{ /collection:programa }}
    </div>
</div>
```

```html
<!-- resources/views/statamic/templates/programa/show.antlers.html -->
<article class="programa-detail">
    {{ partial:components/breadcrumbs }}
    
    <div class="container">
        <header class="programa-header">
            <h1>{{ title }}</h1>
            {{ if subtitle }}<h2 class="subtitle">{{ subtitle }}</h2>{{ /if }}
            
            <div class="meta">
                {{ if date }}<span class="date">{{ date format="F j, Y" }}</span>{{ /if }}
                {{ if location }}<span class="location">{{ location }}</span>{{ /if }}
            </div>
        </header>
        
        <div class="programa-content">
            {{ content }}
        </div>
        
        {{ if collaborators }}
            <div class="collaborators">
                <h3>{{ trans:labels.collaborators }}</h3>
                <div class="collaborator-content">{{ collaborators }}</div>
            </div>
        {{ /if }}
        
        {{ if multimedia }}
            <div class="multimedia-gallery">
                <h3>{{ trans:labels.gallery }}</h3>
                <div class="row gallery-grid">
                    {{ multimedia }}
                        <div class="col-md-4 gallery-item">
                            <a href="{{ url }}" data-fancybox="gallery">
                                <img src="{{ url }}" alt="{{ alt ?? title }}">
                            </a>
                        </div>
                    {{ /multimedia }}
                </div>
            </div>
        {{ /if }}
        
        {{ partial:components/related-content :current_id="id" :tags="tags" }}
    </div>
</article>
```

### Publications Templates

```html
<!-- resources/views/statamic/templates/publicaciones/index.antlers.html -->
{{ partial:components/page-header title="Publicaciones" }}

<div class="publicaciones-filters container">
    {{ taxonomy:years }}
        <a href="{{ url }}" class="filter-link {{ if is_current }}active{{ /if }}">
            {{ title }}
        </a>
    {{ /taxonomy:years }}
</div>

<div class="publicaciones-grid container">
    <div class="row">
        {{ collection:publicaciones limit="12" paginate="true" sort="publication_date:desc" }}
            <div class="col-md-6 col-lg-4 publicacion-item">
                <div class="card">
                    {{ if featured_image }}
                        <div class="card-image" style="background-image: url({{ featured_image }})"></div>
                    {{ /if }}
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="{{ url }}">{{ title }}</a>
                        </h3>
                        {{ if subtitle }}<p class="card-subtitle">{{ subtitle }}</p>{{ /if }}
                        
                        {{ if publication_date }}
                            <div class="card-meta">
                                <span class="date">{{ publication_date format="F j, Y" }}</span>
                                {{ if type }}<span class="type">{{ type }}</span>{{ /if }}
                            </div>
                        {{ /if }}
                    </div>
                </div>
            </div>
            
            {{ if no_results }}
                <div class="col-12 no-results">
                    <p>No publications found.</p>
                </div>
            {{ /if }}
            
            {{ partial:components/pagination }}
        {{ /collection:publicaciones }}
    </div>
</div>
```

```html
<!-- resources/views/statamic/templates/publicaciones/show.antlers.html -->
<article class="publicacion-detail">
    {{ partial:components/breadcrumbs }}
    
    <div class="container">
        <header class="publicacion-header">
            <h1>{{ title }}</h1>
            {{ if subtitle }}<h2 class="subtitle">{{ subtitle }}</h2>{{ /if }}
            
            <div class="meta">
                {{ if publication_date }}<span class="date">{{ publication_date format="F j, Y" }}</span>{{ /if }}
                {{ if type }}<span class="type">{{ type }}</span>{{ /if }}
            </div>
        </header>
        
        <div class="row">
            <div class="col-md-8">
                <div class="publicacion-content">
                    {{ synopsis }}
                    
                    {{ if texts }}
                        <div class="texts">
                            <h3>{{ trans:labels.texts }}</h3>
                            <div>{{ texts }}</div>
                        </div>
                    {{ /if }}
                </div>
                
                {{ if download_file }}
                    <div class="download-section">
                        {{ if requires_lead_capture }}
                            {{ partial:components/lead-capture-form 
                                asset_to_download="{download_file}"
                                title="{title}"
                                collection="publicaciones"
                                id="{id}"
                            }}
                        {{ else }}
                            <a href="{{ download_file }}" class="btn btn-primary">
                                {{ trans:labels.download }}
                            </a>
                        {{ /if }}
                    </div>
                {{ /if }}
            </div>
            
            <div class="col-md-4">
                <div class="sidebar">
                    {{ if editorial_coordination }}
                        <div class="sidebar-section">
                            <h4>{{ trans:labels.editorial_coordination }}</h4>
                            <p>{{ editorial_coordination }}</p>
                        </div>
                    {{ /if }}
                    
                    {{ if design }}
                        <div class="sidebar-section">
                            <h4>{{ trans:labels.design }}</h4>
                            <p>{{ design }}</p>
                        </div>
                    {{ /if }}
                    
                    {{ if page_count }}
                        <div class="sidebar-section">
                            <h4>{{ trans:labels.page_count }}</h4>
                            <p>{{ page_count }}</p>
                        </div>
                    {{ /if }}
                    
                    {{ if authors }}
                        <div class="sidebar-section">
                            <h4>{{ trans:labels.authors }}</h4>
                            {{ authors }}
                                <div class="author">
                                    <strong>{{ name }}</strong>
                                    {{ if role }}<span>{{ role }}</span>{{ /if }}
                                    {{ if bio }}<p>{{ bio }}</p>{{ /if }}
                                </div>
                            {{ /authors }}
                        </div>
                    {{ /if }}
                </div>
            </div>
        </div>
        
        {{ if multimedia }}
            <div class="multimedia-gallery">
                <h3>{{ trans:labels.gallery }}</h3>
                <div class="row gallery-grid">
                    {{ multimedia }}
                        <div class="col-md-4 gallery-item">
                            <a href="{{ url }}" data-fancybox="gallery">
                                <img src="{{ url }}" alt="{{ alt ?? title }}">
                            </a>
                        </div>
                    {{ /multimedia }}
                </div>
            </div>
        {{ /if }}
        
        {{ partial:components/related-content :current_id="id" :tags="tags" }}
    </div>
</article>
```

## Creating Components

Create reusable components for consistency across templates:

### SEO Metadata Component

```html
<!-- resources/views/statamic/components/seo-metadata.antlers.html -->
<meta property="og:title" content="{{ meta_title ?? title ?? site:name }}">
<meta property="og:description" content="{{ meta_description ?? site:description }}">
<meta property="og:url" content="{{ current_url }}">
<meta property="og:type" content="{{ og_type ?? 'website' }}">
{{ if og_image }}
    <meta property="og:image" content="{{ og_image }}">
{{ elseif featured_image }}
    <meta property="og:image" content="{{ featured_image }}">
{{ else }}
    <meta property="og:image" content="{{ site:default_image }}">
{{ /if }}

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ meta_title ?? title ?? site:name }}">
<meta name="twitter:description" content="{{ meta_description ?? site:description }}">
{{ if og_image }}
    <meta name="twitter:image" content="{{ og_image }}">
{{ elseif featured_image }}
    <meta name="twitter:image" content="{{ featured_image }}">
{{ else }}
    <meta name="twitter:image" content="{{ site:default_image }}">
{{ /if }}

<!-- Schema.org Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "{{ schema_type ?? 'WebPage' }}",
    "name": "{{ meta_title ?? title ?? site:name }}",
    "description": "{{ meta_description ?? site:description }}",
    "url": "{{ current_url }}"
    {{ if schema_type == 'Article' || collection == 'programa' || collection == 'publicaciones' || collection == 'noticias' }}
    ,
    "headline": "{{ title }}",
    "datePublished": "{{ date ?? publication_date ?? created_at format='Y-m-d' }}",
    "dateModified": "{{ updated_at format='Y-m-d' }}",
    "image": "{{ featured_image ?? site:default_image }}"
    {{ /if }}
}
</script>
```

### Popup Announcement Component

```html
<!-- resources/views/statamic/components/popup-announcement.antlers.html -->
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

### Related Content Component

```html
<!-- resources/views/statamic/components/related-content.antlers.html -->
{{ if tags }}
    {{ collection:* taxonomy:tags:contains="{ tags | join }" :id:not="current_id" limit="3" }}
        {{ if first }}
            <div class="related-content">
                <h3>{{ trans:labels.related_content }}</h3>
                <div class="row">
        {{ /if }}
        
        <div class="col-md-4">
            <div class="related-item">
                {{ if featured_image }}
                    <div class="related-image" style="background-image: url({{ featured_image }})"></div>
                {{ /if }}
                <h4><a href="{{ url }}">{{ title }}</a></h4>
                <span class="collection-type">{{ collection:title }}</span>
            </div>
        </div>
        
        {{ if last }}
                </div>
            </div>
        {{ /if }}
        
        {{ if no_results }}
            <!-- No related content found -->
        {{ /if }}
    {{ /collection:* }}
{{ /if }}
```

### Lead Capture Form Component

```html
<!-- resources/views/statamic/components/lead-capture-form.antlers.html -->
<div class="lead-capture-form">
    <h3>{{ trans:labels.download_form_title }}</h3>
    <p>{{ trans:labels.download_form_description }}</p>
    
    <form method="post" action="{{ route:statamic.forms.submit form='lead_capture' }}">
        {{ csrf_field }}
        <input type="hidden" name="asset_to_download" value="{{ asset_to_download }}">
        <input type="hidden" name="content_title" value="{{ title }}">
        <input type="hidden" name="content_id" value="{{ id }}">
        <input type="hidden" name="content_collection" value="{{ collection }}">
        
        <div class="form-group">
            <label for="name">{{ trans:labels.name }} <span class="required">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">{{ trans:labels.email }} <span class="required">*</span></label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="organization">{{ trans:labels.organization }}</label>
            <input type="text" name="organization" id="organization" class="form-control">
        </div>
        
        <div class="form-check">
            <input type="checkbox" name="newsletter_signup" id="newsletter_signup" class="form-check-input">
            <label for="newsletter_signup" class="form-check-label">{{ trans:labels.newsletter_signup }}</label>
        </div>
        
        <div class="form-check">
            <input type="checkbox" name="privacy_policy" id="privacy_policy" class="form-check-input" required>
            <label for="privacy_policy" class="form-check-label">{{ trans:labels.privacy_policy_agreement }} <span class="required">*</span></label>
        </div>
        
        <button type="submit" class="btn btn-primary">{{ trans:labels.download }}</button>
    </form>
</div>
```

## Helper Components

### Breadcrumbs Component

```html
<!-- resources/views/statamic/components/breadcrumbs.antlers.html -->
<nav aria-label="breadcrumb" class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ site:url }}">{{ trans:labels.home }}</a></li>
            
            {{ if segment_1 }}
                <li class="breadcrumb-item">
                    {{ if collection }}
                        <a href="{{ site:url }}/{{ segment_1 }}">{{ collection:title }}</a>
                    {{ else }}
                        <a href="{{ site:url }}/{{ segment_1 }}">{{ segment_1 | title }}</a>
                    {{ /if }}
                </li>
            {{ /if }}
            
            {{ if segment_2 }}
                <li class="breadcrumb-item active" aria-current="page">{{ title }}</li>
            {{ /if }}
        </ol>
    </div>
</nav>
```

### Pagination Component

```html
<!-- resources/views/statamic/components/pagination.antlers.html -->
{{ if paginate.total_pages > 1 }}
    <nav aria-label="Page navigation" class="pagination-container">
        <ul class="pagination">
            {{ if paginate.prev_page }}
                <li class="page-item">
                    <a href="{{ paginate.prev_page }}" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            {{ else }}
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            {{ /if }}
            
            {{ paginate:window size="5" }}
                {{ if page == current_page }}
                    <li class="page-item active">
                        <span class="page-link">{{ page }}</span>
                    </li>
                {{ else }}
                    <li class="page-item">
                        <a href="{{ url }}" class="page-link">{{ page }}</a>
                    </li>
                {{ /if }}
            {{ /paginate:window }}
            
            {{ if paginate.next_page }}
                <li class="page-item">
                    <a href="{{ paginate.next_page }}" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            {{ else }}
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            {{ /if }}
        </ul>
    </nav>
{{ /if }}
```

## Converting Blade Syntax to Antlers

Here's a comparison of common patterns between Blade and Antlers templates:

### Conditionals

Blade:
```php
@if($variable)
    Content
@elseif($another_variable)
    Other content
@else
    Default content
@endif
```

Antlers:
```html
{{ if variable }}
    Content
{{ elseif another_variable }}
    Other content
{{ else }}
    Default content
{{ /if }}
```

### Loops

Blade:
```php
@foreach($items as $item)
    {{ $item->title }}
@endforeach

@forelse($items as $item)
    {{ $item->title }}
@empty
    No items found
@endforelse
```

Antlers:
```html
{{ items }}
    {{ title }}
{{ /items }}

{{ items }}
    {{ title }}
    {{ if no_results }}
        No items found
    {{ /if }}
{{ /items }}
```

### Including Partials

Blade:
```php
@include('partials.header', ['title' => $title])
```

Antlers:
```html
{{ partial:header title="{title}" }}
```

## Form Handling in Statamic

Create form configuration files:

```yaml
# content/forms/lead_capture.yaml
title: Lead Capture
honeypot: honeypot
store: true
email:
  - to: admin@casagallina.org
    from: no-reply@casagallina.org
    subject: "New Lead Capture Form Submission"
    html: emails/lead-capture
    text: emails/lead-capture-text
fields:
  name:
    display: Name
    validate: required
  email:
    display: Email
    validate: required|email
  organization:
    display: Organization
  newsletter_signup:
    display: Newsletter Signup
    type: checkbox
  privacy_policy:
    display: Privacy Policy Agreement
    type: checkbox
    validate: required
  asset_to_download:
    display: Asset to Download
  content_title:
    display: Content Title
  content_id:
    display: Content ID
  content_collection:
    display: Content Collection
```

## Template Configuration

Specify which template to use for each collection in the collection's YAML file:

```yaml
# content/collections/programa.yaml
template: programa/show
```

For listing pages, create routes in `routes/web.php`:

```php
Route::statamic('/programa', 'programa.index', [
    'title' => 'Programa',
]);

Route::statamic('/publicaciones', 'publicaciones.index', [
    'title' => 'Publicaciones',
]);

// Add other listing routes
``` 