<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    public function current(Request $request, WeatherService $weather)
    {
        $validated = $request->validate([
            'city' => 'required|string'
        ]);

        $data = $weather->getCurrentWeather($validated['city']);

        return $data ? response()->json($data) : response()->json([
            'error' => 'City not found'
        ], 404);
    }

    public function forecast(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string'
        ]);

        // $data = $weather

        return "This returns the forecast";
    }
}
