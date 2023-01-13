<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTrailerRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Movie;


class TrailerController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrailerRequest $request)
    {
        $movie = Movie::find($request->movieId);

        if($request->hasFile('poster')) {
            $fileName = $request->poster->getClientOriginalName();

            $poster = $movie->trailer_poster;
            if($poster) {
                Storage::disk('public')->delete($poster);
            }
            $path = $request->file('poster')->storeAs('images/trailers/posters', $movie->id . '-' . $fileName, 'public');
            $movie->trailer_poster = $path;
        }

        if($request->hasFile('trailer')) {
            $fileName = $request->trailer->getClientOriginalName();

            $trailer = $movie->trailer;
            if($trailer) {
                Storage::disk('public')->delete($trailer);
            }
            $path = $request->file('trailer')->storeAs('images/trailers/posters', $movie->id . '-' . $fileName, 'public');
            $movie->trailer = $path;
        }

        $movie->update();

        return redirect()->route('admin.movies.edit', $movie->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
