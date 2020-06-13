<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
// use GuzzleHttp\Client;
use App\Services\TwitchToken;

class TwitchApi
{
    protected $token;

    public function __construct(TwitchToken $token)
    {
        $this->token = $token;
    }

    public function getKraken($path)
    {
        $kraken = Http::withHeaders([
            'Client-ID' => config('services.twitch.client_id'),
            'Accept' => 'application/vnd.twitchtv.v5+json'
        ])->get("https://api.twitch.tv/kraken/{$path}");
        // $client = new Client([
        //     'base_uri' => 'https://api.twitch.tv/kraken/',
        //     'headers' => [
        //         'Client-ID' => config('services.twitch.client_id'),
        //         'Accept' => 'application/vnd.twitchtv.v5+json'
        //     ]
        // ]);

        // $response = $client->request('GET', $path);
        // $body = (string) $response->getBody();
        // $data = json_decode($body);

        return $kraken->json();
    }

    public function get($path, array $options)
    {
        $app = $this->token->token();

        $helix = Http::withToken($app['access_token'])
            ->withHeaders([
                'Client-ID' => config('services.twitch.client_id')
            ])->get("https://api.twitch.tv/helix/{$path}", $options);

        // $client = new Client([
        //     'base_uri' => 'https://api.twitch.tv/helix/',
        //     'headers' => [
        //         'Authorization' => 'Bearer '.$app->access_token,
        //         'Client-ID' => config('services.twitch.client_id')
        //     ]
        // ]);

        // $response = $client->request('GET', $path, $options);
        // $body = (string) $response->getBody();
        // $data = json_decode($body);

        return $helix->json();
    }
}
