<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;

class TwitchApplicationController extends Controller
{
    /**
     * Redirect the user to the Twitch authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitch')
            ->with(['force_verify' => 'true'])
            ->redirect();
    }

    /**
     * Obtain the user information from Twitch.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        if(!$request->has('code'))
        {
            return redirect()->route('home');
        }

        $user = Socialite::driver('twitch')->stateless()->user();

        return redirect()->route('applicant.create')->cookie('token', $user->token, 60);
    }
}
