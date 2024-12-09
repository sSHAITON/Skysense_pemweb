<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
  protected $database;

  public function __construct()
  {
    $factory = (new Factory)
      ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS_PATH')))
      ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

    $this->database = $factory->createDatabase();
  }

  public function index()
  {
    $reference = $this->database->getReference('sensor_data');
    $snapshot = $reference->getSnapshot();
    $weatherData = $snapshot->getValue();

    return view('weather', compact('weatherData'));
  }

  public function getData()
  {
    $reference = $this->database->getReference('uid=2/deviceid=2A/latest_reading');
    $snapshot = $reference->getSnapshot();
    $data = $snapshot->getValue();

    // Add logging to debug
    Log::info('Firebase Data:', ['data' => $data]);

    if (!$data) {
      return response()->json([
        'error' => 'No data available'
      ], 404);
    }

    // Transform data to match the expected format
    return response()->json([
      'temperature' => $data['temperature'] ?? 0,
      'humidity' => $data['humidity'] ?? 0,
      'wind_speed' => $data['windSpeed_kmph'] ?? 0,
      'pressure' => $data['pressure_hPa'] ?? 0,
      'altitude' => $data['altitude'] ?? 0,
      'rain_intensity' => $data['rainfall_mm'] ?? 0,
      'uv_index' => $data['uvIndex'] ?? 0,
      'weather_condition' => $data['weatherCondition'] ?? 'Unknown',
      'timestamp' => $data['timestamp'] ?? now()
    ]);
  }

  public function getHistoricalData()
  {
    $reference = $this->database->getReference('uid=2/deviceid=2A/history');
    $snapshot = $reference->getSnapshot();
    $history = $snapshot->getValue();

    if (!$history) {
      return response()->json(['error' => 'No historical data available'], 404);
    }

    // Sort by timestamp and get last 60 readings (1 hour)
    $data = collect($history)
      ->sortBy('timestamp')
      ->take(60)
      ->values();

    return response()->json([
      'labels' => $data->pluck('timestamp')->map(function ($timestamp) {
        return \Carbon\Carbon::parse($timestamp)->format('H:i');
      }),
      'temperature' => $data->pluck('temperature'),
      'humidity' => $data->pluck('humidity'),
      'pressure' => $data->pluck('pressure_hPa'),
      'wind_speed' => $data->pluck('windSpeed_kmph'),
      'rainfall' => $data->pluck('rainfall_mm'),
      'uv_index' => $data->pluck('uvIndex'),
    ]);
  }
}
