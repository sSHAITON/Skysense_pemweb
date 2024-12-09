<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
  public function index()
  {
    $posts = []; // Add your blog posts logic here
    return view('blog', compact('posts'));
  }
}
