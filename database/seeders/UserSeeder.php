<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin BKK',
            'email' => 'admin@bkk.test',
            'password' => Hash::make('123'), // hash biar aman
            'role' => 'admin_sekolah',
            'status' => 'active',
        ]);
    }
}
