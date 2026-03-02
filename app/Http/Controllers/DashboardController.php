<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Instruktur;
use App\Models\Lokasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung statistik dasar
        $totalMember = Member::count();
        $memberAktif = Member::where('status_membership', 'Aktif')->count();
        $totalInstruktur = Instruktur::count();
        $totalCabang = Lokasi::count();
        
        // Menghitung total pendapatan dari transaksi yang sukses (settlement)
        $totalPendapatan = Pembayaran::where('status', 'settlement')->sum('jumlah');

        // Mengambil 5 member terbaru untuk ditampilkan di tabel ringkasan
        $memberTerbaru = Member::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalMember', 
            'memberAktif', 
            'totalInstruktur', 
            'totalCabang', 
            'totalPendapatan',
            'memberTerbaru'
        ));
    }
}