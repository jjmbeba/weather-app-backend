<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function current() {
        return "This returns the current weather";
    }

    public function forecast() {
        return "This returns the forecast";
    }
}
