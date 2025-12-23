<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genus extends Model
{
    use HasFactory;

    protected $table = 'genera';

    protected $fillable = [
        'name',
        'slug',
        'scientific_name',
        'description',
        'hero_video_filename',
        'family_id',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function species()
    {
        return $this->hasMany(Species::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
