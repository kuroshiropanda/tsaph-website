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
        return Socialite::driver('twitch')
            ->with(['force_verify' => 'true'])
            ->redirect();
    }

    /**
     * Obtain the user information from Twitch.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('twitch')->stateless()->user();

        return redirect()->route('applicant.create')->cookie('token', $user->token, 60);
    }
}
