<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class RecommendationService
{
  public function getRecommendedCategories($weatherCondition, $temperature)
  {
    try {
      if (!is_string($weatherCondition) || !is_numeric($temperature)) {
        Log::error('Invalid input parameters', [
          'weatherCondition' => $weatherCondition,
          'temperature' => $temperature
        ]);
        throw new \InvalidArgumentException('Invalid weather data provided');
      }

      $recommendations = [
        'cap' => [],
        'top' => [],
        'bottom' => []
      ];


      if ($temperature >= 32) {
        $recommendations['cap'] = ['baseball'];
        $recommendations['top'] = ['t_shirt'];
        $recommendations['bottom'] = ['shorts'];
      } elseif ($temperature >= 28) {
        $recommendations['cap'] = ['baseball'];
        $recommendations['top'] = ['t_shirt'];
        $recommendations['bottom'] = ['shorts', 'joggers'];
      } elseif ($temperature >= 24) {
        $recommendations['cap'] = ['baseball', 'beanie'];
        $recommendations['top'] = ['t_shirt', 'long_sleeve'];
        $recommendations['bottom'] = ['joggers', 'jeans'];
      } else {
        $recommendations['cap'] = ['beanie'];
        $recommendations['top'] = ['long_sleeve', 'hoodie'];
        $recommendations['bottom'] = ['jeans', 'joggers'];
      }


      $weatherConditionLower = strtolower($weatherCondition);

      if (str_contains($weatherConditionLower, 'rain')) {
        if (str_contains($weatherConditionLower, 'heavy')) {
          $recommendations['top'] = ['hoodie'];
          $recommendations['bottom'] = ['jeans'];
          $recommendations['cap'] = ['beanie'];
        } else {
          $recommendations['top'] = ['long_sleeve', 'hoodie'];
          $recommendations['bottom'] = ['jeans', 'joggers'];
          $recommendations['cap'] = ['baseball', 'beanie'];
        }
      }


      if (str_contains($weatherConditionLower, 'clear')) {
        $recommendations['cap'] = ['baseball'];
      }

      if (str_contains($weatherConditionLower, 'humid')) {
        $recommendations['top'] = ['t_shirt'];
        $recommendations['bottom'] = ['shorts', 'joggers'];
      }

      return $recommendations;
    } catch (\Exception $e) {
      Log::error('Error in RecommendationService: ' . $e->getMessage());
      throw $e;
    }
  }
}
