<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Genus;
use App\Models\Kingdom;
use App\Models\Phylum;
use App\Models\Species;
use App\Models\TaxonomicClass;
use App\Models\TaxonomicOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggest(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json([]);
        }

        $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $query) . '%';

        $results = [];

        $push = static function (string $type, string $name, string $slug, string $url) use (&$results): void {
            $results[] = [
                'type' => $type,
                'name' => $name,
                'slug' => $slug,
                'url' => $url,
            ];
        };

        Kingdom::query()
            ->select(['name', 'slug'])
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('slug', 'like', $like);
            })
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->each(fn ($row) => $push('Reino', $row->name, $row->slug, url("/reinos/{$row->slug}")));

        Phylum::query()
            ->select(['name', 'slug'])
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('slug', 'like', $like);
            })
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->each(fn ($row) => $push('Filo', $row->name, $row->slug, url("/filos/{$row->slug}")));

        TaxonomicClass::query()
            ->select(['name', 'slug'])
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('slug', 'like', $like);
            })
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->each(fn ($row) => $push('Classe', $row->name, $row->slug, url("/classes/{$row->slug}")));

        TaxonomicOrder::query()
            ->select(['name', 'slug'])
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('slug', 'like', $like);
            })
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->each(fn ($row) => $push('Ordem', $row->name, $row->slug, url("/ordens/{$row->slug}")));

        Family::query()
            ->select(['name', 'slug'])
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('slug', 'like', $like);
            })
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->each(fn ($row) => $push('Família', $row->name, $row->slug, url("/familias/{$row->slug}")));

        Genus::query()
            ->select(['name', 'slug'])
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('slug', 'like', $like);
            })
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->each(fn ($row) => $push('Gênero', $row->name, $row->slug, url("/generos/{$row->slug}")));

        Species::query()
            ->select(['name', 'slug'])
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('slug', 'like', $like);
            })
            ->orderBy('name')
            ->limit(8)
            ->get()
            ->each(fn ($row) => $push('Espécie', $row->name, $row->slug, url("/especies/{$row->slug}")));

        // Ordena levemente: começa com match mais “curto” no nome.
        usort($results, function (array $a, array $b) {
            return strlen($a['name']) <=> strlen($b['name']);
        });

        return response()->json(array_values(array_slice($results, 0, 20)));
    }
}
