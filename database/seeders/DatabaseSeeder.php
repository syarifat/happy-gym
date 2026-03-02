<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            PaketSeeder::class,
            LokasiSeeder::class,     // Lokasi harus jalan duluan
            InstrukturSeeder::class, // Supaya instruktur bisa ambil id lokasi
        ]);
    }
}