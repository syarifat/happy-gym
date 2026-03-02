<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pakets')->insert([
            [
                'nama_paket' => 'Member Harian', 
                'jenis' => 'One Day Pass', 
                'harga' => 25000, 
                'durasi' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_paket' => 'Paket Bulanan', 
                'jenis' => 'Membership Bulanan', 
                'harga' => 250000, 
                'durasi' => 30,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_paket' => 'Personal Training', 
                'jenis' => 'Personal Training', 
                'harga' => 1200000, 
                'durasi' => 30,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}