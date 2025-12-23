<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Family;
use App\Models\Genus;
use App\Models\Kingdom;
use App\Models\Phylum;
use App\Models\Species;
use App\Models\TaxonomicClass;
use App\Models\TaxonomicOrder;
use Illuminate\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    public function run(): void
    {
        $kingdomSeeds = [
            [
                'slug' => 'animalia',
                'name' => 'Animalia',
                'scientific_name' => 'Animalia',
                'hero_image_url' => 'https://images.unsplash.com/photo-1533119408463-b0f487583ff6?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'animalia.mp4',
                'description' => 'Reino que reúne organismos multicelulares heterotróficos conhecidos como animais.',
            ],
            [
                'slug' => 'plantae',
                'name' => 'Plantae',
                'scientific_name' => 'Plantae',
                'hero_image_url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'plantae.mp4',
                'description' => 'Reino com organismos predominantemente fotossintetizantes (plantas).',
            ],
            [
                'slug' => 'fungi',
                'name' => 'Fungi',
                'scientific_name' => 'Fungi',
                'hero_image_url' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'fungi.mp4',
                'description' => 'Reino de fungos, incluindo leveduras, bolores e cogumelos.',
            ],
            [
                'slug' => 'protista',
                'name' => 'Protista',
                'scientific_name' => 'Protista',
                'hero_image_url' => 'https://images.unsplash.com/photo-1528825871115-3581a5387919?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'protista.mp4',
                'description' => 'Grupo diverso de eucariotos, geralmente unicelulares.',
            ],
            [
                'slug' => 'bacteria',
                'name' => 'Bacteria',
                'scientific_name' => 'Bacteria',
                'hero_image_url' => 'https://images.unsplash.com/photo-1583912268181-92c1d3a00f2c?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'bacteria.mp4',
                'description' => 'Organismos procariontes amplamente distribuídos no planeta.',
            ],
            [
                'slug' => 'archaea',
                'name' => 'Archaea',
                'scientific_name' => 'Archaea',
                'hero_image_url' => 'https://images.unsplash.com/photo-1528823872057-9c018a7d07e3?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'archaea.mp4',
                'description' => 'Procariontes com características distintas, incluindo muitos extremófilos.',
            ],
            [
                'slug' => 'chromista',
                'name' => 'Chromista',
                'scientific_name' => 'Chromista',
                'hero_image_url' => 'https://images.unsplash.com/photo-1505761671935-60b3a7427bad?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'chromista.mp4',
                'description' => 'Grupo usado em algumas classificações para certos eucariotos, incluindo algas.',
            ],
            [
                'slug' => 'animalia-2',
                'name' => 'Animalia (Experimentos)',
                'scientific_name' => null,
                'hero_image_url' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'animalia_experimentos.mp4',
                'description' => 'Reino fictício para variações visuais e testes do storyboard.',
            ],
            [
                'slug' => 'mythica',
                'name' => 'Mythica',
                'scientific_name' => null,
                'hero_image_url' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'mythica.mp4',
                'description' => 'Reino fictício (dados de exemplo) para enriquecer as animações.',
            ],
            [
                'slug' => 'aquatica',
                'name' => 'Aquatica',
                'scientific_name' => null,
                'hero_image_url' => 'https://images.unsplash.com/photo-1473116763249-2faaef81ccda?auto=format&fit=crop&w=1600&q=80',
                'hero_video_filename' => 'aquatica.mp4',
                'description' => 'Reino fictício (dados de exemplo) com foco em biomas aquáticos.',
            ],
        ];

        $kingdoms = [];
        foreach ($kingdomSeeds as $seed) {
            $kingdoms[$seed['slug']] = Kingdom::query()->updateOrCreate(
                ['slug' => $seed['slug']],
                [
                    'name' => $seed['name'],
                    'scientific_name' => $seed['scientific_name'],
                    'hero_image_url' => $seed['hero_image_url'],
                    'hero_video_filename' => $seed['hero_video_filename'],
                    'description' => $seed['description'],
                ]
            );
        }

        $kingdom = $kingdoms['animalia'];

        $phylumSeeds = [
            ['slug' => 'chordata', 'name' => 'Chordata', 'scientific_name' => 'Chordata', 'description' => 'Animais que apresentam notocorda em algum estágio do desenvolvimento.'],
            ['slug' => 'arthropoda', 'name' => 'Arthropoda', 'scientific_name' => 'Arthropoda', 'description' => 'Invertebrados com exoesqueleto e apêndices articulados.'],
            ['slug' => 'mollusca', 'name' => 'Mollusca', 'scientific_name' => 'Mollusca', 'description' => 'Grupo diverso com corpos moles, muitas vezes com concha.'],
            ['slug' => 'annelida', 'name' => 'Annelida', 'scientific_name' => 'Annelida', 'description' => 'Vermes segmentados, como minhocas e sanguessugas.'],
            ['slug' => 'cnidaria', 'name' => 'Cnidaria', 'scientific_name' => 'Cnidaria', 'description' => 'Animais aquáticos como águas-vivas e corais, com cnidócitos.'],
            ['slug' => 'echinodermata', 'name' => 'Echinodermata', 'scientific_name' => 'Echinodermata', 'description' => 'Invertebrados marinhos como estrelas-do-mar.'],
            ['slug' => 'porifera', 'name' => 'Porifera', 'scientific_name' => 'Porifera', 'description' => 'Esponjas, organismos filtradores sem tecidos verdadeiros.'],
            ['slug' => 'platyhelminthes', 'name' => 'Platyhelminthes', 'scientific_name' => 'Platyhelminthes', 'description' => 'Vermes achatados, muitos parasitas.'],
            ['slug' => 'nematoda', 'name' => 'Nematoda', 'scientific_name' => 'Nematoda', 'description' => 'Vermes cilíndricos, comuns em ambientes diversos.'],
            ['slug' => 'bryozoa', 'name' => 'Bryozoa', 'scientific_name' => 'Bryozoa', 'description' => 'Animais aquáticos coloniais, também chamados ectoproctos.'],
        ];

        $phylums = [];
        foreach ($phylumSeeds as $seed) {
            $phylums[$seed['slug']] = Phylum::query()->updateOrCreate(
                ['slug' => $seed['slug']],
                [
                    'name' => $seed['name'],
                    'scientific_name' => $seed['scientific_name'],
                    'description' => $seed['description'],
                    'hero_video_filename' => $seed['hero_video_filename'] ?? ($seed['slug'] . '.mp4'),
                    'kingdom_id' => $kingdom->id,
                ]
            );
        }

        $phylum = $phylums['chordata'];

        $class = TaxonomicClass::query()->updateOrCreate(
            ['slug' => 'mammalia'],
            [
                'name' => 'Mammalia',
                'scientific_name' => 'Mammalia',
                'description' => 'Mamíferos, geralmente com pelos e glândulas mamárias.',
                'hero_video_filename' => 'mammalia.mp4',
                'phylum_id' => $phylum->id,
            ]
        );

        $order = TaxonomicOrder::query()->updateOrCreate(
            ['slug' => 'carnivora'],
            [
                'name' => 'Carnivora',
                'scientific_name' => 'Carnivora',
                'description' => 'Mamíferos com adaptações para dieta carnívora (com variações).',
                'hero_video_filename' => 'carnivora.mp4',
                'class_id' => $class->id,
            ]
        );

        $family = Family::query()->updateOrCreate(
            ['slug' => 'felidae'],
            [
                'name' => 'Felidae',
                'scientific_name' => 'Felidae',
                'description' => 'Família dos felinos (gatos) incluindo grandes felinos.',
                'hero_video_filename' => 'felidae.mp4',
                'order_id' => $order->id,
            ]
        );

        $genus = Genus::query()->updateOrCreate(
            ['slug' => 'panthera'],
            [
                'name' => 'Panthera',
                'scientific_name' => 'Panthera',
                'description' => 'Gênero que inclui alguns dos grandes felinos.',
                'hero_video_filename' => 'panthera.mp4',
                'family_id' => $family->id,
            ]
        );

        $species = Species::query()->updateOrCreate(
            ['slug' => 'panthera-leo'],
            [
                'name' => 'Leão',
                'scientific_name' => 'Panthera leo',
                'description' => 'Grande felino social encontrado principalmente em savanas africanas.',
                'hero_video_filename' => 'panthera-leo.mp4',
                'genus_id' => $genus->id,
            ]
        );

        Animal::query()->firstOrCreate(
            ['slug' => 'leao'],
            [
                'species_id' => $species->id,
                'name' => 'Leão',
                'scientific_name' => 'Panthera leo',
                'featured_image_url' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=1600&q=80',
                'conservation_status' => 'Vulnerável',
                'habitat' => 'Savanas e pastagens',
                'temperament' => 'Social',
                'life_expectancy_years' => 14,
                'average_weight_kilograms' => 190,
                'description' => 'Conhecido como o “rei da selva”, vive em grupos chamados de alcateias (bandos).',
            ]
        );

        // Mais alguns animais/espécies para enriquecer o storyboard (sem criar milhares de registros).
        $speciesTiger = Species::query()->updateOrCreate(
            ['slug' => 'panthera-tigris'],
            [
                'name' => 'Tigre',
                'scientific_name' => 'Panthera tigris',
                'description' => 'Grande felino solitário, nativo da Ásia.',
                'hero_video_filename' => 'panthera-tigris.mp4',
                'genus_id' => $genus->id,
            ]
        );

        Animal::query()->firstOrCreate(
            ['slug' => 'tigre'],
            [
                'species_id' => $speciesTiger->id,
                'name' => 'Tigre',
                'scientific_name' => 'Panthera tigris',
                'featured_image_url' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=1600&q=80',
                'conservation_status' => 'Ameaçado',
                'habitat' => 'Florestas e savanas',
                'temperament' => 'Solitário',
                'life_expectancy_years' => 12,
                'average_weight_kilograms' => 220,
                'description' => 'Conhecido por sua força e listras características.',
            ]
        );
    }
}