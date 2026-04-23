<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\Paket; // Pastikan model Paket di-import

class LandingController extends Controller
{
    public function index()
    {
        // Tarik data lokasi beserta instrukturnya
        $lokasis = Lokasi::with('instrukturs')->get();
        
        // Tarik semua data paket
        $pakets = Paket::all(); 

        // Tarik pengumuman untuk web
        $pengumumans = \App\Models\Pengumuman::where('tampil_web', true)->orderBy('tanggal_post', 'desc')->get();

        // Kirim keduanya ke view 'landing'
        return view('landing', compact('lokasis', 'pakets', 'pengumumans'));
    }

    public function showPromo($id)
    {
        $pengumuman = \App\Models\Pengumuman::findOrFail($id);
        return view('promo_detail', compact('pengumuman'));
    }
}