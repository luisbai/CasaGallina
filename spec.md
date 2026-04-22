# Casa Gallina - System Specification

> [!IMPORTANT]
> This document serves as the **Source of Truth** for the functional requirements and system architecture of the Casa Gallina platform. Any changes to the functionality must be reflected here.

## 1. System Overview
The Casa Gallina platform is a Content Management System (CMS) and public portal designed to showcase the organization's strategies, programs, exhibitions, and artistic projects. It also handles donations, newsletters, and team management.

## 2. Technology Stack
- **Framework**: Laravel 11/12 (PHP 8.2+)
- **Frontend**: Livewire, Flux UI, Blade Components
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Sanctum
- **Payments**: Laravel Cashier (Stripe/Payment Gateway integration)
- **Assets**: Vite, TailwindCSS

## 3. Functional Modules

### 3.1 Public Portal
The public interface allows visitors to explore content and engage with the organization.

- **Home**: Landing page with featured content.
- **La Casa**: Information about the physical space and organization.
- **Strategies (Estrategias)**: Detailed views of organizational strategies.
- **Programs (Programa)**:
    - Categorized by Local and External strategies.
    - Tag-based filtering and detail views.
- **Exhibitions (Exposiciones)**:
    - Gallery of exhibitions with multimedia (images, videos, archives).
    - Archive viewer for specific documents.
- **Artistic Projects (Proyectos Artísticos)**: Similar to exhibitions, showcasing specific projects.
- **News (Noticias)**: Blog/News section with multimedia support.
- **Publications (Publicaciones)**:
    - Digital library of publications.
    - PDF Viewer and Download capabilities.
    - Contact form for physical copies.
- **Donations (Donaciones)**:
    - Support for One-time, Monthly, Personalized, and International donations.
    - Campaign support.
    - Checkout integration.
- **Search (Búsqueda)**: Global search functionality.
- **Newsletters (Boletines)**: Archive of sent newsletters and subscription form.
- **Team (Miembros)**: Directory of team members.
- **Contact**: General contact and specific forms per section.
- **Bilingual Support**: Full English mirror of public routes (`/en/*`).

### 3.2 Admin Panel
Protected area for content management.

- **Dashboard**: System overview.
- **Content Management**:
    - **Strategies**: CRUD operations.
    - **Collaborative Spaces (Espacios)**: Manage physical spaces.
    - **Team Members**: Manage staff profiles.
    - **Newsletters**: Manage and archive bulletins.
    - **Publications**: Manage book entries.
    - **Programs**: Comprehensive management of programs and assignments.
    - **Exhibitions & Artistic Projects**: Manage galleries, videos, and archives.
    - **News**: Manage news posts and rich content.
    - **Tags**: Manage system-wide tags for categorization.
- **Donations**: View and manage donation records.
- **Contact Forms**: View form submissions (Leads).
- **Homepage**: Customize homepage sections.

## 4. Data Model (Key Entities)

### Content Entities
- **Estrategia**: Core strategic pillars.
- **Programa**: Activities and programs, linked to strategies.
- **Exposicion**: Visual exhibitions with multimedia.
- **ProyectoArtistico**: Arbitrary artistic projects.
- **Publicacion**: Books and periodicals.
- **Noticia**: News items/Blog posts.
- **Boletin**: Newsletters.

### Relations & Metadata
- **Tag**: Polymorphic tagging system (related to Programs, Exhibitions, News, etc.).
- **Multimedia**: Polymorphic relations for images and media.
- **Video/Archivo**: Specific tables for rich media handling in Exhibitions and News.

### User & CRM
- **User**: Admin users.
- **Donador**: Donor profiles.
- **Subscription**: Recurring donation records.
- **Lead/ContactSubmission**: Form entries from visitors.

## 5. System Requirements
- **Server**: PHP 8.2+, Composer.
- **Database**: MySQL 8.0+.
- **Frontend**: Node.js & NPM for building assets.

## 6. Future Roadmap / Pending Analysis
- Payment gateway specifics (Stripe vs others).
- Detailed permission system (Roles beyond simple Admin).
- Search indexing strategy (Database vs Scout/Meilisearch).
