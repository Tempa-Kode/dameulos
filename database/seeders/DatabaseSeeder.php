<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(35)->create();

        User::create([
            'name' => 'Dian Simanjuntak',
            'email' => 'dian@dameulos.test',
            'password' => bcrypt('12345678'),
            'no_telp' => '08123456789',
            'alamat' => 'Jl. Setia Budi No. 123, Medan',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dian Pelanggan',
            'email' => 'dianpelanggan@dameulos.test',
            'password' => bcrypt('12345678'),
            'no_telp' => '08123456789',
            'alamat' => 'Jl. Setia Budi No. 123, Medan',
            'role' => 'pelanggan',
        ]);

        User::create([
            'name' => 'Dian Manajer',
            'email' => 'dianmanajer@dameulos.test',
            'password' => bcrypt('12345678'),
            'no_telp' => '08123456789',
            'alamat' => 'Jl. Setia Budi No. 123, Medan',
            'role' => 'manajer',
        ]);
    }
}
