<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Socialite;
use Illuminate\Support\Facades\DB;

class TwitchApplicationController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitch')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('twitch')->user();

        $id = $user->getId();
        $username = $user->user['login'];
        $avatar = $user->avatar;
        $email = $user->getEmail();

        $questions = \App\Question::all();

        $member = \App\Member::find($id);
        $applicant = \App\Applicant::where('twitch_id', $id)->first();

        if($member)
        {
            return view('application', ['alert' => 'member ka na tanga']);
        }
        else if($applicant)
        {
            return view('application', ['alert' => 'nag apply ka na. chill ka lang. wak bobo']);
        }
        else
        {
            return view('apply', [
                'id' => $id,
                'avatar' => $avatar,
                'username' => $username,
                'email' => $email,
                'questions' => $questions
            ]);

            // $applicant = \App\Applicant::where('twitch_id', $id)->doesntHave('answer')->count();
            // $hasAnswer = \App\Applicant::where('twitch_id', $id)->has('answer')->count();

            // if($hasAnswer == 1)
            // {
            //     return 'nag apply ka na. chill ka lang. wak bobo';
            // }
            // else if($applicant == 1)
            // {
            //     $appid = \App\Applicant::where('twitch_id', $id)->first()->id;
            //     return redirect('/apply/'.$appid);
            // }
            // else
            // {
                // $app = \App\Applicant::create([
                //     'twitch_id' => $id,
                //     'username' => $username,
                //     'avatar' => $avatar,
                //     'email' => $email
                // ]);

                // return redirect('/apply/'.$app->id);
                // return view('apply', [
                //     'id' => $id,
                //     'username' => $username,
                //     'email' => $email,
                //     'questions' => $questions
                // ]);
            // }
        }
    }
}
