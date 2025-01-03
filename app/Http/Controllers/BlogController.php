<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
  public function index()
  {
    $posts = Post::with('user')
      ->where('is_published', true)
      ->orderBy('created_at', 'desc')
      ->get();
    return view('blog', compact('posts'));
  }

  public function show($slug)
  {
    $post = Post::with('user')
      ->where('slug', $slug)
      ->where('is_published', true)
      ->firstOrFail();
    return view('blog-single', compact('post'));
  }
}
