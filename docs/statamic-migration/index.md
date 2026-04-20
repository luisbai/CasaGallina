# Statamic CMS Migration Documentation

This documentation outlines the comprehensive plan for migrating Casa Gallina's custom CMS to Statamic CMS.

## Migration Overview

The migration aims to leverage Statamic CMS while preserving existing functionality and data, along with implementing 22 specific enhancements to improve user experience, SEO, and administrative capabilities.

## Document Structure

This documentation is organized into the following sections:

1. [Overview](./01-overview.md) - Project goals, current structure, and migration approach
2. [Requirements](./02-requirements.md) - Server and Statamic requirements, pre-migration tasks
3. [Installation](./03-installation.md) - Detailed steps for installing Statamic in the existing Laravel application
4. [Content Structure](./04-content-structure.md) - Changes to content organization and collection setup
5. [Blueprints](./05-blueprints.md) - Field configurations for each collection
6. [Content Migration](./06-content-migration.md) - Process for migrating data from the existing database to Statamic
7. [Templates](./07-templates.md) - Template migration and Antlers syntax guide
8. [Enhancements](./08-enhancements.md) - The 22 specific enhancements to implement
9. [URL Migration](./09-url-migration.md) - Handling redirects and URL structure changes
10. [Testing & Launch](./10-testing-launch.md) - Testing strategy and launch checklist
11. [Timeline](./11-timeline.md) - Detailed project schedule

## Key Project Stakeholders

- **Project Manager**: Oversees the entire migration process
- **Backend Developer**: Handles Statamic installation, configuration, and data migration
- **Frontend Developer**: Implements templates and frontend features
- **Content Specialist**: Ensures content integrity during migration
- **QA Specialist**: Tests functionality and performance

## Quick Reference

### Migration Timeline Summary

The complete migration is expected to take approximately 20 weeks (5 months) from initial setup to final launch:

- **Phase 1 (Weeks 1-2)**: Planning and Setup
- **Phase 2 (Weeks 3-5)**: Content Structure Development
- **Phase 3 (Weeks 6-8)**: Data Migration
- **Phase 4 (Weeks 9-14)**: Template Development
- **Phase 5 (Weeks 15-17)**: Feature Implementation
- **Phase 6 (Weeks 18-19)**: Testing and Optimization
- **Phase 7 (Week 20)**: Launch and Monitoring
- **Post-Launch Support (Weeks 21-24)**: Continued support and training

### Key Enhancements

1. Rename sections and change URLs
2. Consistent URL structure
3. Popup announcement feature
4. Program section reorganization
5. Enhanced SEO metadata management
6. Homepage reorganization
7. Publications encoding review
8. Publication lead form improvements
9. Schema.org implementation
10. Enhanced donation pages
11. US fiscal donation page
12. Newsletter subscription enhancement
13. News section creation
14. Robots.txt configuration
15. Sitemap.xml implementation
16. Privacy policy update
17. Related content sidebar
18. Internal search functionality
19. Allies section update
20. Expanded publication author fields
21. Downloadable materials repository
22. Enhanced maps for allies and initiatives

## Getting Started

Begin by reviewing the [Overview](./01-overview.md) and [Requirements](./02-requirements.md) documents to understand the scope and prerequisites for the migration.

## Technical Resources

- [Statamic Documentation](https://statamic.dev/)
- [Laravel Documentation](https://laravel.com/docs)
- [Antlers Documentation](https://statamic.dev/antlers)
- [Statamic 3 Migration Guide](https://statamic.dev/upgrade-guide) 