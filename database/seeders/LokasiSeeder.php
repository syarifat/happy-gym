<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lokasis')->insert([
            [
                'nama_cabang' => 'Happy Gym - Cabang Tulungagung',
                'kota' => 'Tulungagung',
                'alamat' => 'Jl. Pahlawan No. 123, Kedungwaru, Tulungagung',
                'jam_buka' => "Senin-Jumat | 06:00 - 22:00\nSabtu-Minggu | 06:00 - 20:00",
                'fasilitas_klub' => "Treadmill\nAC Central\nLoker\nShower Air Panas\nParkir Luas\nFree WiFi",
                'link_google_maps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2854809817!2d111.8242!3d-8.0669',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_cabang' => 'Happy Gym - Pusat Kediri',
                'kota' => 'Kediri',
                'alamat' => 'Jl. Dhoho No. 45, Kota Kediri',
                'jam_buka' => "Senin-Jumat | 06:00 - 22:00\nSabtu-Minggu | 06:00 - 20:00",
                'fasilitas_klub' => "Treadmill\nAC Central\nLoker\nShower Air Panas",
                'link_google_maps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2854809817!2d111.8242!3d-8.0669',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_cabang' => 'Happy Gym - Cabang Nganjuk',
                'kota' => 'Nganjuk',
                'alamat' => 'Jl. Panglima Sudirman No. 88, Nganjuk',
                'jam_buka' => "Senin-Jumat | 06:00 - 22:00\nSabtu-Minggu | 06:00 - 20:00",
                'fasilitas_klub' => "Treadmill\nLoker\nParkir Luas\nArea Crossfit",
                'link_google_maps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2854809817!2d111.8242!3d-8.0669',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}