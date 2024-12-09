<?php

namespace App\Http\Controllers;

class WardrobeController extends Controller
{
  public function index()
  {
    $recommendations = []; // Add your wardrobe logic here
    return view('wardrobe', compact('recommendations'));
  }
}
