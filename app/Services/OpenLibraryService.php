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
            $response = $this->client->get("subjects/{$category}.json");
            $data = json_decode($response->getBody(), true);
            $works = $data["works"] ?? [];
    
            $searchWords = preg_split('/\s+/', strtolower($title)); // Split the input title into words
            $matchedTitles = [];
    
            foreach ($works as $work) {
                if (!isset($work['title'], $work['subject'])) {
                    continue;
                }
    
                // Check if the subject list includes the category
                $subjects = strtolower(implode(" ", $work["subject"]));
                if (!str_contains($subjects, strtolower($category))) {
                    continue;
                }
    
                // Now check if the book title contains at least one word from the search
                $bookTitle = strtolower($work['title']);
                foreach ($searchWords as $word) {
                    \Log::debug("check ".$word." in ".$bookTitle);
                    if (str_contains($bookTitle, $word)) {
                        $authorNames = [];
                        foreach($work['authors'] as $authorData){
                            $authorNames[] = $authorData['name'];
                        }
                        $authors = implode(",",$authorNames);
                        $matchedTitles[] = ["title"=>$work['title'],"authors"=>$authors];
                        break; // Only need one match
                    }
                }
            }
    
            \Log::debug("Filtered Titles: " . json_encode($matchedTitles));
            return $matchedTitles;
    
        } catch (RequestException $e) {
            \Log::error("Failed to fetch books in category {$category}: " . $e->getMessage());
            return [];
        }
    }
    
    
}
