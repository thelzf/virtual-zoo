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

## Tabelas Principais

- kingdoms: Reinos biológicos (Animalia, Plantae etc.)
- phyla: Principais filos animais
- classes: Classes biológicas
- orders: Ordens taxonômicas
- families: Famílias biológicas
- genera: Classificações de gêneros
- species: Informações detalhadas sobre espécies
- animals: Registros individuais de animais
- habitats: Informações sobre ambientes
- conservation_statuses: Categorias da IUCN

## Relacionamentos

- Cada espécie pertence a um gênero
- Cada gênero pertence a uma família
- Cada família pertence a uma ordem
- Cada ordem pertence a uma classe
- Cada classe pertence a um filo
- Cada filo pertence a um reino

## Endpoints da API

### Rotas Públicas

```text
GET    /api/animals              - Lista todos os animais
GET    /api/animals/{id}         - Exibe um animal específico
GET    /api/species              - Lista todas as espécies
GET    /api/species/{id}         - Exibe uma espécie específica
GET    /api/habitats             - Lista todos os habitats
GET    /api/classification-tree  - Retorna a árvore taxonômica completa
GET    /api/search?q={query}     - Pesquisa animais e espécies
```

### Rotas Administrativas (Protegidas)

```text
POST   /api/admin/animals        - Cria um novo registro de animal
PUT    /api/admin/animals/{id}   - Atualiza um registro de animal
DELETE /api/admin/animals/{id}   - Remove um registro de animal
POST   /api/admin/species        - Cria uma nova espécie
POST   /api/admin/upload-media   - Envia imagens e mídias
```

## Estrutura do Projeto (Detalhada)

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

## Recursos do Frontend

### Componentes da Interface

- Design responsivo para dispositivos móveis
- Filtros interativos por reino, filo, classe e habitat
- Busca avançada por nome, características e localização
- Tours virtuais para explorar habitats e ecossistemas
- Ferramenta de comparação para analisar animais lado a lado
- Questionários educativos para reforçar o aprendizado

### Ferramentas de Visualização

- Mapas de distribuição com geografia interativa
- Linha do tempo para ciclos de vida e evolução
- Comparação de tamanho com objetos cotidianos
- Árvores genealógicas para relações biológicas

## Desenvolvimento

### Executando Testes

```bash
php artisan test
```

### Popular dados de exemplo

```bash
php artisan db:seed
```

### Criar nova estrutura taxonômica

```bash
php artisan make:model Phylum -mcr
```

### Limpar cache

```bash
php artisan optimize:clear
```

## Dados de Exemplo Incluídos

- 5 reinos biológicos
- Mais de 35 filos
- Mais de 100 classes
- Mais de 500 espécies
- Mais de 50 tipos de habitat
- Mais de 1000 registros de animais com detalhes completos

## Recursos de Segurança

- Proteção CSRF
- Prevenção contra XSS
- Mitigação de injeção de SQL
- Sistema de autenticação seguro
- Rate limiting para a API
- Validação e sanitização de entradas
- Tratamento seguro de upload de arquivos

## Otimizações de Performance

- Indexação de banco de dados
- Cache de consultas
- Otimização de imagens
- Lazy loading
- Cache de respostas da API
- Compressão de assets
- Estrutura pronta para CDN

## Contribuindo

Contribuições são bem-vindas! Siga estes passos:

1. Faça o fork do repositório
2. Crie um branch de feature (`git checkout -b feature/AmazingFeature`)
3. Faça o commit das alterações (`git commit -m 'Add some AmazingFeature'`)
4. Faça o push para o branch (`git push origin feature/AmazingFeature`)
5. Abra um pull request

## Suporte

Para suporte, envie um e-mail para support@virtualzoo.com ou participe do nosso canal no Slack.

## Agradecimentos

- Framework Laravel
- Bases científicas de taxonomia
- Organizações de conservação animal
- Instituições de ensino que forneceram materiais de pesquisa

> "No fim, nós conservaremos apenas o que amarmos, amaremos apenas o que compreendermos e compreenderemos apenas o que nos for ensinado." — Baba Dioum

## Testes

Execute a suíte de testes:
```bash
php artisan test
```

## Licença

Distribuído sob a licença MIT. Consulte LICENSE para mais detalhes.
