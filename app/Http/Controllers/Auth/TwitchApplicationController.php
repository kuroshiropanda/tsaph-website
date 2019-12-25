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
        $name = $user->getName();
        $email = $user->getEmail();

        // return dd($user);
        $questions = DB::table('questions')->select('id','question','type')->get();

        $check = \App\Member::find($id);
        $applicant = \App\Applicant::find($id);

        if($check)
        {
            return 'already a member';
        }
        else if($applicant)
        {
            return 'already applied';
        }
        else
        {
            return view('apply', [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'questions' => $questions
            ]);
        }
    }
}
