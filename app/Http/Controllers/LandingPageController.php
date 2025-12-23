<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Family;
use App\Models\Genus;
use App\Models\Kingdom;
use App\Models\Phylum;
use App\Models\Species;
use App\Models\TaxonomicClass;
use App\Models\TaxonomicOrder;
use App\Support\TaxonomyDataBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function __construct(private readonly TaxonomyDataBuilder $builder)
    {
    }

    public function home(): View
    {
        return $this->renderPage('home', null);
    }

    public function kingdoms(): View
    {
        return $this->renderPage('kingdoms', null);
    }

    public function showKingdom(Kingdom $kingdom): View
    {
        return $this->renderPage('kingdoms', $kingdom);
    }

    public function phylums(): View
    {
        return $this->renderPage('phylums', null);
    }

    public function showPhylum(Phylum $phylum): View
    {
        return $this->renderPage('phylums', $phylum);
    }

    public function classes(): View
    {
        return $this->renderPage('classes', null);
    }

    public function showClass(TaxonomicClass $class): View
    {
        return $this->renderPage('classes', $class);
    }

    public function orders(): View
    {
        return $this->renderPage('orders', null);
    }

    public function showOrder(TaxonomicOrder $order): View
    {
        return $this->renderPage('orders', $order);
    }

    public function families(): View
    {
        return $this->renderPage('families', null);
    }

    public function showFamily(Family $family): View
    {
        return $this->renderPage('families', $family);
    }

    public function genera(): View
    {
        return $this->renderPage('genera', null);
    }

    public function showGenus(Genus $genus): View
    {
        return $this->renderPage('genera', $genus);
    }

    public function species(): View
    {
        return $this->renderPage('species', null);
    }

    public function showSpecies(Species $species): View
    {
        $species->loadMissing([
            'genus:id,name,slug,scientific_name,description,hero_video_filename,family_id',
            'genus.family:id,name,slug,scientific_name,description,hero_video_filename,order_id',
            'genus.family.taxonomicOrder:id,name,slug,scientific_name,description,hero_video_filename,class_id',
            'genus.family.taxonomicOrder.taxonomicClass:id,name,slug,scientific_name,description,hero_video_filename,phylum_id',
            'genus.family.taxonomicOrder.taxonomicClass.phylum:id,name,slug,scientific_name,description,hero_video_filename,kingdom_id',
            'genus.family.taxonomicOrder.taxonomicClass.phylum.kingdom:id,name,slug,scientific_name,description,hero_image_url,hero_video_filename',
            'animals:id,name,slug,scientific_name,featured_image_url,conservation_status,species_id',
        ]);

        $genus = $species->genus;
        $family = $genus?->family;
        $order = $family?->taxonomicOrder;
        $class = $order?->taxonomicClass;
        $phylum = $class?->phylum;
        $kingdom = $phylum?->kingdom;

        $focusData = [
            'id' => $species->getKey(),
            'name' => $species->name,
            'slug' => $species->slug,
            'scientific_name' => $species->scientific_name,
            'description' => $species->description,
            'hero_video_filename' => $species->hero_video_filename,
            'classification' => [
                'kingdom' => $kingdom?->only(['id', 'name', 'slug', 'scientific_name', 'hero_video_filename', 'hero_image_url']),
                'phylum' => $phylum?->only(['id', 'name', 'slug', 'scientific_name', 'hero_video_filename']),
                'class' => $class?->only(['id', 'name', 'slug', 'scientific_name', 'hero_video_filename']),
                'order' => $order?->only(['id', 'name', 'slug', 'scientific_name', 'hero_video_filename']),
                'family' => $family?->only(['id', 'name', 'slug', 'scientific_name', 'hero_video_filename']),
                'genus' => $genus?->only(['id', 'name', 'slug', 'scientific_name', 'hero_video_filename']),
                'species' => $species->only(['id', 'name', 'slug', 'scientific_name', 'hero_video_filename']),
            ],
            'animals' => $species->animals
                ->map(fn (Animal $animal) => $animal->only(['id', 'name', 'slug', 'scientific_name', 'featured_image_url', 'conservation_status']))
                ->values()
                ->toArray(),
        ];

        return $this->renderPage('species', $species, $focusData);
    }

    public function animals(): View
    {
        return $this->renderPage('animals', null);
    }

    public function showAnimal(Animal $animal): View
    {
        return $this->renderPage('animals', $animal);
    }

    protected function renderPage(string $section, ?Model $focus, ?array $focusData = null): View
    {
        return view('welcome', [
            'pageContext' => [
                'section' => $section,
                'focus' => $focus ? [
                    'id' => $focus->getKey(),
                    'name' => $focus->name,
                    'slug' => $focus->slug,
                    'type' => class_basename($focus),
                    'data' => $focusData,
                ] : null,
            ],
            'taxonomyTree' => $this->builder->buildTaxonomyTree(),
            'featuredAnimals' => $this->builder->buildFeaturedAnimals($focus),
        ]);
    }
}
