<?php

namespace App\Services;

use GuzzleHttp\Client;

class HCaptcha
{
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://hcaptcha.com/'
        ]);
    }

    public function verify($token)
    {
        $verify = $this->client->request('POST', 'siteverify', [
            'query' => [
                'secret' => config('services.hcaptcha.secret'),
                'response' => $token,
            ]
        ]);

        $body = (string) $verify->getBody();
        $response = json_decode($body);

        return $response;
    }
}
