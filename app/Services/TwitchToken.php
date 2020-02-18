<?php

namespace App\Services;

use GuzzleHttp\Client;

class TwitchToken
{
    public function token()
    {
        $oauth = new Client();

        $res = $oauth->request('POST', 'https://id.twitch.tv/oauth2/token', [
            'query' => [
                'client_id' => config('services.twitch.client_id'),
                'client_secret' => config('services.twitch.client_secret'),
                'grant_type' => 'client_credentials'
            ]
        ]);

        $app = (string) $res->getBody();
        $auth = json_decode($app);

        return $auth;
    }
}
