# Statamic CMS Installation Steps

This document outlines the detailed steps for installing Statamic CMS into the existing Laravel application.

## Preparation

Before beginning the installation process, ensure you have:
- A backup of your database
- A backup of your code (preferably in a separate Git branch)
- Composer installed and updated

## Installation Steps

### 1. Prepare Composer Configuration

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

### 2. Clear Configuration Cache

```bash
php artisan config:clear
```

### 3. Install Statamic 

```bash
composer require statamic/cms --with-dependencies
```

### 4. Publish Configuration Files

```bash
php artisan vendor:publish --tag=statamic-config
```

### 5. Configure Statamic

Update the Statamic config files in `config/statamic/`:

#### Basic Settings (`config/statamic/system.php`)

```php
'license_key' => env('STATAMIC_LICENSE_KEY'),
'default_locale' => 'es',
'sites' => [
    'default' => [
        'name' => 'Español',
        'locale' => 'es',
        'url' => '/',
    ],
],
```

#### Enable Multi-site Support

```php
// config/statamic/system.php
'multisite' => true,
```

#### Configure Sites

Create or edit `resources/sites.yaml`:

```yaml
es:
  name: Español
  url: /
  locale: es_MX
  lang: es
en:
  name: English
  url: /en/
  locale: en_US
  lang: en
```

### 6. Generate Auth Migration

If using Statamic's user authentication system:

```bash
php please auth:migration
php artisan migrate
```

### 7. Verify Installation 

Check that Statamic is properly installed by accessing the Control Panel at `/cp` (or your custom CP path). You should be able to log in and see the Statamic dashboard.

## Post-Installation Configuration

### 1. Configure Control Panel Access

Update Control Panel settings in `config/statamic/cp.php`:

```php
'enabled' => true,
'route' => 'admin', // Customize CP route as needed
```

### 2. Set Up Users and Permissions

Create initial superuser:

```bash
php please make:user
```

Follow the prompts to create a superuser account with appropriate permissions.

### 3. Test Basic Functionality

- Log into the control panel 
- Create a test collection and entry
- Check that front-end rendering works 