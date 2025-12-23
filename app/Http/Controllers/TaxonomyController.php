<?php

namespace App\Http\Controllers;

use App\Support\TaxonomyDataBuilder;
use Illuminate\Http\JsonResponse;

class TaxonomyController extends Controller
{
    public function __construct(private readonly TaxonomyDataBuilder $builder)
    {
    }

    public function tree(): JsonResponse
    {
        return response()->json([
            'data' => $this->builder->buildTaxonomyTree(),
        ]);
    }
}
