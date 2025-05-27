<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\OpenLibraryService;

class SearchBooksController extends Controller
{
    public function search(Request $request,$category){
        return Inertia::render('SearchBooks',['category'=>$category]);
    }

    public function do_search(Request $request,$category,$title){
        \Log::debug("will search in category: ".$category." for title = ".$title);
        $split = explode(" ",$title);
        $title = implode("+",$split);
        $service = new OpenLibraryService();
        $results = $service->searchBooksByTitleInCategory($title,$category);
        \Log::debug($results);
        return response()->json(['titles'=>$results]);
    }
}
