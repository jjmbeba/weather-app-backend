<?php

namespace App\Http\Controllers;

use App\Services\SearchCityService;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function search(Request $request, SearchCityService $search) {
        $validated = $request->validate([
            'city' => 'required|string',
        ]);

        $data = $search->searchByCity($validated['city']);

        return $data ? response()->json($data) : response()->json([
            'error' => 'City not found'
        ]);
    }

    public function current(Request $request, WeatherService $weather)
    {
        $validated = $this->validateParams($request);

        $city = $validated['city'];
        $units = $validated['units'] ?? 'metric';

        $data = $weather->getCurrentWeather($city, $units);

        return $data ? response()->json($data) : response()->json([
            'error' => 'City not found'
        ], 404);
    }

    public function forecast(Request $request, WeatherService $weather)
    {
        $validated = $this->validateParams($request);

        $city = $validated['city'];
        $units = $validated['units'] ?? 'metric';

        $data = $weather->getForecastWeather($city, $units);

        return $data ? response()->json($data) : response()->json([
            'error' => 'City not found'
        ], 404);
    }

    public function validateParams(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string',
            'units' => 'nullable|string|in:metric,imperial,standard'
        ]);

        return $validated;
    }
}
