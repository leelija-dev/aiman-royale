<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MetaConversionsService
{
    protected string $pixelId;
    protected string $accessToken;

    public function __construct()
    {
        $this->pixelId = config('services.meta.pixel_id');
        $this->accessToken = config('services.meta.access_token');
    }

    /**
     * Send an event to Meta Conversions API.
     */
    public function sendEvent(
        string $eventName,
        array $userData = [],
        array $customData = []
    ): array {

        $url = "https://graph.facebook.com/v23.0/{$this->pixelId}/events";

        $event = [
            'event_name' => $eventName,
            'event_time' => time(),
            'action_source' => 'website',
            'user_data' => $userData,
            'custom_data' => $customData,
        ];

        $response = Http::post($url, [
            'data' => [$event],
            'access_token' => $this->accessToken,
        ]);

        return $response->json();
    }
}
