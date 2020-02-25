<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Socialite;
use Illuminate\Support\Facades\DB;

class TwitchApplicationController extends Controller
{
    /**
     * Redirect the user to the Twitch authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitch')->redirect();
    }

    /**
     * Obtain the user information from Twitch.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('twitch')->stateless()->user();

        $id = $user->getId();
        $username = $user->user['login'];
        $avatar = $user->avatar;
        $email = $user->getEmail();

        $questions = \App\Question::all();
        $types = \App\Type::all();

        $member = \App\Member::find($id);
        $applicant = \App\Applicant::where('twitch_id', $id)->first();

        if($member)
        {
            return view('application', [
                'type' => 'member',
                'alert' => 'member ka na tanga'
            ]);
        }
        elseif($applicant)
        {
            return view('application', [
                'type' => 'applicant',
                'alert' => 'nag apply ka na. chill ka lang. wak bobo'
            ]);
        }
        else
        {
            return view('apply', [
                'id' => $id,
                'avatar' => $avatar,
                'username' => $username,
                'email' => $email,
                'questions' => $questions,
                'types' => $types
            ]);
        }
    }
}
