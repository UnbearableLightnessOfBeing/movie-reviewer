<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function storeInFavorite(Request $request) {

        // dd($request->movieId, $request->user()->favoriteMovies);

        $movie = Movie::find($request->movieId);
        $request->user()->favoriteMovies()->attach($movie);
        return redirect(route('movie.show', ['id' => $movie->id]));
    }

    public function deleteFromFavorite(Request $request) {

        $movie = Movie::find($request->movieId);
        $request->user()->favoriteMovies()->detach($movie);
        return redirect(route('movie.show', ['id' => $movie->id]));
    }

    public static function movieIsFavorite($movieId) {
        $user = Auth::user();

        if($user) {
            $favoriteMovie = Auth::user()->favoriteMovies()->where('movie_id', $movieId)->first();

            return $favoriteMovie? true : false;
        }
        else {
            return null;
        }
    }
}
