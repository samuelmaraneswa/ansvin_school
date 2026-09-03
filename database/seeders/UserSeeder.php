<?php

namespace Database\Seeders;

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
      User::create([
        'username' => 'ANV202606001',
        'email' => 'samuelmaraneswa60@gmail.com',
        'password' => Hash::make('samuel'),
        'role' => 'admin'
      ]);
    }
}
