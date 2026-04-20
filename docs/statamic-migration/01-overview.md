# Statamic CMS Migration Overview

This document provides an overview of the migration from Casa Gallina's current custom CMS implementation to Statamic CMS.

## Project Goals

The migration aims to leverage Statamic CMS while preserving existing functionality and data, along with implementing 22 specific enhancements to improve user experience, SEO, and administrative capabilities.

## Current Website Structure

- **Home (Inicio)**: Features highlighted strategies, publications, and collaboration spaces
- **The House (La Casa)**: Information about Casa Gallina and team members
- **Strategies (Estrategias)**: Projects and initiatives with multimedia content
- **Publications (Publicaciones)**: Digital and printed materials
- **Newsletters (Boletines)**: Historical newsletter archives
- **Donations (Donaciones)**: Donation methods and campaigns

## Technical Limitations to Address

1. URLs include numeric IDs (e.g., `/publicacion/slug-name/35`)
2. Inconsistent URL naming between list and detail views
3. Limited metadata management for SEO
4. No structured data implementation (schema.org)
5. Limited content organization capabilities
6. No popup/announcement functionality
7. Limited donation campaign flexibility

## Migration Approach

We'll adopt an incremental migration approach:

1. Install Statamic alongside the existing application
2. Set up Statamic collections and blueprints mirroring the current data models
3. Migrate content from the existing database to Statamic
4. Adapt templates to use Statamic tags and structures
5. Implement custom functionality with Statamic addons or custom code
6. Test extensively
7. Switch to Statamic-powered routes and controllers 