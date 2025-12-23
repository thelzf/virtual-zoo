<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxonomicOrder extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'name',
        'slug',
        'scientific_name',
        'description',
        'hero_video_filename',
        'class_id',
    ];

    public function taxonomicClass()
    {
        return $this->belongsTo(TaxonomicClass::class, 'class_id');
    }

    public function families()
    {
        return $this->hasMany(Family::class, 'order_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
