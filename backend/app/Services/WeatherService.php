<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService {
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct() {
        $this->apiKey = config('services.openweather.key');
        $this->baseUrl = 'https://api.openweathermap.org/data/2.5/';
    }

    public function getCurrentWeather(string $city) : array|null
    {
        $cacheKey = "weather:current:" . strtolower($city);

        return Cache::remember($cacheKey, now()->addMinutes(10), function() use($city){
            $response = Http::get($this->baseUrl . 'weather', [
                'q' => $city,
                'appId' => $this->apiKey,
                'units' => 'metric'
            ]);

            if($response->successful()){
                return $response->json();
            }

            return null;
        });
    }

    public function getForecastWeather(string $city) : array|null
    {
        $cacheKey = 'weather:forecast:' . strtolower($city);

        return Cache::remember($cacheKey, now()->addHour(), function() use($city){
            $response = Http::get($this->baseUrl . 'forecast', [
                'q' => $city,
                'appId' => $this->apiKey,
                'units' => 'metric'
            ]);

            if($response->successful()){
                return $response->json();
            }

            return null;
        });
    }
}