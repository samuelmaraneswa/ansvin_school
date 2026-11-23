<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
  protected $table = 'semester';

  protected $fillable = [
    'tahun_ajaran_id',
    'nama',
    'tanggal_mulai',
    'tanggal_selesai',
    'is_active',
  ];

  public function tahunAjaran()
  {
    return $this->belongsTo(TahunAjaran::class);
  }
}
