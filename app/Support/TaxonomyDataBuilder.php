<?php

namespace App\Support;

use App\Models\Animal;
use App\Models\Family;
use App\Models\Genus;
use App\Models\Kingdom;
use App\Models\Phylum;
use App\Models\Species;
use App\Models\TaxonomicClass;
use App\Models\TaxonomicOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TaxonomyDataBuilder
{
    public function buildTaxonomyTree(): array
    {
        return Kingdom::query()
            ->select(['id', 'name', 'slug', 'scientific_name', 'hero_image_url', 'hero_video_filename', 'description'])
            ->with([
                'phylums:id,name,slug,scientific_name,description,hero_video_filename,kingdom_id',
                'phylums.taxonomicClasses:id,name,slug,scientific_name,description,hero_video_filename,phylum_id',
                'phylums.taxonomicClasses.taxonomicOrders:id,name,slug,scientific_name,description,hero_video_filename,class_id',
                'phylums.taxonomicClasses.taxonomicOrders.families:id,name,slug,scientific_name,description,hero_video_filename,order_id',
                'phylums.taxonomicClasses.taxonomicOrders.families.genera:id,name,slug,scientific_name,description,hero_video_filename,family_id',
                'phylums.taxonomicClasses.taxonomicOrders.families.genera.species:id,name,slug,scientific_name,description,hero_video_filename,genus_id',
                'phylums.taxonomicClasses.taxonomicOrders.families.genera.species.animals:id,name,slug,scientific_name,featured_image_url,conservation_status,species_id',
            ])
            ->orderBy('name')
            ->get()
            ->map(function (Kingdom $kingdom) {
                return [
                    'id' => $kingdom->id,
                    'name' => $kingdom->name,
                    'slug' => $kingdom->slug,
                    'scientific_name' => $kingdom->scientific_name,
                    'hero_image_url' => $kingdom->hero_image_url,
                    'hero_video_filename' => $kingdom->hero_video_filename,
                    'description' => $kingdom->description,
                    'phylums' => $kingdom->phylums->map(function (Phylum $phylum) {
                        return [
                            'id' => $phylum->id,
                            'name' => $phylum->name,
                            'slug' => $phylum->slug,
                            'scientific_name' => $phylum->scientific_name,
                            'description' => $phylum->description,
                            'hero_video_filename' => $phylum->hero_video_filename,
                            'classes' => $phylum->taxonomicClasses->map(function (TaxonomicClass $class) {
                                return [
                                    'id' => $class->id,
                                    'name' => $class->name,
                                    'slug' => $class->slug,
                                    'scientific_name' => $class->scientific_name,
                                    'description' => $class->description,
                                    'hero_video_filename' => $class->hero_video_filename,
                                    'orders' => $class->taxonomicOrders->map(function (TaxonomicOrder $order) {
                                        return [
                                            'id' => $order->id,
                                            'name' => $order->name,
                                            'slug' => $order->slug,
                                            'scientific_name' => $order->scientific_name,
                                            'description' => $order->description,
                                            'hero_video_filename' => $order->hero_video_filename,
                                            'families' => $order->families->map(function (Family $family) {
                                                return [
                                                    'id' => $family->id,
                                                    'name' => $family->name,
                                                    'slug' => $family->slug,
                                                    'scientific_name' => $family->scientific_name,
                                                    'description' => $family->description,
                                                    'hero_video_filename' => $family->hero_video_filename,
                                                    'genera' => $family->genera->map(function (Genus $genus) {
                                                        return [
                                                            'id' => $genus->id,
                                                            'name' => $genus->name,
                                                            'slug' => $genus->slug,
                                                            'scientific_name' => $genus->scientific_name,
                                                            'description' => $genus->description,
                                                            'hero_video_filename' => $genus->hero_video_filename,
                                                            'species' => $genus->species->map(function (Species $species) {
                                                                return [
                                                                    'id' => $species->id,
                                                                    'name' => $species->name,
                                                                    'slug' => $species->slug,
                                                                    'scientific_name' => $species->scientific_name,
                                                                    'description' => $species->description,
                                                                    'hero_video_filename' => $species->hero_video_filename,
                                                                    'animals' => $species->animals->map(function (Animal $animal) {
                                                                        return [
                                                                            'id' => $animal->id,
                                                                            'name' => $animal->name,
                                                                            'slug' => $animal->slug,
                                                                            'scientific_name' => $animal->scientific_name,
                                                                            'featured_image_url' => $animal->featured_image_url,
                                                                            'conservation_status' => $animal->conservation_status,
                                                                        ];
                                                                    })->values(),
                                                                ];
                                                            })->values(),
                                                        ];
                                                    })->values(),
                                                ];
                                            })->values(),
                                        ];
                                    })->values(),
                                ];
                            })->values(),
                        ];
                    })->values(),
                ];
            })
            ->values()
            ->toArray();
    }

    public function buildFeaturedAnimals(?Model $focus = null, int $limit = 9): array
    {
        $query = Animal::query()
            ->select([
                'id',
                'name',
                'slug',
                'scientific_name',
                'featured_image_url',
                'conservation_status',
                'habitat',
                'temperament',
                'life_expectancy_years',
                'average_size_meters',
                'average_weight_kilograms',
                'species_id',
            ])
            ->with([
                'species:id,name,slug,scientific_name,genus_id',
                'species.genus:id,name,slug,family_id',
                'species.genus.family:id,name,slug,order_id',
                'species.genus.family.taxonomicOrder:id,name,slug,class_id',
                'species.genus.family.taxonomicOrder.taxonomicClass:id,name,slug,phylum_id',
                'species.genus.family.taxonomicOrder.taxonomicClass.phylum:id,name,slug,kingdom_id',
                'species.genus.family.taxonomicOrder.taxonomicClass.phylum.kingdom:id,name,slug',
            ])
            ->orderBy('name');

        $this->applyFocusFilter($query, $focus);

        $animals = $query->limit($limit)->get();

        if ($focus instanceof Animal && $animals->isEmpty()) {
            $animals = collect([$focus->loadMissing([
                'species:id,name,slug,scientific_name,genus_id',
                'species.genus:id,name,slug,family_id',
                'species.genus.family:id,name,slug,order_id',
                'species.genus.family.taxonomicOrder:id,name,slug,class_id',
                'species.genus.family.taxonomicOrder.taxonomicClass:id,name,slug,phylum_id',
                'species.genus.family.taxonomicOrder.taxonomicClass.phylum:id,name,slug,kingdom_id',
                'species.genus.family.taxonomicOrder.taxonomicClass.phylum.kingdom:id,name,slug',
            ])]);
        }

        return $animals
            ->map(function (Animal $animal) {
                $species = $animal->species;
                $genus = $species?->genus;
                $family = $genus?->family;
                $order = $family?->taxonomicOrder;
                $class = $order?->taxonomicClass;
                $phylum = $class?->phylum;
                $kingdom = $phylum?->kingdom;

                return [
                    'id' => $animal->id,
                    'name' => $animal->name,
                    'slug' => $animal->slug,
                    'scientific_name' => $animal->scientific_name,
                    'featured_image_url' => $animal->featured_image_url,
                    'conservation_status' => $animal->conservation_status,
                    'habitat' => $animal->habitat,
                    'temperament' => $animal->temperament,
                    'life_expectancy_years' => $animal->life_expectancy_years,
                    'average_size_meters' => $animal->average_size_meters,
                    'average_weight_kilograms' => $animal->average_weight_kilograms,
                    'classification' => [
                        'species' => $species?->only(['id', 'name', 'slug', 'scientific_name']),
                        'genus' => $genus?->only(['id', 'name', 'slug']),
                        'family' => $family?->only(['id', 'name', 'slug']),
                        'order' => $order?->only(['id', 'name', 'slug']),
                        'class' => $class?->only(['id', 'name', 'slug']),
                        'phylum' => $phylum?->only(['id', 'name', 'slug']),
                        'kingdom' => $kingdom?->only(['id', 'name', 'slug']),
                    ],
                ];
            })
            ->values()
            ->toArray();
    }

    private function applyFocusFilter(Builder $query, ?Model $focus): void
    {
        if (! $focus) {
            return;
        }

        if ($focus instanceof Animal) {
            $query->whereKey($focus->getKey());
            return;
        }

        if ($focus instanceof Species) {
            $query->where('species_id', $focus->getKey());
            return;
        }

        if ($focus instanceof Genus) {
            $query->whereHas('species.genus', function (Builder $builder) use ($focus) {
                $builder->whereKey($focus->getKey());
            });
            return;
        }

        if ($focus instanceof Family) {
            $query->whereHas('species.genus.family', function (Builder $builder) use ($focus) {
                $builder->whereKey($focus->getKey());
            });
            return;
        }

        if ($focus instanceof TaxonomicOrder) {
            $query->whereHas('species.genus.family.taxonomicOrder', function (Builder $builder) use ($focus) {
                $builder->whereKey($focus->getKey());
            });
            return;
        }

        if ($focus instanceof TaxonomicClass) {
            $query->whereHas('species.genus.family.taxonomicOrder.taxonomicClass', function (Builder $builder) use ($focus) {
                $builder->whereKey($focus->getKey());
            });
            return;
        }

        if ($focus instanceof Phylum) {
            $query->whereHas('species.genus.family.taxonomicOrder.taxonomicClass.phylum', function (Builder $builder) use ($focus) {
                $builder->whereKey($focus->getKey());
            });
            return;
        }

        if ($focus instanceof Kingdom) {
            $query->whereHas('species.genus.family.taxonomicOrder.taxonomicClass.phylum.kingdom', function (Builder $builder) use ($focus) {
                $builder->whereKey($focus->getKey());
            });
        }
    }

    public function formatAnimal(Animal $animal): array
    {
        return $this->buildFeaturedAnimals($animal, 1)[0] ?? [];
    }
}
