<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Movie;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Country;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->query('perPage') ?? 5;

        $movies = Movie::query()
                        ->when($request->input('search'), function($query, $search) {
                            $query->where('title', 'like', "%{$search}%");
                        })
                        ->with('genres', 'actors', 'countries')
                        ->paginate($perPage)
                        ->withQueryString();
        
        $movieRatings = Movie::all()->map(function ($movie) {
            // calculate movie rating
            $numerator = $movie->ratings->reduce(function($cv, $rating) {
                    return $cv + $rating->rating;
                });
            $denominator = $movie->ratings->count(); 

            if($denominator === 0) {
                $rating = null;
            }
            else {
                $rating = $numerator / $denominator;
            }
            return [
                'movieId' => $movie->id,
                'avg' => $rating,
                'count' => $denominator, 
            ];
        });

        return Inertia::render('Admin/Movies/Index', [
            'filters' => $request->only(['search', 'perPage']),
            'movies' => $movies,
            'movieRatings' => $movieRatings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Movies/Create', [
            'actors' => Actor::all('id', 'name'),
            'genres' => Genre::all('id', 'title'),
            'countries' => Country::all('id', 'title'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovieRequest $request)
    {
        $movie = new Movie();
        $movie->fill($request->validated());
        $movie->save();

        if(count($request->actorValues)) {
            foreach ($request->actorValues as $actor) {
                $movie->actors()->attach($actor['id']);
            }
        }

        if(count($request->genreValues)) {
            foreach ($request->genreValues as $genre) {
                $movie->genres()->attach($genre['id']);
            }
        }

        if(count($request->countryValues)) {
            foreach ($request->countryValues as $country) {
                $movie->countries()->attach($country['id']);
            }
        }
        
        return redirect(route('admin.movies.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Admin/Movies/Edit', [
            'movie' => Movie::find($id)->load('genres:id,title', 'countries:id,title', 'actors:id,name'),
            'actors' => Actor::all('id', 'name'),
            'genres' => Genre::all('id', 'title'),
            'countries' => Country::all('id', 'title'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovieRequest $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required', Rule::unique('movies')->ignore(Movie::find($id)->id, 'id'), 'max:100'],
        ], [
            'required' => 'Поле необходимо заполнить',
            'unique' => 'Такой Фильм уже добавлен',
        ]);

        $merged = array_merge($request->validated(), $validated);


        $movie = Movie::find($id);
        $movie->fill($merged);
        $movie->update();

        if(count($request->actorValues)) {
            $movie->actors()->sync([]);
            foreach ($request->actorValues as $actor) {
                $movie->actors()->attach($actor['id']);
            }
        }
        else {
            $movie->actors()->sync([]);
        }

        if(count($request->genreValues)) {
            $movie->genres()->sync([]);
            foreach ($request->genreValues as $genre) {
                $movie->genres()->attach($genre['id']);
            }
        }
        else {
            $movie->genres()->sync([]);
        }

        if(count($request->countryValues)) {
            $movie->countries()->sync([]);
            foreach ($request->countryValues as $country) {
                $movie->countries()->attach($country['id']);
            }
        }
        else {
            $movie->countries()->sync([]);
        }

        return redirect()->route('admin.movies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id)->delete();

        return redirect()->route('admin.movies.index');
    }
}
