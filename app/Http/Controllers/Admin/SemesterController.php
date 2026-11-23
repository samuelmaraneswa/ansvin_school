<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SemesterController extends Controller
{
  public function index(Request $request)
  {
    $keyword = trim($request->query('keyword', ''));

    $query = Semester::with('tahunAjaran')
      ->when($keyword, function ($query) use ($keyword){
        $search = "%{$keyword}%";

        $query->where(function ($q) use ($search){
          $q->where('semester.nama', 'like', $search)
            ->orWhereHas('tahunAjaran', function ($ta) use ($search){
                $ta->where('nama', 'like', $search);
            })
            ->orWhereRaw(
              "EXISTS (
                SELECT 1 from tahun_ajaran where tahun_ajaran.id = semester.tahun_ajaran_id
                and concat(semester.nama, ' - ', tahun_ajaran.nama) like ?
                )",
                [$search]
            );
        });
      });

    $perPage = 2;

    $totalRows = $query->count();
    $totalPages = max(1, (int) ceil($totalRows / $perPage));

    $page = min(max(1, (int) $request->query('page', 1)), $totalPages);

    $semester = $query->paginate($perPage, ['*'], 'page', $page);

    if($request->ajax()){
      return response()->json([
        'semester' => $semester->items(),
        'pagination' => [
          'current_page' => $semester->currentPage(),
          'totalRows' => $semester->total(),
          'limit' => $semester->perPage(),
          'total_pages' => $semester->lastPage(),
        ],
      ]);
    }

    $tahunAjaran = TahunAjaran::all();

    return view('admin.semester.index', compact('tahunAjaran'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
      'nama' => [
        'required',
        'in:Ganjil,Genap',
        Rule::unique('semester', 'nama')->where('tahun_ajaran_id', $request->tahun_ajaran_id),
      ],
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ],[
      'nama.unique' => 'Semester sudah tersedia pada tahun ajaran ini.'
    ]);

    Semester::create($validated);

    return response()->json(['message' => 'Data berhasil di tambahkan.']);
  }

  public function show(Semester $semester)
  {
    return response()->json(['semester' => $semester]);
  }

  public function update(Request $request, Semester $semester)
  {
    $validated = $request->validate([
      'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
      'nama' => [
        'required',
        'in:Ganjil,Genap',
        Rule::unique('semester', 'nama')
          ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
          ->ignore($semester->id),
      ],
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ], [
      'nama.unique' => 'Semester sudah tersedia pada tahun ajaran ini.',
    ]);

    $semester->update($validated);

    return response()->json(['message' => 'Data berhasil di perbaharui.']);
  }

  public function suggestion(Request $request)
  {
    $keyword = trim($request->query('keyword', ''));

    $search = "%{$keyword}%";

    $semester = Semester::query()
                  ->where(function($query) use ($search){
                    $query->where('semester.nama', 'like', $search)
                      ->orWhereHas('tahunAjaran', function ($ta) use ($search){
                        $ta->where('nama', 'like', $search);
                      })
                      ->orWhereRaw(
                          "EXISTS (
                            SELECT 1
                            FROM tahun_ajaran
                            WHERE tahun_ajaran.id = semester.tahun_ajaran_id
                            AND CONCAT(semester.nama, ' - ', tahun_ajaran.nama) LIKE ?
                        )",
                        [$search]
                      );
                  })
                  ->with('tahunAjaran')
                  ->limit(10)
                  ->get();

    return response()->json(['semester' => $semester]);
  }

  public function activation(Semester $semester)
  { 
    $tahunAjaran = $semester->tahunAjaran;
    if(!$tahunAjaran->is_active){
      return response()->json([
        'success' => false,
        'message' => 'Aktifkan Tahun Ajaran terlebih dahulu.',
      ], 422);
    }

    DB::transaction(function () use ($semester){
      if ($semester->is_active) {
        $semester->update(['is_active' => false]);

        return;
      }

      Semester::where('tahun_ajaran_id', $semester->tahun_ajaran_id)
        ->where('id', '!=', $semester->id)
        ->update(['is_active' => false]);

      $semester->update(['is_active' => true]);
    });

    return response()->json([
      'message' => 'Status aktivasi semester berhasil diperbarui.',
    ]);
  }
}
