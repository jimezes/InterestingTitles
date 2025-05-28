<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Category;

class OpenLibraryService
{
    protected Client $client;

    // used some popular book categories
    protected array $popularCategories = [
        'science_fiction',
        'fantasy',
        'romance',
        'mystery_and_detective_stories',
        'historical_fiction',
        'children',
        'young_adult_fiction',
        'horror',
        'biography',
        'adventure',
        'history',
        'philosophy',
        'poetry',
        'comics',
        'art',
        'religion',
        'travel',
        'science',
        'music',
        'psychology',
        'self_help',
    ];

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://openlibrary.org/',
            'headers' => [
                'User-Agent' => 'MyLaravelApp/1.0',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Initialize static categories
     */
    public function initializeCategories(){
          foreach ($this->popularCategories as $subject) {
            $category = new Category();
            $category->name = $subject;
            $category->save();
          }
    }

    /**
     * Fetch popular categories (subjects)
     *
     * @return array
     */
    public function fetchCategories(): array
    {
        $categories = [];

        foreach ($this->popularCategories as $subject) {
            try {
                $response = $this->client->get("subjects/{$subject}.json");
                $data = json_decode($response->getBody(), true);
                //dd($data['name']);
                if(isset($data['name'])){
                    $category = new Category();
                    $category->name = $data['name'];
                    $category->save();
                }
            } catch (RequestException $e) {
                \Log::error("Failed to fetch subject {$subject}: " . $e->getMessage());
            }
            sleep(2); //sleep to avoid blacklisting
        }

        return $categories;
    }

    /**
     * Fetch book details by Work OLID
     *
     * @param string $workOliD e.g. OL45883W
     * @return array|null
     */
    public function fetchBook(string $workOliD): ?array
    {
        try {
            $response = $this->client->get("works/{$workOliD}.json");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            \Log::error("Failed to fetch book {$workOliD}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch author details by Author OLID
     *
     * @param string $authorOliD e.g. OL12345A
     * @return array|null
     */
    public function fetchAuthor(string $authorOliD): ?array
    {
        try {
            $response = $this->client->get("authors/{$authorOliD}.json");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            \Log::error("Failed to fetch author {$authorOliD}: " . $e->getMessage());
            return null;
        }
    }

    public function searchBooksByTitleInCategory(string $title, string $category): ?array
    {
        try {
            
            $response = $this->client->get("https://openlibrary.org/search.json?title=".$title."&subject=".$category);
            $data = json_decode($response->getBody(), true);
            $works = $data["docs"] ?? [];
            // \Log::debug("works: ");
            // \Log::debug($works);
            $matchedTitles = [];
            foreach($works as $work){
                $matchedTitles[] = ["title"=>$work['title'],"authors"=>$work['author_name'][0]];
            }
            return $matchedTitles;
    
        } catch (RequestException $e) {
            \Log::error("Failed to fetch books in category {$category}: " . $e->getMessage());
            return [];
        }
    }
    
    
}
