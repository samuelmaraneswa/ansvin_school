<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function index()
  {
    return view('auth/login');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'username' => 'required|string|max:50',
      'password' => 'required',
    ]);

    if(!Auth::attempt($credentials)){
      return response()->json([
        'message' => 'Username atau password salah!'
      ], 422);
    }

    $request->session()->regenerate();

    $user = Auth::user();
    
    $redirect = match($user->role){
      'admin' => route('admin.dashboard'),
      'guru' => route('guru.dashboard'),
      'siswa' => route('siswa.dashboard'),
      default => '/',
    };

    return response()->json([
      'redirect' => $redirect
    ]);
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
  }
}
