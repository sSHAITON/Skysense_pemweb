<?php

namespace App\Http\Controllers;

use App\Models\Clothe;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WardrobeController extends Controller
{
  protected $weatherController;
  protected $recommendationService;

  public function __construct(WeatherController $weatherController, RecommendationService $recommendationService)
  {
    $this->weatherController = $weatherController;
    $this->recommendationService = $recommendationService;
  }

  public function index()
  {
    $user = Auth::user();
    $devices = $user->devices;
    return view('wardrobe', compact('devices'));
  }

  public function getRecommendations(Request $request)
  {
    try {
      // Validate request
      if (!$request->device_id || !$request->user_id) {
        return response()->json(['error' => 'Device ID and User ID are required'], 400);
      }

      // Get weather data
      $weatherResponse = $this->weatherController->getData($request);

      // Convert JSON response to array if needed
      $weatherData = $weatherResponse->original ?? json_decode($weatherResponse->getContent(), true);

      // Check if weather data has error
      if (isset($weatherData['error'])) {
        Log::error('Weather data error: ' . $weatherData['error']);
        return response()->json(['error' => $weatherData['error']], 400);
      }

      // Validate weather data structure
      if (!isset($weatherData['weather_condition']) || !isset($weatherData['temperature'])) {
        Log::error('Invalid weather data structure', ['data' => $weatherData]);
        return response()->json(['error' => 'Invalid weather data'], 400);
      }

      // Get recommended categories
      $recommendedCategories = $this->recommendationService->getRecommendedCategories(
        $weatherData['weather_condition'],
        $weatherData['temperature']
      );

      // Get user clothes
      $userClothes = Clothe::where('user_id', $request->user_id)->get();

      $recommendations = [];
      foreach ($recommendedCategories as $category => $subcategories) {
        $recommendations[$category] = $userClothes
          ->where('category', $category)
          ->whereIn('subcategory', $subcategories)
          ->values()
          ->all();
      }

      // Return response
      return response()->json([
        'recommendations' => $recommendations,
        'weather' => [
          'condition' => $weatherData['weather_condition'],
          'temperature' => $weatherData['temperature']
        ]
      ]);
    } catch (\Exception $e) {
      Log::error('Recommendation error: ' . $e->getMessage(), [
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
      ]);

      return response()->json([
        'error' => 'An error occurred while getting recommendations',
        'debug_message' => config('app.debug') ? $e->getMessage() : null
      ], 500);
    }
  }
}
