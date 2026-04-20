# Statamic CMS Migration Requirements

This document outlines the server and Statamic requirements for the migration process.

## Server Requirements

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

## Statamic Requirements

- Statamic 5.x (compatible with Laravel 10+)
- Statamic Pro license for production use (multi-site features require Pro)

## Pre-Migration Tasks

### Database Backup
- Create a full backup of the current database
- Document current database schema

### Code Backup
- Create a Git branch for the migration
- Ensure all changes are committed

### Content Inventory
- Document all content types in the system:
  - Estrategias (to be renamed to "Programa")
  - Publicaciones
  - Boletines
  - Espacios
  - Miembros
  - Multimedia assets

### Functionality Assessment
- Document all custom functionality:
  - Multi-language support (English/Spanish)
  - Admin panel capabilities
  - File uploads and management
  - Public facing site structure
  - Donation system 