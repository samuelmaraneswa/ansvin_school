<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
  public function index(Request $request)
  {
    $keyword = trim($request->query('keyword', ''));

    $query = TahunAjaran::query()
      ->when($keyword, function ($query) use ($keyword) {
        $query->where('nama', 'like', "%{$keyword}%");
      });

    $perPage = 2;
    $totalRows = $query->count();
    $totalPages = max(1, (int) ceil($totalRows / $perPage));

    $page = min(max(1, (int) $request->query('page', 1)), $totalPages);

    $tahunAjaran = $query->paginate($perPage, ['*'], 'page', $page);

    if($request->ajax()){
      return response()->json([
        'tahun_ajaran' => $tahunAjaran->items(),
        'pagination' => [
          'current_page' => $tahunAjaran->currentPage(),
          'total_pages' => $tahunAjaran->lastPage(),
          'total_rows' => $tahunAjaran->total(),
          'limit' => $tahunAjaran->perPage(),
        ],
      ]);
    }

    return view('admin.tahun-ajaran.index');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'nama' => 'required|string|max:100',
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ],[
      'nama.required' => 'Nama tidak boleh kosong.',
      'tanggal_mulai.required' => 'Tanggal mulai tidak boleh kosong.',
      'tanggal_selesai.required' => 'Tanggal selesai tidak boleh kosong.',
    ]);

    TahunAjaran::create($validated);

    return response()->json([
      'message' => 'Tahun ajaran berhasil di tambahkan!'
    ], 201);
  }

  public function show(TahunAjaran $tahunAjaran)
  {
    return response()->json([
      'tahun_ajaran' => $tahunAjaran
    ]);
  }

  public function update(Request $request, TahunAjaran $tahunAjaran)
  {
    $validated = $request->validate([
      'nama' => 'required|string|max:20|unique:tahun_ajaran,nama,' . $tahunAjaran->id,
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ], [
      'nama.required' => 'Nama tidak boleh kosong.',
      'nama.unique' => 'Tahun ajaran sudah tersedia.',
      'tanggal_mulai.required' => 'Tanggal mulai tidak boleh kosong.',
      'tanggal_selesai.required' => 'Tanggal selesai tidak boleh kosong.',
      'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
    ]);

    $tahunAjaran->update($validated);

    return response()->json([
      'message' => 'Tahun ajaran berhasil diperbarui!'
    ]);
  }

  public function suggestion(Request $request)
  {
    $keyword = trim($request->query('keyword', ''));

    $tahunAjaran = TahunAjaran::where('nama', 'like', "%{$keyword}%")->limit(10)->get();

    return response()->json([
      'tahun_ajaran' => $tahunAjaran
    ]);
  }

  public function activation(TahunAjaran $tahunAjaran)
  {
    $newStatus = !$tahunAjaran->is_active;
     
    $tahunAjaran->update(['is_active' => $newStatus]);

    return response()->json([
      'message' => $newStatus ? 'Tahun Ajaran berhasil di aktifkan.' : 'Tahun Ajaran berhasil di nonaktfikan.'
    ]);
  }
}
