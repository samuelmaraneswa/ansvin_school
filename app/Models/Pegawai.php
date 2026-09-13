<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
  protected $table = 'pegawai';

  protected $fillable = [
    'user_id',
    'kode_pegawai',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public static function generateKodePegawai(string $prefix)
  {
    $lastKode = self::orderByRaw(
      'CAST(SUBSTRING(kode_pegawai, 10) AS UNSIGNED) DESC'
    )->value('kode_pegawai');

    $lastNumber = $lastKode
      ? (int) substr($lastKode, 9)
      : 0;

    return $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
  }
}
