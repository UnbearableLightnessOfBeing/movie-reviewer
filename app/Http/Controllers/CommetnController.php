<?php

namespace App\Http\Controllers;

use App\Models\Commetn;
use App\Models\Movie;
use App\Models\User;
use App\Http\Requests\StoreCommetnRequest;
use App\Http\Requests\UpdateCommetnRequest;
use Illuminate\Support\Facades\Log;

class CommetnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($movieId)
    {
        return Commetn::with('user:id,name,avatar')->latest()->get()->where('movie_id', $movieId);
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
     * @param  \App\Http\Requests\StoreCommetnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommetnRequest $request)
    {
        $movieId = $request->input('movieId');
        $movie = Movie::find($movieId);

        // dd(User::find($request->user()->id), Movie::find($movieId));

        $comment = new Commetn();
        $comment->fill($request->validated());
        $comment->movie()->associate($movie);
        $comment->user()->associate(User::find($request->user()->id));
        $comment->save();

        Log::channel('db')->info('Пользователь ' . $request->user()->name . 
        ' оставил комментарий к фильму ' . $movie->title . '.', [
            'user' => $request->user(),
            'movie' => $movie,
            'comment' => $comment,
        ]);

        return redirect(route('movie.show', ['id' => $movieId]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commetn  $commetn
     * @return \Illuminate\Http\Response
     */
    public function show(Commetn $commetn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commetn  $commetn
     * @return \Illuminate\Http\Response
     */
    public function edit(Commetn $commetn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommetnRequest  $request
     * @param  \App\Models\Commetn  $commetn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommetnRequest $request, Commetn $comment)
    {
        $this->authorize('update', $comment);

        $movieId = $comment->movie->id;
        $movie = Movie::find($movieId);

        $validated = $request->validated();

        $comment->update($validated);

        Log::channel('db')->info('Пользователь ' . $request->user()->name . 
        ' редактировал комментарий к фильму ' . $movie->title . '.', [
            'user' => $request->user(),
            'movie' => $movie,
            'comment' => $comment,
        ]);

        return redirect(route('movie.show', ['id' => $movieId]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commetn  $commetn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commetn $comment)
    {
        $this->authorize('delete', $comment);
        
        $movieId = $comment->movie->id;

        $comment->delete();

        return redirect(route('movie.show', ['id' => $movieId]));
    }
}
