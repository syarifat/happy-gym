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

        // Kirim keduanya ke view 'landing'
        return view('landing', compact('lokasis', 'pakets'));
    }
}