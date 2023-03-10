<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AvatarUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AvatarController extends Controller
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AvatarUpdateRequest $request): RedirectResponse
    {
        $user = User::find($request->input('userId'));
        if($request->hasFile('avatar')) {
            $imageName = $request->avatar->getClientOriginalName();
            $mimeType = $request->avatar->getClientMimeType();

            if(explode('/', $mimeType)[1] === 'png'
            || explode('/', $mimeType)[1] === 'jpeg'
            ) 
            {
                $avatar = $user->avatar;
                if($avatar) {
                    Storage::disk('public')->delete($avatar);
                }
                $path = $request->file('avatar')->storeAs('images/avatars', $user->id . '-' . $imageName, 'public');
                $user->avatar = $path;
            }
        }

        $user->update();

        return Redirect::route('admin.users.edit', $user->id);

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
