<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function showSignIn()
  {
    return view('signin', [
      'title' => 'Sign In',
      'form' => 'signinform'
    ]);
  }

  public function showSignUp()
  {
    return view('signin', [
      'title' => 'Sign Up',
      'form' => 'signupform'
    ]);
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return response()->json([
        'success' => true,
        'message' => 'Login successful',
        'redirect' => '/'
      ]);
    }

    return response()->json([
      'success' => false,
      'message' => 'The provided credentials do not match our records.'
    ], 401);
  }

  public function register(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'phone_number' => 'required|string|max:20',
      'location' => 'required|string|max:255',
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
      'phone_number' => $validated['phone_number'],
      'location' => $validated['location'],
    ]);

    Auth::login($user);
    return redirect('/');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  }
}
