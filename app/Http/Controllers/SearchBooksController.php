<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\OpenLibraryService;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

class SearchBooksController extends Controller
{

    public function do_search(Request $request,$category,$title){
        $split = explode(" ",$title);
        $title = implode("+",$split);
        $service = new OpenLibraryService();
        $results = $service->searchBooksByTitleInCategory($title,$category);
        \Log::debug($results);
        return response()->json(['titles'=>$results]);
    }

}
