<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use Inertia\Inertia;

use App\Http\Controllers\SearchBooksController;
use App\Http\Controllers\FavoritesController;



Route::get('/',function(){
    $categories = Category::all();
    return Inertia::render('Categories',['categories'=>$categories]);
});

Route::get('/search/{category}', [SearchBooksController::class, 'search'])->name('search.books');
Route::post('/search/{category}/{title}', [SearchBooksController::class, 'do_search'])->name('search');
Route::post('/favorites',[FavoritesController::class,'add_to_favorites'])->name('favorites.add');
Route::get('/favorites/data',[FavoritesController::class,'get'])->name('favorites');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
