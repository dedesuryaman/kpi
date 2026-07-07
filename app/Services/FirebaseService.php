<?php

namespace App\Services;

use Google\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected function accessToken()
    {
        Log::error('Firebase', [
            'credentials' => config('services.firebase.credentials'),
            'project_id' => config('services.firebase.project_id')
        ]);

        $client = new Client();
        $client->setAuthConfig(config('services.firebase.credentials'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        return $client->fetchAccessTokenWithAssertion()['access_token'];
    }

    public function sendToToken($token, $title, $body, $data = [])
    {
        return Http::withToken($this->accessToken())
            ->post(
                'https://fcm.googleapis.com/v1/projects/' .
                    config('services.firebase.project_id') .
                    '/messages:send',
                [
                    "message" => [
                        "token" => $token,
                        "notification" => [
                            "title" => $title,
                            "body" => $body
                        ],
                        "data" => $data
                    ]
                ]
            )->json();
    }
}
