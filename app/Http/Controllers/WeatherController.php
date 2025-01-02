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
    $device_id = request('device_id', '2A');
    $user_id = request('user_id', '2');

    try {
      $reference = $this->database->getReference("uid={$user_id}/deviceid={$device_id}/latest_reading");
      $snapshot = $reference->getSnapshot();
      $data = $snapshot->getValue();

      Log::info('Firebase Data:', ['data' => $data]);

      if (!$data) {
        return response()->json([
          'error' => "Device {$device_id} is not available or not sending data"
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
        'timestamp' => $data['timestamp'] ?? now(),
        'rain_prediction' => $data['rainPrediction'] ?? 'Unknown',
        'rain_prediction_certainty' => $data['rainPredictionCertainty'] ?? 0
      ]);
    } catch (\Exception $e) {
      Log::error('Firebase error:', ['error' => $e->getMessage()]);
      return response()->json([
        'error' => 'Unable to connect to device. Please try again later.'
      ], 500);
    }
  }

  public function getHistoricalData()
  {
    try {
      $date = request('date', now()->format('Y-m-d'));
      $device_id = request('device_id', '2A');  // Default to 2A if not specified
      $user_id = request('user_id', '2');      // Default to 2 if not specified
      $selectedDate = \Carbon\Carbon::parse($date)->startOfDay();

      $reference = $this->database->getReference("uid={$user_id}/deviceid={$device_id}/history");
      $snapshot = $reference->getSnapshot();
      $history = $snapshot->getValue();

      Log::info('Raw history data:', ['date' => $date, 'history_keys' => array_keys($history ?? [])]);

      if (!$history || !is_array($history)) {
        return response()->json(['error' => 'No historical data available'], 404);
      }

      // Filter data by the timestamp key format (YYYY-MM-DD_HH-mm-ss)
      $data = collect($history)->filter(function ($reading, $key) use ($selectedDate) {
        try {
          $datePart = substr($key, 0, 10); // Get YYYY-MM-DD part from the key
          return $datePart === $selectedDate->format('Y-m-d');
        } catch (\Exception $e) {
          Log::error('Error parsing date from key:', [
            'key' => $key,
            'error' => $e->getMessage()
          ]);
          return false;
        }
      });

      Log::info('Filtered data count:', ['count' => $data->count()]);

      if ($data->isEmpty()) {
        return response()->json(['error' => 'No data available for selected date'], 404);
      }

      // Sort by the timestamp key
      $data = $data->sortBy(function ($reading, $key) {
        return $key; // Keys are already in timestamp format
      });

      $formattedData = [
        'labels' => $data->keys()->map(function ($key) {
          // Convert timestamp key format (2024-12-16_07-51-56) to time only (07:51)
          return substr(str_replace('-', ':', substr($key, 11)), 0, 5);
        }),
        'temperature' => $data->pluck('temperature'),
        'humidity' => $data->pluck('humidity'),
        'pressure' => $data->pluck('pressure_hPa'),
        'wind_speed' => $data->pluck('windSpeed_kmph'),
        'rainfall' => $data->pluck('rainfall_mm'),
        'uv_index' => $data->pluck('uvIndex'),
        'weather_condition' => $data->pluck('weatherCondition')
      ];

      return response()->json($formattedData);
    } catch (\Exception $e) {
      Log::error('Historical data error:', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
      ]);

      return response()->json([
        'error' => 'Error processing historical data',
        'message' => $e->getMessage()
      ], 500);
    }
  }
}
