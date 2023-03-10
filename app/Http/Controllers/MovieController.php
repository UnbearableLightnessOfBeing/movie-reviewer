<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($search, $searchGenre, $searchActor)
    {
        return Movie::
                    query()
                    ->when($search, function($query, $search) {
                        $query->where('title', 'like', "%{$search}%");
                    })
                    ->get()->load('genres', 'actors')
                    ->filter(function($movie) use ($searchGenre) {
                        if(!$searchGenre) {
                            return true;
                        }
                        $genres = $movie->genres;
                        $count = count($genres->where('title', $searchGenre));
                        return $count;
                    })
                    ->filter(function($movie) use ($searchActor) {
                        if(!$searchActor) {
                            return true;
                        }
                        $actors = $movie->actors;
                        $count = count($actors->where('name', $searchActor));
                        return $count;
                    })
                    ->map(function($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'duration' => $movie->duration,
                'description' => $movie->description,
                'releaseDate' => $movie->release_date,
                'production' => $movie->production,
                'poster' => $movie->poster,
                'trailerPoster' => $movie->trailer_poster,
                'trailer' => $movie->trailer,
                'restriction' => $movie->restriction,
                'countries' => $movie->countries->map(function($country) {
                    return $country->title;
                }),
                'actors' => $movie->actors->map(function($actor) {
                    return $actor->name;
                }),
                'genres' => $movie->genres->map(function($genre) {
                    return $genre->title;
                }),
                'rating' => $movie->getAvgRating(),
                'isFavorite' => UserController::movieIsFavorite($movie->id),
            ];
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMoviesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovieRequest $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public static function show($id)
    {

        $movie = Movie::find($id); 

        // find user rating
        $userRating = null;
        if(Auth::user()) {
            $userRating = $movie->ratings->where('movie_id', $movie->id)
            ->where('user_id', Auth::user()->id)->map(function($rating) {
                return [
                    'id' => $rating->id,
                    'rating' => $rating->rating,
                ];
            })->first(); 
        }

        // calculate movie rating
        $rating = $movie->getAvgRating();

        return [
            'id' => $movie->id,
            'title' => $movie->title,
            'duration' => $movie->duration,
            'description' => $movie->description,
            'releaseDate' => $movie->release_date,
            'production' => $movie->production,
            'poster' => $movie->poster,
            'trailerPoster' => $movie->trailer_poster,
            'trailer' => $movie->trailer,
            'restriction' => $movie->restriction,
            'countries' => $movie->countries->map(function($country) {
                return $country->title;
            }),
            'actors' => $movie->actors->map(function($actor) {
                return $actor->name;
            }),
            'genres' => $movie->genres->map(function($genre) {
                return $genre->title;
            }),
            'rating' => $rating,
            'ratingCount' => $movie->ratings->count(),
            'userRating' => $userRating,
            'favoriteCount' => $movie->getFavoriteCount(),
            'commentCount' => $movie->getCommentCount(),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMoviesRequest  $request
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovieRequest $request, Movie $movies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movies)
    {
        //
    }
}
