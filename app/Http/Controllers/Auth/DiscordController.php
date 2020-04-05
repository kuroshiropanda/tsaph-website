<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;

class DiscordController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('discord')->stateless()->user();

        // $id = $user->getId();
        // $username = $user->user['login'];
        // $avatar = $user->avatar;
        // $email = $user->getEmail();

        // $questions = \App\Question::all();
        // $types = \App\Type::all();

        // $member = \App\Member::find($id);
        // $applicant = \App\Applicant::where('twitch_id', $id)->first();

        $token = $user->token;

        return redirect()->route('applicant.create')->with('token', $token);
    }
}
