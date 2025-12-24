# **Virtual Zoo Project**

![Laravel](https://img.shields.io/badge/Laravel-10+-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

## 🌿 **About Virtual Zoo**

Virtual Zoo is an educational web application built with Laravel that provides comprehensive information about animals, their biological classifications, habitats, behaviors, and characteristics. This platform serves as a digital encyclopedia for biology enthusiasts, students, and anyone interested in learning about the animal kingdom.

## ✨ **Features**

### 🐾 **Biological Taxonomy System**
- **Kingdom** - Comprehensive classification of organisms
- **Phylum** - Major taxonomic ranks of animals
- **Class** - Groupings within each phylum
- **Order** - Taxonomic ranks below class
- **Family** - Biological classification grouping
- **Genus** - Closely related species groups
- **Species** - Detailed individual species information

### 🏞️ **Animal Information Dashboard**
- **Habitat Details** - Natural environments and ecosystems
- **Physical Characteristics** - Size, weight, lifespan, appearance
- **Behavioral Traits** - Temperament, social structure, daily routines
- **Diet & Nutrition** - Feeding habits and dietary requirements
- **Conservation Status** - Endangered species information
- **Geographic Distribution** - Native regions and territories

### 📚 **Educational Tools**
- **Interactive Search** - Filter animals by multiple criteria
- **Comparative Analysis** - Compare different species side by side
- **Image Gallery** - High-quality photos and illustrations
- **Educational Facts** - Interesting trivia and scientific information
- **Learning Modules** - Structured educational content

## 🚀 **Installation**

### **Prerequisites**
- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js & NPM
- Git

### **Step-by-Step Setup**

1. **Clone the repository**
  ```bash
  git clone https://github.com/yourusername/virtual-zoo.git
  cd virtual-zoo
  ```

2. **Install PHP dependencies**
  ```bash
  composer install
  ```

3. **Install JavaScript dependencies**
  ```bash
  npm install
  npm run build
  ```

4. **Configure the environment**
  ```bash
  cp .env.example .env
  php artisan key:generate
  ```

  Update the `.env` file with your database credentials:

  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=virtual_zoo
  DB_USERNAME=root
  DB_PASSWORD=
  ```

5. **Run migrations and seeders**
  ```bash
  php artisan migrate --seed
  ```

6. **Generate the storage link**
  ```bash
  php artisan storage:link
  ```

7. **Start the development server**
  ```bash
  php artisan serve
  ```

8. **Access the application**
  Open your browser and navigate to http://localhost:8000.
