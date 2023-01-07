<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvatarUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AvatarController extends Controller
{

    /**
     * Update the user's avatar.
     */
    public function update(AvatarUpdateRequest $request): RedirectResponse
    {
        if($request->hasFile('avatar')) {
            $imageName = $request->avatar->getClientOriginalName();
            $mimeType = $request->avatar->getClientMimeType();

            if(explode('/', $mimeType)[1] === 'png'
            || explode('/', $mimeType)[1] === 'jpeg'
            )  {
                $path = $request->file('avatar')->storeAs('images/avatars', $request->user()->id . '-' . $imageName, 'public');
                $request->user()->avatar = $path;
            }
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }
}