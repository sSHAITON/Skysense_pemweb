<?php

namespace App\Http\Controllers;

use App\Http\Controllers\WeatherController;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
  protected $weatherController;
  protected $database;

  public function __construct(WeatherController $weatherController)
  {
    $this->weatherController = $weatherController;

    $factory = (new Factory)
      ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS_PATH')))
      ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

    $this->database = $factory->createDatabase();
  }

  public function index()
  {
    // SEO metadata
    $metadata = [
      'title' => 'SKYSense - Your Gateway to Real-Time Weather Insights',
      'description' => 'Monitor, analyze, and understand local weather conditions with ease. Powered by cutting-edge IoT technology.'
    ];

    return view('home', compact('metadata'));
  }

  // New public function for home page weather data
  public function getPublicWeatherData()
  {
    try {
      $reference = $this->database->getReference("uid=2/deviceid=2A/latest_reading");
      $snapshot = $reference->getSnapshot();
      $data = $snapshot->getValue();

      if (!$data) {
        return response()->json([
          'temperature' => 0,
          'humidity' => 0,
          'wind_speed' => 0
        ]);
      }

      return response()->json([
        'temperature' => $data['temperature'] ?? 0,
        'humidity' => $data['humidity'] ?? 0,
        'wind_speed' => $data['windSpeed_kmph'] ?? 0
      ]);
    } catch (\Exception $e) {
      Log::error('Firebase error:', ['error' => $e->getMessage()]);
      return response()->json([
        'temperature' => 0,
        'humidity' => 0,
        'wind_speed' => 0
      ]);
    }
  }
}
