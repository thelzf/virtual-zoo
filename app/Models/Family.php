<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'scientific_name',
        'description',
        'hero_video_filename',
        'order_id',
    ];

    public function taxonomicOrder()
    {
        return $this->belongsTo(TaxonomicOrder::class, 'order_id');
    }

    public function genera()
    {
        return $this->hasMany(Genus::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
