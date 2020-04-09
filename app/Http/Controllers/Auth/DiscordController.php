<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Applicant;
use DB;

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
            $cookie = $request->cookie('applicant');
            $applicant = Applicant::find($cookie);

            DB::transaction(function () use ($applicant) {
                foreach ($applicant->answers as $ans) {
                    $ans->delete();
                }

                $applicant->answers()->detach();
                $applicant->types()->detach();

                $applicant->delete();
            });

            return redirect()->route('home');
        }

        $user = Socialite::driver('discord')->stateless()->user();

        // dd($user);

        $id = $user->getId();
        $username = $user->getNickname();
        $avatar = $user->getAvatar();
        $email = $user->getEmail();

        $token = $user->token;

        $cookie = $request->cookie('applicant');

        $app = \App\Applicant::find($cookie);

        $app->discord = $username;

        $app->save();

        $app->discord()->create([
            'discord_id' => $id,
            'avatar' => $avatar,
            'username' => $username,
            'email' => $email,
            'token' => $token
        ]);

        return redirect()->route('interview');
    }
}
