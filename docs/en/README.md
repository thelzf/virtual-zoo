# Virtual Zoo Project

![Laravel](https://img.shields.io/badge/Laravel-10%2B-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

## Overview

Virtual Zoo is an educational Laravel application that centralizes animal data, taxonomy, habitats, and conservation details. The project serves as a structured learning companion for students, teachers, and wildlife enthusiasts.

## Key Features

- Complete biological taxonomy hierarchy (kingdom to species)
- Detailed animal profiles including habitat, diet, behavior, and conservation status
- Interactive browsing with filtering and comparison tools
- Media galleries and curated educational facts
- Database seeding for a ready-to-explore catalog

## Requirements

- PHP 8.1 or newer
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js and npm
- Git

## Quick Start

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/virtual-zoo.git
   cd virtual-zoo
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install frontend dependencies and build assets:
   ```bash
   npm install
   npm run build
   ```
4. Configure environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update the new .env file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=virtual_zoo
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. Run database migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
6. Create the storage symlink:
   ```bash
   php artisan storage:link
   ```
7. Launch the development server:
   ```bash
   php artisan serve
   ```
   Visit http://localhost:8000 to explore the app.

## Project Structure

- app/Http/Controllers: HTTP controllers powering features
- app/Models: Eloquent models for taxonomy and animals
- database/migrations: Tables for taxonomy, animals, and support entities
- database/seeders: Seeders that populate the taxonomy tree
- resources/views: Blade templates for the user interface
- resources/js, resources/css: Frontend assets managed by Vite

## Main Tables

- kingdoms: Biological kingdoms (Animalia, Plantae, etc.)
- phyla: Major animal phyla
- classes: Biological classes
- orders: Taxonomic orders
- families: Biological families
- genera: Genus classifications
- species: Detailed species information
- animals: Individual animal records
- habitats: Environmental information
- conservation_statuses: IUCN categories

## Relationships

- Each species belongs to a genus
- Each genus belongs to a family
- Each family belongs to an order
- Each order belongs to a class
- Each class belongs to a phylum
- Each phylum belongs to a kingdom

## API Endpoints

### Public API Routes

```text
GET    /api/animals              - List all animals
GET    /api/animals/{id}         - Show specific animal
GET    /api/species              - List all species
GET    /api/species/{id}         - Show specific species
GET    /api/habitats             - List all habitats
GET    /api/classification-tree  - Get complete taxonomy tree
GET    /api/search?q={query}     - Search animals and species
```

### Admin API Routes (Protected)

```text
POST   /api/admin/animals        - Create new animal record
PUT    /api/admin/animals/{id}   - Update animal record
DELETE /api/admin/animals/{id}   - Delete animal record
POST   /api/admin/species        - Create new species
POST   /api/admin/upload-media   - Upload images and media
```

## Project Structure (Detailed)

```text
virtual-zoo/
├── app/
│   ├── Models/
│   │   ├── Animal.php
│   │   ├── Species.php
│   │   ├── Kingdom.php
│   │   ├── Phylum.php
│   │   ├── TaxonomicClass.php
│   │   ├── TaxonomicOrder.php
│   │   ├── Family.php
│   │   ├── Genus.php
│   │   └── Habitat.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AnimalController.php
│   │   │   ├── SpeciesController.php
│   │   │   └── TaxonomyController.php
│   │   └── Resources/
│   │       └── AnimalResource.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── TaxonomySeeder.php
│       ├── AnimalSeeder.php
│       └── SpeciesSeeder.php
├── resources/
│   ├── views/
│   │   ├── animals/
│   │   ├── species/
│   │   └── taxonomy/
│   └── js/
└── public/
   ├── images/
   │   ├── animals/
   │   └── habitats/
   └── storage/
```

## Frontend Features

### User Interface Components

- Responsive design for a mobile-friendly interface
- Interactive filters by kingdom, phylum, class, habitat
- Advanced search by name, characteristics, location
- Virtual tours to explore habitats and ecosystems
- Comparison tool to analyze animals side by side
- Educational quizzes to reinforce learning

### Visualization Tools

- Distribution maps with interactive geography
- Timeline view for lifespans and evolutionary milestones
- Size comparison visuals with everyday objects
- Family tree diagrams for biological relationships

## Development

### Running Tests

```bash
php artisan test
```

### Seeding Sample Data

```bash
php artisan db:seed
```

### Creating New Taxonomy Data

```bash
php artisan make:model Phylum -mcr
```

### Clearing Cache

```bash
php artisan optimize:clear
```

## Sample Data Included

- 5 biological kingdoms
- 35+ animal phyla
- 100+ animal classes
- 500+ animal species
- 50+ habitat types
- 1000+ animal records with detailed information

## Security Features

- CSRF protection
- XSS prevention
- SQL injection mitigation
- Secure authentication system
- API rate limiting
- Input validation and sanitization
- Secure file upload handling

## Performance Optimization

- Database indexing
- Query caching
- Image optimization
- Lazy loading
- API response caching
- Asset compression
- CDN-ready structure

## Contributing

We welcome contributions to Virtual Zoo! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a pull request

## Support

For support, email support@virtualzoo.com or join our Slack channel.

## Acknowledgments

- Laravel framework
- Biological taxonomy data from scientific sources
- Animal conservation organizations
- Educational institutions that provided research materials

> "In the end, we will conserve only what we love, we will love only what we understand, and we will understand only what we are taught." — Baba Dioum

## Testing

Execute the application test suite:
```bash
php artisan test
```

## License

Distributed under the MIT License. See LICENSE for details.
