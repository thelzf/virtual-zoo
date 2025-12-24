# Projeto Virtual Zoo

![Laravel](https://img.shields.io/badge/Laravel-10%2B-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

## Visão Geral

Virtual Zoo é uma aplicação educacional em Laravel que centraliza dados sobre animais, taxonomia, habitats e informações de conservação. O projeto funciona como um guia estruturado para estudantes, docentes e entusiastas da vida selvagem.

## Principais Recursos

- Hierarquia taxonômica completa (reino a espécie)
- Perfis detalhados com habitat, dieta, comportamento e status de conservação
- Navegação interativa com filtros e ferramentas de comparação
- Galerias de mídia e fatos educativos selecionados
- Seeders que carregam um catálogo pronto para exploração

## Requisitos

- PHP 8.1 ou superior
- Composer
- MySQL 5.7+ ou MariaDB 10.3+
- Node.js e npm
- Git

## Guia Rápido

1. Clone o repositório:
   ```bash
   git clone https://github.com/yourusername/virtual-zoo.git
   cd virtual-zoo
   ```
2. Instale as dependências PHP:
   ```bash
   composer install
   ```
3. Instale as dependências frontend e gere os assets:
   ```bash
   npm install
   npm run build
   ```
4. Configure as variáveis de ambiente:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Atualize o novo arquivo .env com as credenciais do banco:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=virtual_zoo
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. Execute migrations e seeders:
   ```bash
   php artisan migrate --seed
   ```
6. Crie o link simbólico de storage:
   ```bash
   php artisan storage:link
   ```
7. Inicie o servidor de desenvolvimento:
   ```bash
   php artisan serve
   ```
   Acesse http://localhost:8000 para explorar a aplicação.

## Estrutura do Projeto

- app/Http/Controllers: controladores HTTP das funcionalidades
- app/Models: modelos Eloquent para taxonomia e animais
- database/migrations: tabelas de taxonomia, animais e entidades de apoio
- database/seeders: seeders que populam a árvore taxonômica
- resources/views: templates Blade da interface
- resources/js, resources/css: assets frontend gerenciados pelo Vite

## Testes

Execute a suíte de testes:
```bash
php artisan test
```

## Licença

Distribuído sob a licença MIT. Consulte LICENSE para mais detalhes.
