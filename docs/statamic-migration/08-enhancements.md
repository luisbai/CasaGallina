# Feature Enhancements

This document outlines the 22 specific enhancements to be implemented as part of the migration to Statamic CMS.

## 1. Rename Sections and Change URLs

- Rename "Numeralia" to "Impacto"
- Rename "Estrategias" to "Programa" 
- Update all related templates, routes, and navigation items
- Configure 301 redirects from old to new URLs

**Implementation Details:**
- Implement collections with appropriate naming (as outlined in the Content Structure document)
- Update navigation menus in Control Panel
- Create redirect middleware (see URL Structure Migration document)

## 2. Consistent URL Structure for Publications

Remove IDs from URLs and implement a consistent naming pattern:

**Before:**
- `/publicacion/slug-name/35`
- `/estrategia/slug-name/35`

**After:**
- `/publicaciones/slug-name`
- `/programa/slug-name`

**Implementation Details:**
- Configure routes in collection YAMLs
- Set up 301 redirects using middleware
- Ensure slugs are unique across languages

## 3. Popup Announcement Feature

Implement a flexible popup announcement system:

**Features:**
- Customizable title and content
- Optional link button
- Start/end date scheduling
- Dismissible by users
- Stored in localStorage to prevent repeat views

**Implementation:**
- Create `popup` global set with toggle, title, content, link fields
- Add date range controls for scheduling
- Implement JavaScript for display/dismiss functionality
- Add cookie/localStorage handling

## 4. Program Section Reorganization

Create a hierarchical structure for the Program section:

**Structure:**
- Main "Programa" collection with subcategories
  - Exposiciones (Exhibitions)
  - Proyectos Artísticos (Artistic Projects)
  - Programa Local (Local Program)
    - Huerto (Garden)
    - Cocina (Kitchen)
    - Infancias (Children)
  - Programa Externo (External Program)
    - Mapeos (Mappings)

**Implementation:**
- Use Statamic's collection structure feature
- Create appropriate taxonomies for program types
- Implement navigation to reflect hierarchical structure

## 5. Enhanced SEO Metadata Management

Add comprehensive SEO management capabilities:

**Features:**
- Custom meta titles and descriptions for each page/entry
- Social sharing previews
- Structured data (schema.org)
- Canonical URLs
- SEO audit tools

**Implementation:**
- Add SEO field section to all blueprints
- Create reusable SEO partial for templates
- Implement schema.org JSON-LD markup
- Use SEO addon if additional functionality is needed

## 6. Homepage Reorganization

Create a more flexible homepage layout:

**Features:**
- Customizable content sections
- Ability to add/remove/reorder sections
- Featured content selection
- Hero area customization
- Cross-promotion of content types

**Implementation:**
- Create homepage blueprint with replicator field
- Allow admins to select featured content
- Design modular components for each section type

## 7. Publications Encoding Review

Fix character encoding issues in existing publications:

**Tasks:**
- Review all content for encoding issues
- Implement UTF-8 normalization during migration
- Add validation for new content
- Fix special characters in titles and content

**Implementation:**
- Add content cleaning functions to migration scripts
- Implement encoding validation

## 8. Publication Lead Form Improvements

Enhance lead capture for downloadable publications:

**Features:**
- Redesigned form UI
- Required fields for name, email
- Optional organization field
- Privacy policy acceptance checkbox
- Newsletter opt-in option
- Analytics tracking

**Implementation:**
- Create lead capture form in Statamic
- Implement form handling with validation
- Configure email notifications for submissions
- Add lead data storage and export

## 9. Schema.org Implementation

Add structured data for better search engine understanding:

**Types to Implement:**
- Organization schema for Casa Gallina
- Article schema for publications and news
- Event schema for exhibitions and activities
- CreativeWork schema for artistic projects

**Implementation:**
- Create schema.org JSON-LD partials
- Implement automatic schema type selection based on content
- Add dynamic data population from entry fields

## 10. Enhanced Donation Pages

Improve donation functionality:

**Features:**
- Multiple donation methods
- Campaign-specific donation pages
- Customizable donation amounts
- Improved tracking
- Thank you emails/pages

**Implementation:**
- Create donation form templates
- Set up campaign tracking
- Implement payment gateway integrations
- Add recurring donation options

## 11. US Fiscal Donation Page

Create dedicated page for US-based donors:

**Features:**
- US-specific tax information
- Different payment methods
- US dollar currency
- Legal disclosures
- Tax receipt generation

**Implementation:**
- Create separate donation template for US donors
- Add region-specific content
- Implement appropriate payment gateways

## 12. Newsletter Subscription Enhancement

Improve newsletter subscription process:

**Features:**
- Double opt-in process
- Interest selection
- Custom confirmation messages
- Integration with mailing service
- Subscription management page

**Implementation:**
- Create subscription form and handling
- Set up email templates for confirmation
- Implement subscriber management

## 13. News Section Creation

Implement new "Noticias" section:

**Features:**
- News article collection
- Category filtering
- Date-based archives
- Featured news on homepage
- RSS feed

**Implementation:**
- Create news collection and blueprint
- Design templates for listing and detail views
- Add to main navigation
- Implement RSS feed

## 14. Robots.txt Configuration

Improve search engine crawling control:

**Configuration:**
```
User-agent: *
Disallow: /cp/
Disallow: /admin/

User-agent: GPTBot
Disallow: /private-content/

User-agent: ChatGPT-User
Disallow: /private-content/
```

**Implementation:**
- Create robots.txt file with appropriate rules
- Add dynamic rules for staging/development environments
- Configure indexing controls in collection settings

## 15. Sitemap.xml Implementation

Add XML sitemap for search engines:

**Features:**
- All public pages included
- Priority setting for important pages
- Change frequency indication
- Last modified dates
- Multi-language support

**Implementation:**
- Enable Statamic's sitemap generation
- Configure sitemap settings
- Add auto-submission to search engines

## 16. Privacy Policy Update

Enhance privacy policy page:

**Features:**
- Versioning and last updated date
- Separate sections for cookie usage, data collection
- GDPR compliance information
- Localized versions for different regions

**Implementation:**
- Create privacy policy global with version tracking
- Implement template with appropriate sections
- Add cookie consent banner

## 17. Related Content Sidebar

Add related content to detail pages:

**Features:**
- Tag-based related content suggestions
- Cross-collection relationships
- Curated related content options
- Thumbnail display

**Implementation:**
- Create related content component
- Implement tag-based relationship queries
- Add to all detail templates

## 18. Internal Search Functionality

Improve site search capability:

**Features:**
- Full-text search
- Filter by content type
- Sort by relevance/date
- Search result highlighting
- Search analytics

**Implementation:**
- Configure Statamic's search indexing
- Create search results template
- Add search form to main navigation
- Implement advanced filters

## 19. Allies Section Update

Enhance the presentation of partner organizations:

**Features:**
- Improved partner profiles
- Logo gallery
- Category filtering
- Partnership inquiry form
- Interactive map of partners

**Implementation:**
- Create allies collection and blueprint
- Design templates for partner showcase
- Add contact form for inquiries

## 20. Expanded Publication Author Fields

Add more comprehensive author information:

**Features:**
- Multiple authors per publication
- Author bios and photos
- Role/contribution indication
- Links to other works by same author

**Implementation:**
- Enhance publication blueprint with author fields
- Create author grid or relationship field
- Update templates to display full author information

## 21. Downloadable Materials Repository

Create dedicated section for downloadable resources:

**Features:**
- Categorized downloads
- File type indication
- Preview images
- Download tracking
- Optional lead capture

**Implementation:**
- Create materials collection and blueprint
- Design listing and detail templates
- Implement download tracking
- Add optional lead capture for high-value materials

## 22. Enhanced Maps for Allies and Initiatives

Add interactive map functionality:

**Features:**
- Location-based display of programs and allies
- Filtering by program type or year
- Custom map markers
- Info popups
- Mobile-friendly interaction

**Implementation:**
- Add location fields to relevant collections
- Create map component with Leaflet or Google Maps
- Design popup templates
- Implement filtering controls 