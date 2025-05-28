<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

class FavoritesController extends Controller
{
    public function get()
    {
        $books = Book::with('authors')->get();
        return response()->json($books);
    }


    public function add_to_favorites(Request $request){
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|array|min:1',
            'authors.*' => 'string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'string|max:255',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
        ]);

        $authorIds = [];
        foreach ($validated['authors'] as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $authorIds[] = $author->id;
        }
        $book->authors()->attach($authorIds);

        if (!empty($validated['categories'])) {
            $existingCategoryIds = Category::whereIn('name', $validated['categories'])->pluck('id')->toArray();
            if (!empty($existingCategoryIds)) {
                $book->categories()->attach($existingCategoryIds);
            }
        }

        return response()->json(['message' => 'Book and relations saved successfully'], 201);
    }
}
