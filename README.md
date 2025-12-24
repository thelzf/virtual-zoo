# Virtual Zoo Project

Welcome. Choose your preferred language to read the [documentation](docs/)


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

## Testing

Execute the application test suite:
```bash
php artisan test
```

## License

Distributed under the MIT License. See LICENSE for details.
