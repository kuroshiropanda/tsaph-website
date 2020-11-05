<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Throwable;

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
        try {
            $user = Socialite::driver('twitch')->stateless()->user();
        } catch (Throwable $e) {
            return redirect()->route('home');
        }

        $cookie = cookie('token', $user->token, (60 * 24));

        return redirect()->route('discord.auth')->cookie($cookie);
    }
}
