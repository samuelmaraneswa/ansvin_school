<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $user = User::create([
        'login_id' => 'ANVPG2026001',
        'name' => 'samuel',
        'email' => 'samuelmaraneswa60@gmail.com',
        'password' => Hash::make('samuel'),
        'role' => 'admin',
        'must_change_password' => 0
      ]);

      Pegawai::create([
        'user_id' => $user->id,
        'kode_pegawai' => 'ANVPG2026001',
      ]);
    }
}
