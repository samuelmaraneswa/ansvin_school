<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Throwable;

class PegawaiController extends Controller
{
  public function index()
  {
    $pegawai = Pegawai::with('user')->latest()->paginate(30);

    return view('admin.pegawai.index', compact('pegawai'));
  }

  public function show(Pegawai $pegawai)
  {
    $pegawai->load('user');

    return view('admin.pegawai.detail', compact('pegawai'));
    // return response()->json($pegawai);
  }
  
  public function create()
  {
    return view('admin.pegawai.create');
  }

  public function generateKode()
  {
    $prefix = 'ANVPG' . now()->format('Y');

    $kode_pegawai = Pegawai::generateKodePegawai($prefix);

    return response()->json([
      'kode_pegawai' => $kode_pegawai
    ]);
  }

  public function store(Request $request)
  {
    try{
      $validated = $request->validate([
        'name' => 'required|string|max:255|min:3',
        'login_id' => 'required|string|max:255|unique:users,login_id',
        'kode_pegawai' => 'required|string|max:30|unique:pegawai,kode_pegawai',
        'role' => 'required|in:admin,guru',
        'nik' => 'nullable|string|size:16|unique:users,nik',
        'jenis_kelamin' => 'nullable|in:L,P',
        'tpt_lahir' => 'nullable|string|max:255',
        'tgl_lahir' => 'nullable|date',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string|max:20',
        'email' => 'nullable|email|unique:users,email',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
      ]);

      
      $userData = [
        'name' => $validated['name'],
        'login_id' => $validated['login_id'],
        'role' => $validated['role'],
        'nik' => $validated['nik'] ?? null,
        'jenis_kelamin' => $validated['jenis_kelamin'],
        'tpt_lahir' => $validated['tpt_lahir'] ?? null,
        'tgl_lahir' => $validated['tgl_lahir'] ?? null,
        'alamat' => $validated['alamat'] ?? null,
        'no_hp' => $validated['no_hp'] ?? null,
        'email' => $validated['email'] ?? null,
        'password' => Hash::make($validated['login_id']),
      ];

      DB::transaction(function () use ($userData, $validated) {

        $user = User::create($userData);

        $pegawaiData = [
          'user_id' => $user->id,
          'kode_pegawai' => $validated['kode_pegawai'],
        ];

        Pegawai::create($pegawaiData);
      });

      return response()->json([
        'success' => true,
        'message' => 'Data pegawai berhasil ditambahkan.',
      ]);
    } catch (ValidationException $e) {
      return response()->json([
        'success' => false,
        'errors' => $e->errors(),
      ], 422);
    } catch(Throwable $e){
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 500);
    }
  }
  
  public function edit(Pegawai $pegawai)
  {
    $pegawai->load('user');

    return view('admin.pegawai.edit', compact('pegawai'));
  }
}
