<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\WardrobeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdmindashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/public-weather-data', [HomeController::class, 'getPublicWeatherData'])->name('public.weather.data');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
  Route::get('/signin', [AuthController::class, 'showSignIn'])->name('signin');
  Route::post('/signin', [AuthController::class, 'login']);
  Route::get('/signup', [AuthController::class, 'showSignUp'])->name('signup');
  Route::post('/signup', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
  Route::get('/livedata', [WeatherController::class, 'index'])->name('weather');
  Route::get('/wardrobe', [WardrobeController::class, 'index'])->name('wardrobe');
  Route::get('/weather/data', [WeatherController::class, 'getData'])->name('weather.data');
  Route::get('/weather/history', [WeatherController::class, 'getHistoricalData'])->name('weather.history');
  Route::get('/wardrobe/recommendations', [WardrobeController::class, 'getRecommendations'])->name('wardrobe.recommendations');
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

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
  Route::get('/dashboard', [AdmindashboardController::class, 'index'])->name('admin.dashboard');
  Route::get('/users', [AdmindashboardController::class, 'users'])->name('admin.users');
  Route::get('/devices', [AdmindashboardController::class, 'devices'])->name('admin.devices');
  Route::patch('/users/{user}', [AdmindashboardController::class, 'updateUser'])->name('admin.users.update');
  Route::delete('/users/{user}', [AdmindashboardController::class, 'destroyUser'])->name('admin.users.delete');
  Route::post('/users', [AdmindashboardController::class, 'storeUser'])->name('admin.users.store');
  Route::post('/devices', [AdmindashboardController::class, 'storeDevice'])->name('admin.devices.store');
  Route::delete('/devices/{device}', [AdmindashboardController::class, 'destroyDevice'])->name('admin.devices.delete');
  Route::get('/blogs', [AdmindashboardController::class, 'blogs'])->name('admin.blogs');
  Route::post('/blogs', [AdmindashboardController::class, 'storeBlog'])->name('admin.blogs.store');
  Route::patch('/blogs/{post}', [AdmindashboardController::class, 'updateBlog'])->name('admin.blogs.update');
  Route::delete('/blogs/{post}', [AdmindashboardController::class, 'destroyBlog'])->name('admin.blogs.delete');
  Route::patch('/blogs/{post}/toggle', [AdmindashboardController::class, 'togglePublish'])->name('admin.blogs.toggle');
  Route::get('/blogs/{post}', [AdmindashboardController::class, 'getBlog'])->name('admin.blogs.get');
});
