<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Movie;

class PosterController extends Controller
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
    public function update(Request $request)
    {
        $movie = Movie::find($request->input('movieId'));
        if($request->hasFile('poster')) {
            $imageName = $request->poster->getClientOriginalName();
            $mimeType = $request->poster->getClientMimeType();

            if(explode('/', $mimeType)[1] === 'png'
            || explode('/', $mimeType)[1] === 'jpeg'
            ) 
            {
                $poster = $movie->poster;
                if($poster) {
                    Storage::disk('public')->delete($poster);
                }
                $path = $request->file('poster')->storeAs('images/posters', $movie->id . '-' . $imageName, 'public');
                $movie->poster = $path;
            }
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
