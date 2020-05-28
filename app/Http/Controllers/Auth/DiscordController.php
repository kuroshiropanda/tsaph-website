<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Applicant;
use Exception;

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
        try {
            $user = Socialite::driver('discord')->stateless()->user();

            $twitchToken = (string) $request->cookie('token');
            $twitch = Socialite::driver('twitch')->userFromToken($twitchToken);
        } catch(Exception $e) {
            return redirect()->route('home');
        }

        $token = $user->token;

        $cookie = cookie('discord', $token, 60);

        $applicant = Applicant::where('twitch_id', $twitch->getId())->first();

        if(!empty($applicant)) {
            if(empty($applicant->discordData)) {
                $applicant->discordData()->create([
                        'discord_id' => $user->getId(),
                        'avatar' => $user->getAvatar(),
                        'username' => $user->getNickname(),
                        'email' => $user->getEmail(),
                        'token' => $token
                ]);
            }
        }

        return redirect()->route('applicant.create')->cookie($cookie);
    }
}
