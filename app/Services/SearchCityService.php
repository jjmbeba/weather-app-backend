<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SearchCityService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
        $this->baseUrl = 'https://api.openweathermap.org/geo/1.0/direct';
    }

    public function searchByCity(string $q)
    {
        $response = Http::get($this->baseUrl, [
            'q' => $q,
            'appId' => $this->apiKey
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
