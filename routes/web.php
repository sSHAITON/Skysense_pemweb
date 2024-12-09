<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\WardrobeController;
use App\Http\Controllers\SettingsController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/livedata', [WeatherController::class, 'index'])->name('weather');
Route::get('/wardrobe', [WardrobeController::class, 'index'])->name('wardrobe');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/weather/data', [WeatherController::class, 'getData'])->name('weather.data');
Route::get('/weather/history', [WeatherController::class, 'getHistoricalData'])->name('weather.history');

// Authentication Routes
Route::middleware('guest')->group(function () {
  Route::get('/signin', [AuthController::class, 'showSignIn'])->name('signin');
  Route::post('/signin', [AuthController::class, 'login']);
  Route::get('/signup', [AuthController::class, 'showSignUp'])->name('signup');
  Route::post('/signup', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::get('/settings', [SettingsController::class, 'index'])->name('settings.profile');
  Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
  Route::get('/settings/mywardrobe', [SettingsController::class, 'wardrobe'])->name('settings.wardrobe');
  Route::post('/settings/mywardrobe/store', [SettingsController::class, 'storeClothing'])->name('settings.wardrobe.store');
  Route::delete('/settings/mywardrobe/{clothe}', [SettingsController::class, 'destroyClothing'])->name('settings.wardrobe.delete');
  Route::get('/settings/device', [SettingsController::class, 'device'])->name('settings.device');
  Route::post('/settings/device/store', [SettingsController::class, 'storeDevice'])->name('settings.device.store');
  Route::delete('/settings/device/{device}', [SettingsController::class, 'destroyDevice'])->name('settings.device.delete');
  // Add other authenticated routes here
});
