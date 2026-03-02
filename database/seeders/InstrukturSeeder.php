<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class InstrukturSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $password = Hash::make('password');
        $spesialisasiGym = ['Bodybuilding', 'Zumba & Aerobik', 'Yoga & Pilates', 'CrossFit & Cardio', 'General Fitness'];

        // Ambil semua data lokasi cabang dari database
        $lokasis = DB::table('lokasis')->get();

        foreach ($lokasis as $lokasi) {
            // Buat 5 instruktur untuk masing-masing cabang
            for ($i = 0; $i < 5; $i++) {
                DB::table('instrukturs')->insert([
                    'nama' => 'Coach ' . $faker->firstName,
                    // Membuat username unik berdasarkan nama kota
                    'username' => strtolower(str_replace(' ', '', $lokasi->kota)) . '_coach' . ($i + 1) . rand(10, 99), 
                    'password' => $password,
                    'spesialisasi' => $faker->randomElement($spesialisasiGym),
                    'lokasi_id' => $lokasi->lokasi_id, // Disambungkan dengan ID cabang
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}