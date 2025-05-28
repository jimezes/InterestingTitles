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
        //fetch the categories here, just the first time
        if (Category::count() === 0) {
            try {
                set_time_limit(0); // No time limit

                $service = new OpenLibraryService();
                $service->initializeCategories();
            } catch (\Throwable $e) {
                \Log::error('Category fetch failed: ' . $e->getMessage());
                abort(500, 'Could not fetch categories.');
            }
        }
    }
}
