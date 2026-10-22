<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class PegawaiController extends Controller
{
  public function index(Request $request)
  {
    $keyword = trim($request->query('keyword', ''));

    $query = Pegawai::with('user')
      ->whereHas('user', function ($query) {
        $query->where('is_active', true);
      })
      ->when($keyword, function ($query) use ($keyword) {
        $query->whereHas('user', function ($q) use ($keyword) {
          $q->where('name', 'like', "%{$keyword}%")
            ->orWhere('login_id', 'like', "%{$keyword}%");
        });
      });

    $perPage = 2;
    $totalRows = $query->count();
    $totalPages = max(1, (int) ceil($totalRows / $perPage));

    $page = min(
      max(1, (int) $request->query('page', 1)),
      $totalPages
    );

    $pegawai = $query->paginate($perPage, ['*'], 'page', $page);

    if ($request->ajax()) {
      return response()->json([
        'pegawai' => $pegawai->items(),
        'pagination' => [
          'current_page' => $pegawai->currentPage(),
          'total_pages' => $pegawai->lastPage(),
          'total_rows' => $pegawai->total(),
          'limit' => $pegawai->perPage(),
        ],
      ]);
    }

    return view('admin.pegawai.index', compact('pegawai'));
  }

  public function suggestion(Request $request)
  {
    $keyword = trim($request->query('keyword', ''));

    $pegawai = Pegawai::with('user')
      ->whereHas('user', function ($query) use ($keyword) {
        $query->where('is_active', true)
          ->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('login_id', 'like', "%{$keyword}%");
          });
      })
      ->limit(10)
      ->get();

    return response()->json([
      'users' => $pegawai
    ]);
  }

  public function show(Pegawai $pegawai)
  {
    $pegawai->load('user');

    return view('admin.pegawai.detail', compact('pegawai'));
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

  // public function store(Request $request)
  // {
  //   $avatarPath = null;
  //   $thumbPath = null;

  //   try{
  //     $validated = $request->validate([
  //       'name' => 'required|string|max:255|min:3',
  //       'login_id' => 'required|string|max:255|unique:users,login_id',
  //       'kode_pegawai' => 'required|string|max:30|unique:pegawai,kode_pegawai',
  //       'role' => 'required|in:admin,guru',
  //       'nik' => 'nullable|string|size:16|unique:users,nik',
  //       'jenis_kelamin' => 'nullable|in:L,P',
  //       'tpt_lahir' => 'nullable|string|max:255',
  //       'tgl_lahir' => 'nullable|date',
  //       'alamat' => 'nullable|string',
  //       'no_hp' => 'nullable|string|max:20',
  //       'email' => 'nullable|email|unique:users,email',
  //       'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
  //     ]);

  //     if($request->hasFile('avatar')){
  //       $file = $request->file('avatar');
  //       $extension = strtolower($file->extension());

  //       $filename = Str::uuid() . '.' . $extension;

  //       $avatarPath = "users/pegawai/avatar/{$filename}";
  //       $thumbPath = "users/pegawai/avatar/thumb/{$filename}";

  //       $manager = new ImageManager(new Driver());
  //       $image = $manager->decode($file->getRealPath());

  //       $width = $image->width();
  //       $height = $image->height();

  //       if($width / $height > 3 / 4){
  //         $cropWidth = (int) floor($height * 3 / 4);
  //         $cropHeight = $height;
  //         $offsetX = (int) floor(($width - $cropWidth) / 2);
  //         $offsetY = 0;
  //       }else{
  //         $cropWidth = $width;
  //         $cropHeight = (int) floor($width * 4 / 3);
  //         $offsetX = 0;
  //         $offsetY = (int) floor(($height - $cropHeight) / 2);
  //       }

  //       $image->crop($cropWidth, $cropHeight, $offsetX, $offsetY);

  //       $original = $image->encodeUsingFileExtension($extension, quality:100);
  //       Storage::disk('public')->put($avatarPath, (string) $original);

  //       $image->cover(150, 200);
  //       $thumbnail = $image->encodeUsingFileExtension($extension, quality:100);
  //       Storage::disk('public')->put($thumbPath, (string) $thumbnail);
  //     }
      
  //     $userData = [
  //       'name' => $validated['name'],
  //       'login_id' => $validated['login_id'],
  //       'role' => $validated['role'],
  //       'nik' => $validated['nik'] ?? null,
  //       'jenis_kelamin' => $validated['jenis_kelamin'],
  //       'tpt_lahir' => $validated['tpt_lahir'] ?? null,
  //       'tgl_lahir' => $validated['tgl_lahir'] ?? null,
  //       'alamat' => $validated['alamat'] ?? null,
  //       'no_hp' => $validated['no_hp'] ?? null,
  //       'email' => $validated['email'] ?? null,
  //       'password' => Hash::make($validated['login_id']),
  //       'avatar' => $avatarPath,
  //     ];

  //     DB::transaction(function () use ($userData, $validated) {

  //       $user = User::create($userData);

  //       $pegawaiData = [
  //         'user_id' => $user->id,
  //         'kode_pegawai' => $validated['kode_pegawai'],
  //       ];

  //       Pegawai::create($pegawaiData);
  //     });

  //     return response()->json([
  //       'success' => true,
  //       'message' => 'Data pegawai berhasil ditambahkan.',
  //     ]);
  //   } catch (ValidationException $e) {
  //     return response()->json([
  //       'success' => false,
  //       'errors' => $e->errors(),
  //     ], 422);
  //   } catch(Throwable $e){
  //     Storage::disk('public')->delete(
  //       array_filter([$avatarPath, $thumbPath])
  //     );

  //     report($e);

  //     return response()->json([
  //       'success' => false,
  //       'message' => $e->getMessage(),
  //     ], 500);
  //   }
  // }

  public function store(Request $request)
  {
    $avatarPath = null;
    $thumbPath = null;

    try{
      $validated = $request->validate([
        'name' => 'required|string|max:255|min:3',
        'login_id' => 'required|string|max:255|unique:users,login_id',
        'kode_pegawai' => 'required|string|max:30|unique:pegawai,kode_pegawai',
        'role' => 'required|in:admin,guru,pegawai',
        'jabatan' => 'required|in:admin,kepala_sekolah,wakil_kepala_sekolah,guru',
        'nik' => 'nullable|string|size:16|unique:users,nik',
        'jenis_kelamin' => 'nullable|in:L,P',
        'tpt_lahir' => 'nullable|string|max:255',
        'tgl_lahir' => 'nullable|date',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string|max:20',
        'email' => 'nullable|email|unique:users,email',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
      ]);

      if($request->hasFile('avatar')){
        $file = $request->file('avatar');
        $extension = strtolower($file->extension());

        $filename = Str::uuid() . '.' . $extension;
        
        $avatarPath = "users/pegawai/avatar/{$filename}";
        $thumbPath = "users/pegawai/avatar/thumb/{$filename}";

        Storage::disk('public')->putFileAs('users/pegawai/avatar', $file, $filename);

        $manager = new ImageManager(new Driver());
        $image = $manager->decode($file->getRealPath());

        $image->scaleDown(300, 400);

        $thumbnail = $image->encodeUsingFileExtension($extension, quality:100);
        Storage::disk('public')->put($thumbPath, (string) $thumbnail);
      }

      $userData = [
        'name' => $validated['name'],
        'login_id' => $validated['login_id'],
        'role' => $validated['role'],
        'nik' => $validated['nik'] ?? null,
        'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
        'tpt_lahir' => $validated['tpt_lahir'] ?? null,
        'tgl_lahir' => $validated['tgl_lahir'] ?? null,
        'alamat' => $validated['alamat'] ?? null,
        'no_hp' => $validated['no_hp'] ?? null,
        'email' => $validated['email'] ?? null,
        'password' => Hash::make($validated['login_id']),
        'avatar' => $avatarPath,
      ];
      
      DB::transaction(function () use ($userData, $validated){
        $user = User::create($userData);

        Pegawai::create([
          'user_id' => $user->id,
          'kode_pegawai' => $validated['kode_pegawai'],
          'jabatan' => $validated['jabatan'],
        ]);
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
    } catch (Throwable $e) {
      Storage::disk('public')->delete(
        array_filter([$avatarPath, $thumbPath])
      );

      report($e);

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

  // public function update(Request $request, Pegawai $pegawai)
  // {
  //   $avatarPath = null;
  //   $thumbPath = null;
  //   $oldAvatar = $pegawai->user->avatar;

  //   try{
  //     $validated = $request->validate([
  //       'name' => 'required|string|max:255|min:3',
  //       'login_id' => 'required|string|max:255|unique:users,login_id,' . $pegawai->user_id,
  //       'kode_pegawai' => 'required|string|max:30|unique:pegawai,kode_pegawai,' . $pegawai->id,
  //       'role' => 'required|in:admin,guru',
  //       'nik' => 'nullable|string|size:16|unique:users,nik,' . $pegawai->user_id,
  //       'jenis_kelamin' => 'nullable|in:L,P',
  //       'tpt_lahir' => 'nullable|string|max:255',
  //       'tgl_lahir' => 'nullable|date',
  //       'alamat' => 'nullable|string',
  //       'no_hp' => 'nullable|string|max:20',
  //       'email' => 'nullable|email|unique:users,email,' . $pegawai->user_id,
  //       'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
  //     ]);

  //     if ($request->hasFile('avatar')) {
  //       $file = $request->file('avatar');
  //       $extension = strtolower($file->extension());
  //       $filename = Str::uuid() . '.' . $extension;

  //       $avatarPath = "users/pegawai/avatar/{$filename}";
  //       $thumbPath = "users/pegawai/avatar/thumb/{$filename}";

  //       $manager = ImageManager::usingDriver(Driver::class);
  //       $image = $manager->decode($file);

  //       $width = $image->width();
  //       $height = $image->height();

  //       if ($width / $height > 3 / 4) {
  //         $cropWidth = (int) floor($height * 3 / 4);
  //         $image->crop(
  //           $cropWidth,
  //           $height,
  //           (int) floor(($width - $cropWidth) / 2),
  //           0
  //         );
  //       } else {
  //         $cropHeight = (int) floor($width * 4 / 3);
  //         $image->crop(
  //           $width,
  //           $cropHeight,
  //           0,
  //           (int) floor(($height - $cropHeight) / 2)
  //         );
  //       }

  //       $original = $image->encodeUsingFileExtension($extension, quality: 100);

  //       Storage::disk('public')->put($avatarPath, (string) $original);

  //       $image->cover(150, 200);

  //       $thumbnail = $image->encodeUsingFileExtension($extension, quality: 100);

  //       Storage::disk('public')->put($thumbPath, (string) $thumbnail);
  //     }

  //     $userData = [
  //       'name' => $validated['name'],
  //       'login_id' => $validated['login_id'],
  //       'role' => $validated['role'],
  //       'nik' => $validated['nik'] ?? null,
  //       'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
  //       'tpt_lahir' => $validated['tpt_lahir'] ?? null,
  //       'tgl_lahir' => $validated['tgl_lahir'] ?? null,
  //       'alamat' => $validated['alamat'] ?? null,
  //       'no_hp' => $validated['no_hp'] ?? null,
  //       'email' => $validated['email'] ?? null,
  //     ];

  //     if ($avatarPath !== null) {
  //       $userData['avatar'] = $avatarPath;
  //     }

  //     // return response()->json($validated);
  //     DB::transaction(function () use ($userData, $validated, $pegawai){
  //       $pegawai->user->update($userData);

  //       $pegawai->update(['kode_pegawai' => $validated['kode_pegawai']]);
  //     });

  //     if ($avatarPath !== null && $oldAvatar) {
  //       Storage::disk('public')->delete([
  //         $oldAvatar,
  //         'users/pegawai/avatar/thumb/' . basename($oldAvatar),
  //       ]);
  //     }

  //     return response()->json([
  //       'success' => true,
  //       'message' => 'Data pegawai berhasil di perbaharui.'
  //     ]);
  //   }catch(ValidationException $e){
  //     return response()->json([
  //       'success' => false,
  //       'errors' => $e->errors(),
  //     ], 422);
  //   }catch(Throwable $e){
  //     Storage::disk('public')->delete(
  //       array_filter([$avatarPath, $thumbPath])
  //     );

  //     report($e);

  //     return response()->json([
  //       'success' => false,
  //       'message' => $e->getMessage(),
  //     ], 500);
  //   }
  // }

  public function update(Request $request, Pegawai $pegawai)
  {
    $avatarPath = null;
    $thumbPath = null;
    $oldAvatar = $pegawai->user->avatar;

    try {
      $validated = $request->validate([
        'name' => 'required|string|max:255|min:3',
        'login_id' => 'required|string|max:255|unique:users,login_id,' . $pegawai->user_id,
        'kode_pegawai' => 'required|string|max:30|unique:pegawai,kode_pegawai,' . $pegawai->id,
        'role' => 'required|in:admin,guru,pegawai',
        'jabatan' => 'required|in:admin,kepala_sekolah,wakil_kepala_sekolah,guru',
        'nik' => 'nullable|string|size:16|unique:users,nik,' . $pegawai->user_id,
        'jenis_kelamin' => 'nullable|in:L,P',
        'tpt_lahir' => 'nullable|string|max:255',
        'tgl_lahir' => 'nullable|date',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string|max:20',
        'email' => 'nullable|email|unique:users,email,' . $pegawai->user_id,
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
      ]);

      if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $extension = strtolower($file->extension());
        $filename = Str::uuid() . '.' . $extension;

        $avatarPath = "users/pegawai/avatar/{$filename}";
        $thumbPath = "users/pegawai/avatar/thumb/{$filename}";

        Storage::disk('public')->putFileAs('users/pegawai/avatar', $file, $filename);

        $manager = new ImageManager(new Driver());
        $image = $manager->decode($file->getRealPath());

        $image->scaleDown(300, 400);

        $thumbnail = $image->encodeUsingFileExtension($extension, quality: 100);

        Storage::disk('public')->put($thumbPath, (string) $thumbnail);
      }

      $userData = [
        'name' => $validated['name'],
        'login_id' => $validated['login_id'],
        'role' => $validated['role'],
        'nik' => $validated['nik'] ?? null,
        'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
        'tpt_lahir' => $validated['tpt_lahir'] ?? null,
        'tgl_lahir' => $validated['tgl_lahir'] ?? null,
        'alamat' => $validated['alamat'] ?? null,
        'no_hp' => $validated['no_hp'] ?? null,
        'email' => $validated['email'] ?? null,
      ];

      if ($avatarPath !== null) {
        $userData['avatar'] = $avatarPath;
      }

      DB::transaction(function () use ($userData, $validated, $pegawai) {
        $pegawai->user->update($userData);

        $pegawai->update([
          'kode_pegawai' => $validated['kode_pegawai'],
          'jabatan' => $validated['jabatan'],
        ]);
      });

      if ($avatarPath !== null && $oldAvatar) {
        Storage::disk('public')->delete([$oldAvatar, 'users/pegawai/avatar/thumb/' . basename($oldAvatar),]);
      }

      return response()->json([
        'success' => true,
        'message' => 'Data pegawai berhasil diperbaharui.',
      ]);
    } catch (ValidationException $e) {
      return response()->json([
        'success' => false,
        'errors' => $e->errors(),
      ], 422);
    } catch (Throwable $e) {
      Storage::disk('public')->delete(
        array_filter([$avatarPath, $thumbPath])
      );

      report($e);

      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function destroy(Pegawai $pegawai)
  {
    try {
      $pegawai->user->update([
        'is_active' => false,
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Pegawai berhasil dinonaktifkan.',
      ]);
    } catch (Throwable $e) {
      return response()->json([
        'success' => false,
        'message' => 'Gagal menonaktifkan pegawai.',
      ], 500);
    }
  }
}
