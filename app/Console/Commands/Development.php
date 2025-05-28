<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OpenLibraryService;

class Development extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'development:test';

    /**
     * This command is used for development purposes and initializations.
     *
     * @var string
     */
    protected $description = 'Development purposes and initializations.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categories = \App\Models\Category::all();
        foreach($categories as $category){
            $category->delete();
        }
        // $service = new OpenLibraryService();
        // $service->fetchCategories();
    }
}
