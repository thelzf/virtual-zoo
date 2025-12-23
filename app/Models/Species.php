<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'scientific_name',
        'description',
        'hero_video_filename',
        'genus_id',
    ];

    public function genus()
    {
        return $this->belongsTo(Genus::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
