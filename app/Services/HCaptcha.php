<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HCaptcha
{
    public function verify($token)
    {
        $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret' => config('services.hcaptcha.secret'),
            'response' => $token
        ]);

        return $response->json();
    }
}
