<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'species_id',
        'name',
        'slug',
        'scientific_name',
        'alternate_names',
        'habitat',
        'habitat_description',
        'life_expectancy_years',
        'habits',
        'curiosities',
        'temperament',
        'description',
        'average_size_meters',
        'average_weight_kilograms',
        'diet',
        'conservation_status',
        'geographic_distribution',
        'reproduction',
        'social_behavior',
        'featured_image_url',
        'media_gallery',
        'metadata',
    ];

    protected $casts = [
        'alternate_names' => 'array',
        'media_gallery' => 'array',
        'metadata' => 'array',
        'life_expectancy_years' => 'float',
        'average_size_meters' => 'float',
        'average_weight_kilograms' => 'float',
    ];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
