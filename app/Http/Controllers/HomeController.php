<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
  public function index()
  {
    // Get current weather data
    $weatherData = [
      'temperature' => '28',
      'humidity' => '75',
      'windSpeed' => '15',
      'location' => 'Bandung'
    ];

    // SEO metadata
    $metadata = [
      'title' => 'SKYSense - Your Gateway to Real-Time Weather Insights',
      'description' => 'Monitor, analyze, and understand local weather conditions with ease. Powered by cutting-edge IoT technology.'
    ];

    return view('home', compact('weatherData', 'metadata'));
  }
}
