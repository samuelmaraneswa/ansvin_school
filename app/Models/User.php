<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'login_id',
    'name',
    'jenis_kelamin',
    'tpt_lahir',
    'tgl_lahir',
    'nik',
    'alamat',
    'no_hp',
    'email',
    'password',
    'avatar',
    'role',
    'is_active',
    'must_change_password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
      return [
          'email_verified_at' => 'datetime',
          'password' => 'hashed',
          'is_active' => 'boolean',
          'must_change_password' => 'boolean'
      ];
  }

  public function pegawai()
  {
    return $this->hasOne(Pegawai::class);
  }
}
