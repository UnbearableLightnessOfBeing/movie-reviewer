<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
       'title', 
       'duration', 
       'description', 
       'release_date', 
       'production', 
       'poster', 
       'trailer_poster', 
       'trailer', 
       'restriction', 
    ];

    public function countries() {
        return $this->belongsToMany(Country::class, 'movie_country');
    }

    public function actors() {
        return $this->belongsToMany(Actor::class, 'movie_actor');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function comments() {
        return $this->hasMany(Commetn::class);
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function updateAttachment(String $relationship, Array $ids) {
        if(count($ids)) {
            $this->$relationship()->attach($ids);
        }
        else {
            $this->$relationship()->sync([]);
        }
    }
}
