<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Services\OpenLibraryService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        $categoriesCount = Category::count();
        if($categoriesCount == 0){//fetch categories from API if not fetched and save them to database
             $service = new OpenLibraryService();
             $service->fetchCategories();
        }
    }
}
