<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;

class DiscordController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('discord')
            ->scopes(['guilds', 'guilds.join'])
            ->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        if(!$request->has('code'))
        {
            return redirect()->route('home');
        }

        $user = Socialite::driver('discord')->stateless()->user();

        $token = $user->token;

        $cookie = cookie('discord', $token, 60);

        return redirect()->route('applicant.create')->cookie($cookie);
    }
}
