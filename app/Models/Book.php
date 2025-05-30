<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    
    protected $fillable = ['title'];
    
    public function authors() {
        return $this->belongsToMany(Author::class);
    }
    
    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    
}
