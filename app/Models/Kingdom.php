<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kingdom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'scientific_name',
        'hero_image_url',
        'hero_video_filename',
        'description',
    ];

    public function phylums()
    {
        return $this->hasMany(Phylum::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
