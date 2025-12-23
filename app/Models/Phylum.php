<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phylum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'scientific_name',
        'description',
        'hero_video_filename',
        'kingdom_id',
    ];

    public function kingdom()
    {
        return $this->belongsTo(Kingdom::class);
    }

    public function taxonomicClasses()
    {
        return $this->hasMany(TaxonomicClass::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
