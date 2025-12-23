<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TaxonomyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'home'])->name('home');

Route::get('/reinos', [LandingPageController::class, 'kingdoms'])->name('kingdoms.index');
Route::get('/reinos/{kingdom:slug}', [LandingPageController::class, 'showKingdom'])->name('kingdoms.show');

Route::get('/filos', [LandingPageController::class, 'phylums'])->name('phylums.index');
Route::get('/filos/{phylum:slug}', [LandingPageController::class, 'showPhylum'])->name('phylums.show');

Route::get('/classes', [LandingPageController::class, 'classes'])->name('classes.index');
Route::get('/classes/{class:slug}', [LandingPageController::class, 'showClass'])->name('classes.show');

Route::get('/ordens', [LandingPageController::class, 'orders'])->name('orders.index');
Route::get('/ordens/{order:slug}', [LandingPageController::class, 'showOrder'])->name('orders.show');

Route::get('/familias', [LandingPageController::class, 'families'])->name('families.index');
Route::get('/familias/{family:slug}', [LandingPageController::class, 'showFamily'])->name('families.show');

Route::get('/generos', [LandingPageController::class, 'genera'])->name('genera.index');
Route::get('/generos/{genus:slug}', [LandingPageController::class, 'showGenus'])->name('genera.show');

Route::get('/especies', [LandingPageController::class, 'species'])->name('species.index');
Route::get('/especies/{species:slug}', [LandingPageController::class, 'showSpecies'])->name('species.show');

Route::get('/animais', [LandingPageController::class, 'animals'])->name('animals.index');
Route::get('/animais/{animal:slug}', [LandingPageController::class, 'showAnimal'])->name('animals.show');

Route::prefix('dados')->name('data.')->group(function () {
    Route::get('/taxonomia', [TaxonomyController::class, 'tree'])->name('taxonomy');
    Route::get('/busca', [SearchController::class, 'suggest'])->name('search');
    Route::get('/animais/{animal:slug}', [AnimalController::class, 'show'])->name('animals.show');
});
