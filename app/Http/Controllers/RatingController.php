<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Movie;
use App\Models\User;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreRatingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRatingRequest $request)
    {
        $movieId = $request->input('movieId');

        // the condition checks if the user has already rated the movie
        if(count(User::find($request->user()->id)->ratings->where('movie_id', $movieId)) === 0) {
            $ratingRecord = new Rating();
            $ratingRecord->fill($request->validated());
            $ratingRecord->movie()->associate(Movie::find($movieId));
            $ratingRecord->user()->associate(User::find($request->user()->id));
            $ratingRecord->save();
        }

        return redirect(route('movie.show', ['id' => $movieId]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRatingRequest  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $movieId = $rating->movie->id;

        $validated = $request->validated();

        $rating->update($validated);

        return redirect(route('movie.show', ['id' => $movieId]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
