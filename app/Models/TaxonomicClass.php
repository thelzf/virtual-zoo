<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxonomicClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'slug',
        'scientific_name',
        'description',
        'hero_video_filename',
        'phylum_id',
    ];

    public function phylum()
    {
        return $this->belongsTo(Phylum::class);
    }

    public function taxonomicOrders()
    {
        return $this->hasMany(TaxonomicOrder::class, 'class_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
