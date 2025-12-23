<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Support\TaxonomyDataBuilder;
use Illuminate\Http\JsonResponse;

class AnimalController extends Controller
{
    public function __construct(private readonly TaxonomyDataBuilder $builder)
    {
    }

    public function show(Animal $animal): JsonResponse
    {
        return response()->json([
            'data' => $this->builder->formatAnimal($animal),
        ]);
    }
}
