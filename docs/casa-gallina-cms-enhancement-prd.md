# Casa Gallina CMS Enhancement - Product Requirements Document

**Version:** 1.0  
**Date:** 2025-07-16  
**Status:** Planning Phase  

## Table of Contents

1. [Executive Summary](#executive-summary)
2. [Current System Analysis](#current-system-analysis)
3. [Enhancement Requirements](#enhancement-requirements)
4. [Technical Implementation Details](#technical-implementation-details)
5. [Database Schema Changes](#database-schema-changes)
6. [Implementation Phases](#implementation-phases)
7. [Risk Assessment](#risk-assessment)
8. [Success Metrics](#success-metrics)

---

## Executive Summary

This document outlines comprehensive enhancements to the Casa Gallina CMS system, focusing on two main areas:

1. **Exposiciones Detail Page Improvements** - Enhanced publication display, content management, and integration with programs
2. **Noticias System Refactoring** - Complete category system overhaul and donation integration

The enhancements will improve content management workflow, enhance user experience, and add new monetization features while maintaining the existing bilingual architecture and responsive design.

---

## Current System Analysis

### Current Architecture Overview

The Casa Gallina application is a Laravel 12 system with the following key characteristics:

- **Hybrid Architecture**: Traditional Laravel controllers for public routes, Livewire components for admin
- **Bilingual Support**: Spanish (root) and English (/en) with shared controllers
- **Content Types**: Exposiciones (exhibitions), Programas (programs), Noticias (news), Publicaciones (publications)
- **Tag System**: Flexible categorization across all content types
- **Multimedia Management**: Automatic image processing via ImageService
- **Payment Integration**: Stripe via Laravel Cashier for donations

### Current Models and Relationships

#### Core Models:
- **Exposicion**: Unified model for exhibitions and artistic projects (`type` field)
- **Programa**: Community programs with flexible date/metadata
- **Noticia**: News articles with hardcoded `tipo` enum categorization
- **Tag**: Rich categorization system with multimedia support
- **Multimedia**: File storage tracking

#### Key Relationships:
- Many-to-many: Content ↔ Multimedia (via pivot tables)
- Many-to-many: Content ↔ Tags
- One-to-many: Exposicion → ExposicionArchivo/Video
- One-to-many: Noticia → NoticiaArchivo/Video

### Current File Structure Analysis

**Admin Components:**
- `App\Livewire\Admin\Exposicion\Page` - Exhibition management
- `App\Livewire\Admin\Noticia\Page` - News management
- Modern Livewire 3 + Flux UI components

**Public Views:**
- `resources/views/public/exposicion-detalle.blade.php` - Exhibition detail page
- `resources/views/public/noticias.blade.php` - News listing
- `resources/views/public/noticia.blade.php` - News detail

**Current Download System:**
- ExposicionArchivo model with thumbnail support
- Direct storage links without tracking
- Separate Publicacion system with PDF viewer

**Current Donation System:**
- Bootstrap modal in `resources/views/partials/modals.blade.php`
- PaymentController with Stripe integration
- Fixed donation amounts with custom option
- Donador model with Laravel Cashier

---

## Enhancement Requirements

### Section 1: Exposiciones Detail Enhancements

#### 1.1 Download File Display Redesign

**Current State:**
- Full-width image cards for downloadable files in `exposicion-detalle.blade.php` (lines 97-122)
- ExposicionArchivo model with title + description fields

**New Requirements:**
- **Two-column layout**: 
  - Column 1: Publication book-style image (similar to publicaciones listing)
  - Column 2: Single rich text field using Flux rich editor
- **Content Changes**: Replace title + description with open text field for flexible content
- **Action Buttons**: Two green buttons below - "Download" and "Preview"
- **PDF Viewer**: Implement same modal as publicacion detalle page
- **Visual Style**: Match existing publicaciones book-style presentation

#### 1.2 Publications Data Model & Integration

**New Data Requirements:**
- Enhance `Publicacion` model with optional relationships:
  - `exposicion_id` (nullable foreign key)
- Replace existing old publication admin with new Livewire component
- Maintain existing publication functionality with added relationship fields

**Display Logic:**
- **Associated Publications**: Show in exposicion detalle with link button (not download)
- **Standalone Publications**: Show as downloadable with download/preview buttons
- **Book-style presentation**: Use same visual treatment as publicaciones listing

#### 1.3 Programa-Actividad Integration

**Current State:**
- Programa model exists with flexible metadata structure
- No relationship between programs and exposiciones

**New Requirements:**
- **Actividad Management**: Add checkbox field in Actividad creation: "Assign to Expo/Proyecto Artistico"
- **Assignment Logic**: When checked, allow selection of specific exposicion or proyecto artistico using autocomplete search component
- **Autocomplete Component**: Create reusable Livewire search component:
- Custom search functionality to prevent memory/database bloat
- Reusable across all association interfaces
- Real-time search with debouncing
- **Display Integration**: Show assigned programas in exposicion detalle below description section
- **Visual Consistency**: Use same layout as programa detalle for multiple activities display

#### 1.4 Noticia-Exposicion Relationship

**New Requirements:**
- **One-to-one relationship**: Add `exposicion_id` to noticias table
- **Autocomplete Component**: Create reusable Livewire search component:
  - Custom search functionality to prevent memory/database bloat
  - Reusable across all association interfaces
  - Real-time search with debouncing

### Section 2: Noticias System Refactoring

#### 2.1 Category System Overhaul

**Current State:**
- Hardcoded `tipo` enum with 8 categories: `['articulo', 'cronica', 'entrevista', 'otras_experiencias', 'resena_invitacion', 'noticias', 'enlaces', 'newsletter']`
- Categories used throughout system for filtering and display

**New Requirements:**
- **Remove Existing System**: Completely remove `tipo` field and all references
- **New Database Structure**: Create `news_tags` table for user-manageable tags
- **Admin Interface**: Create tag management interface in admin panel
- **SEO Optimization**: Dynamic tags for improved search optimization

**UI Changes:**
- **Tag Badge**: Add tag badge on top-right of images in noticias index
- **Detail Display**: Show tag below date in news detail view
- **Filter System**: Implement tag-based filtering in news listing

#### 2.2 Donation Integration

**Current State:**
- Donation modal system with fixed amounts
- PaymentController with Stripe integration
- Donador model with Laravel Cashier

**New Requirements:**
- **Noticia-specific Donations**: Add `donation_enabled` boolean field to noticias
- **Donation Section**: When enabled, display donation section below page content
- **Design Consistency**: Use same structure/fields as current donation modal popup
- **Payment Integration**: Extend Stripe configuration for page-specific tracking
- **Progress Tracking**: Track donation goals and progress per page

---

## Technical Implementation Details

### Required New Components

#### 1. Publication Admin Component
- **File**: `App\Livewire\Admin\Publicacion\Page`
- **Requirements**: Modern Livewire 3 + Flux UI matching existing admin style
- **Features**: 
  - CRUD operations for publications
  - Optional expo/project assignment
  - File upload with ImageService integration
  - Rich text editor for content

#### 2. Autocomplete Search Component
- **File**: `App\Livewire\Admin\Exposicion\AutocompleteSearch`
- **Requirements**: Reusable across all association interfaces
- **Features**:
  - Real-time search with debouncing
  - Custom search logic to prevent memory bloat
  - Configurable for different model types
  - Accessible UI with keyboard navigation

#### 3. Category Management Component
- **File**: `App\Livewire\Admin\Noticia\TagsPage`
- **Requirements**: Standard CRUD interface
- **Features**:
  - Tag creation/editing
  - SEO-friendly slug generation
  - Tag ordering/hierarchy
  - Bulk operations

#### 4. Donation Section Component
- **File**: `App\Livewire\Components\DonationSection`
- **Requirements**: Embeddable in article pages
- **Features**:
  - Same UI as current donation modal
  - Noticia-specific donation tracking
  - Progress bar display
  - Goal setting and management

### Current Files Requiring Modification

#### Models to Update:
- `App\Models\Exposicion` - Add publication relationships
- `App\Models\Noticia` - Add exposicion relationship and donation fields
- `App\Models\Programa` - Add actividad assignment logic
- Create new: `App\Models\NewsTag`

#### Controllers to Update:
- `App\Http\Controllers\PublicController` - Add donation data to article views
- `App\Http\Controllers\PaymentController` - Extend for article-specific donations

#### Views to Update:
- `resources/views/public/exposicion-detalle.blade.php` - Two-column layout, programa integration
- `resources/views/public/noticias.blade.php` - Category badges, remove tipo references
- `resources/views/public/noticia.blade.php` - Category display, donation section
- `resources/views/livewire/public/noticias-page.blade.php` - Category filtering

#### Admin Components to Update:
- `App\Livewire\Admin\Exposicion\Page` - Publication relationship management
- `App\Livewire\Admin\Noticia\Page` - Remove tipo, add category and donation fields
- `App\Livewire\Admin\Programa\Page` - Add actividad assignment

---

## Database Schema Changes

### New Tables

#### 1. Publications Table Enhancement
```sql
-- Modify existing publications table
ALTER TABLE publicaciones ADD COLUMN exposicion_id BIGINT NULL;
ALTER TABLE publicaciones ADD COLUMN proyecto_artistico_id BIGINT NULL;
ALTER TABLE publicaciones ADD CONSTRAINT fk_pub_exposicion 
    FOREIGN KEY (exposicion_id) REFERENCES exposiciones(id) ON DELETE SET NULL;
ALTER TABLE publicaciones ADD CONSTRAINT fk_pub_proyecto 
    FOREIGN KEY (proyecto_artistico_id) REFERENCES exposiciones(id) ON DELETE SET NULL;
```

#### 2. News Categories Table
```sql
CREATE TABLE news_tags (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    descripcion TEXT,
    color VARCHAR(7) DEFAULT '#68945c',
    orden INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### 3. News Category Relationship
```sql
-- Add category relationship to noticias
ALTER TABLE noticias ADD COLUMN news_category_id BIGINT NULL;
ALTER TABLE noticias ADD CONSTRAINT fk_noticia_category 
    FOREIGN KEY (news_category_id) REFERENCES news_tags(id) ON DELETE SET NULL;
```

#### 4. Programa-Exposicion Integration
```sql
-- Add actividad assignment to programas (or create separate actividades table)
ALTER TABLE programas ADD COLUMN actividad_assignment BOOLEAN DEFAULT FALSE;
ALTER TABLE programas ADD COLUMN assigned_exposicion_id BIGINT NULL;
ALTER TABLE programas ADD CONSTRAINT fk_programa_exposicion 
    FOREIGN KEY (assigned_exposicion_id) REFERENCES exposiciones(id) ON DELETE SET NULL;
```

#### 5. Noticia-Exposicion Relationship
```sql
-- Add exposicion relationship to noticias
ALTER TABLE noticias ADD COLUMN exposicion_id BIGINT NULL;
ALTER TABLE noticias ADD CONSTRAINT fk_noticia_exposicion 
    FOREIGN KEY (exposicion_id) REFERENCES exposiciones(id) ON DELETE SET NULL;
```

#### 6. Donation Integration
```sql
-- Add donation fields to noticias
ALTER TABLE noticias ADD COLUMN donation_enabled BOOLEAN DEFAULT FALSE;
ALTER TABLE noticias ADD COLUMN donation_goal DECIMAL(10,2) DEFAULT NULL;
ALTER TABLE noticias ADD COLUMN donation_current DECIMAL(10,2) DEFAULT 0;

-- Create donation transactions table
CREATE TABLE donation_transactions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    donador_id BIGINT NOT NULL,
    donatable_type VARCHAR(255) NOT NULL,
    donatable_id BIGINT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    stripe_payment_intent_id VARCHAR(255),
    status VARCHAR(50) DEFAULT 'pending',
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (donador_id) REFERENCES donadores(id) ON DELETE CASCADE,
    INDEX idx_donatable (donatable_type, donatable_id),
    INDEX idx_donador (donador_id)
);
```

### Tables/Fields to Remove

#### 1. Remove Tipo System
```sql
-- Remove tipo field from noticias (after migration)
ALTER TABLE noticias DROP COLUMN tipo;

-- Remove tipo-related banner fields
ALTER TABLE noticias DROP COLUMN banner_articulo;
ALTER TABLE noticias DROP COLUMN banner_cronica;
ALTER TABLE noticias DROP COLUMN banner_entrevista;
ALTER TABLE noticias DROP COLUMN banner_noticias;
ALTER TABLE noticias DROP COLUMN banner_otras_experiencias;
ALTER TABLE noticias DROP COLUMN banner_resena_invitacion;
ALTER TABLE noticias DROP COLUMN banner_enlaces;
ALTER TABLE noticias DROP COLUMN banner_newsletter;
```

### Migration Strategy

1. **Category Migration**: Create migration to convert existing `tipo` values to news_tags
2. **Data Preservation**: Ensure all existing content maintains its categorization
3. **Fallback Handling**: Create "Uncategorized" category for edge cases
4. **Rollback Plan**: Maintain ability to revert changes if issues arise

---

## Implementation Phases

### Phase 1: Database and Models (Week 1-2)
**Priority: High**

#### Tasks:
- [ ] Create new database tables and relationships
- [ ] Update existing models with new relationships
- [ ] Create new models: Publicacion, NewsTag
- [ ] Write comprehensive migration files
- [ ] Create seeders for news categories (migrate existing tipos)

#### Deliverables:
- Database schema updated
- Models with proper relationships
- Migration files tested
- Seeded data ready for development

### Phase 2: Admin Interface Development (Week 3-4)
**Priority: High**

#### Tasks:
- [ ] Create Publication admin Livewire component
- [ ] Build AutocompleteSearch reusable component
- [ ] Implement NewsTag management interface
- [ ] Update existing admin components:
  - [ ] Exposicion admin for publication relationships
  - [ ] Noticia admin for category and donation fields
  - [ ] Programa admin for actividad assignment
- [ ] Create donation management interface

#### Deliverables:
- Modern admin interfaces following existing patterns
- Reusable autocomplete component
- Full CRUD operations for all new entities
- Integration with existing admin workflow

### Phase 3: Public Interface Updates (Week 5-6)
**Priority: Medium**

#### Tasks:
- [ ] Update exposicion-detalle.blade.php:
  - [ ] Implement two-column layout for downloads
  - [ ] Add program display section
  - [ ] Integrate PDF viewer functionality
- [ ] Update noticias listing and detail pages:
  - [ ] Add category badges
  - [ ] Remove all tipo references
  - [ ] Implement category filtering
- [ ] Create donation section component
- [ ] Update bilingual support for all new features

#### Deliverables:
- Enhanced exposicion detail page
- Refactored noticias system
- Category-based filtering
- Donation integration in pages

### Phase 4: Payment Integration (Week 7)
**Priority: Medium**

#### Tasks:
- [ ] Extend PaymentController for noticia-specific donations
- [ ] Update Stripe configuration for donation tracking
- [ ] Implement donation progress tracking
- [ ] Add donation goal management
- [ ] Test payment flows thoroughly

#### Deliverables:
- Noticia-specific donation functionality
- Payment tracking and reporting
- Goal progress visualization
- Stripe integration tested

### Phase 5: Testing and Cleanup (Week 8)
**Priority: High**

#### Tasks:
- [ ] Remove all old category system references
- [ ] Comprehensive testing of all new features
- [ ] Performance optimization
- [ ] Security audit of new components
- [ ] Update documentation
- [ ] User acceptance testing

#### Deliverables:
- Clean codebase without legacy tipo system
- Thoroughly tested features
- Performance optimized
- Security validated
- Documentation updated

---

## Risk Assessment

### Technical Risks

#### High Risk:
- **Database Migration Complexity**: Converting existing tipo tags to new system
  - *Mitigation*: Comprehensive testing environment, rollback plan
- **Performance Impact**: New relationships may affect query performance
  - *Mitigation*: Proper indexing, query optimization, caching strategy

#### Medium Risk:
- **Stripe Integration Changes**: Ensuring payment tracking works correctly
  - *Mitigation*: Thorough testing with Stripe test mode, gradual rollout
- **Admin Interface Complexity**: New autocomplete component needs to be robust
  - *Mitigation*: Progressive enhancement, fallback options

#### Low Risk:
- **UI/UX Consistency**: Maintaining design consistency across new features
  - *Mitigation*: Use existing Flux UI components, follow established patterns

### Business Risks

#### User Impact:
- **Learning Curve**: New admin interfaces require user training
  - *Mitigation*: Comprehensive documentation, user training sessions
- **Content Migration**: Existing tagged content must be preserved
  - *Mitigation*: Automated migration with manual review process

#### Operational Risks:
- **Donation System Reliability**: Payment failures could impact revenue
  - *Mitigation*: Extensive testing, monitoring, fallback mechanisms

---

## Success Metrics

### User Experience Metrics
- [ ] Improved content management workflow efficiency
- [ ] Enhanced publication presentation quality
- [ ] Streamlined category management process
- [ ] Successful donation integration functionality

### Technical Metrics
- [ ] Database query performance maintained or improved
- [ ] Zero data loss during migration
- [ ] 99.9% uptime during implementation
- [ ] All existing functionality preserved

### Business Metrics
- [ ] Increased donation conversion rates
- [ ] Improved SEO through dynamic categories
- [ ] Enhanced content relationship management
- [ ] Successful noticia-specific donation tracking

### Acceptance Criteria

#### Exposiciones Section:
- [ ] Publications display in book-style two-column layout
- [ ] Flux rich text editor integration working
- [ ] PDF preview functionality operational
- [ ] Programa-actividad assignment system functional
- [ ] Noticia-exposicion relationship working correctly

#### Noticias Section:
- [ ] Old tipo tag system completely removed
- [ ] New tag management system operational
- [ ] Tag badges display correctly on all pages
- [ ] Donation sections integrate properly with noticias
- [ ] Stripe tracking per noticia functional and tested

#### General Requirements:
- [ ] All features maintain existing bilingual support
- [ ] Responsive design preserved across all devices
- [ ] Admin interfaces follow existing UI patterns
- [ ] Performance metrics meet or exceed current benchmarks
- [ ] Security standards maintained throughout

---

## Appendix

### Related Documentation
- `/docs/statamic-migration-spec.md` - Previous migration specifications
- `/CLAUDE.md` - Project-specific development guidelines
- Laravel 12 documentation
- Livewire 3 documentation
- Flux UI component library

### Key Files Reference
- **Models**: `/app/Models/` - All data models
- **Controllers**: `/app/Http/Controllers/` - Request handling
- **Livewire**: `/app/Livewire/` - Interactive components
- **Views**: `/resources/views/` - Frontend templates
- **Migrations**: `/database/migrations/` - Database changes
- **Config**: `/config/` - Application configuration

### Development Commands
```bash
# Asset building
npm run dev          # Development server
npm run build        # Production build

# Database operations
php artisan migrate  # Run migrations
php artisan db:seed  # Seed database

# Cache management
php artisan optimize # Optimize for production
php artisan config:cache
```

---

*This PRD serves as a comprehensive guide for implementing the Casa Gallina CMS enhancements. All features should maintain the existing bilingual support, responsive design standards, and security practices outlined in the project's CLAUDE.md file.*