<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function index()
  {
    return view('auth/login');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'login_id' => 'required|string|max:50',
      'password' => 'required',
    ]);

    if(!Auth::attempt($credentials)){
      return response()->json([
        'message' => 'Username atau password salah!'
      ], 422);
    }

    $request->session()->regenerate();

    $user = Auth::user();

    if($user->must_change_password){
      return response()->json(['redirect' => route('password.change')]);
    }
    
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

  public function changePassword()
  {
    return view('auth.change-password');
  }

  public function updatePassword(Request $request)
  {
    $data = $request->validate([
      'password_lama' => 'required|string',
      'password_baru' => ['required','string','min:8','regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',],
      'confirm_password' => 'required|same:password_baru',
    ], [
      'password_lama.required' => 'Password lama tidak boleh kosong',

      'password_baru.required' => 'Password baru tidak boleh kosong',
      'password_baru.min' => 'Password minimal 8 karakter',
      'password_baru.regex' => 'Password harus mengandung huruf dan angka',

      'confirm_password.required' => 'Konfirmasi password tidak boleh kosong',
      'confirm_password.same' => 'Konfirmasi password tidak sesuai',
    ]);

    $user = $request->user();

    if(!Hash::check($data['password_lama'], $user->password)){
      return response()->json([
        'success' => false,
        'errors' => ['password_lama' => 'Password lama tidak sesuai'] 
      ], 422);
    }

    $user->password = Hash::make($data['password_baru']);
    $user->must_change_password = false;
    $user->save();

    $redirect = match ($user->role) {
      'admin' => route('admin.dashboard'),
      'guru' => route('guru.dashboard'),
      'siswa' => route('siswa.dashboard'),
      default => '/',
    };

    return response()->json([
      'success' => true,
      'message' => 'Password berhasil diperbarui',
      'redirect' => $redirect
    ]);
  }
}
