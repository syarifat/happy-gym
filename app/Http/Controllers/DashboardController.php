<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Instruktur;
use App\Models\Lokasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
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

        // Ambil filter
        $cabang_id = $request->input('cabang_id');
        $rentang = $request->input('rentang');

        // Query untuk chart transaksi paket terbanyak
        $query = \App\Models\PemesananPaket::query()
            ->select('paket_id', \Illuminate\Support\Facades\DB::raw('COUNT(paket_id) as total_transaksi'))
            ->with('paket')
            ->whereHas('member', function($q) use ($cabang_id) {
                if ($cabang_id) {
                    $q->where('lokasi_id', $cabang_id);
                }
            });

        if ($rentang) {
            $now = \Carbon\Carbon::now();
            if ($rentang == 'hari_ini') {
                $query->whereDate('tanggal_pesan', $now->toDateString());
            } elseif ($rentang == 'minggu_ini') {
                $query->whereBetween('tanggal_pesan', [$now->startOfWeek()->toDateString(), $now->copy()->endOfWeek()->toDateString()]);
            } elseif ($rentang == 'bulan_ini') {
                $query->whereMonth('tanggal_pesan', $now->month)
                      ->whereYear('tanggal_pesan', $now->year);
            } elseif ($rentang == 'tahun_ini') {
                $query->whereYear('tanggal_pesan', $now->year);
            }
        }

        $paketData = $query->groupBy('paket_id')->get();
        $paketLabels = $paketData->map(function($item) { return $item->paket->nama_paket ?? 'Unknown'; })->toArray();
        $paketValues = $paketData->map(function($item) { return $item->total_transaksi; })->toArray();

        $lokasis = Lokasi::all();

        return view('dashboard', compact(
            'totalMember', 
            'memberAktif', 
            'totalInstruktur', 
            'totalCabang', 
            'totalPendapatan',
            'memberTerbaru',
            'paketLabels',
            'paketValues',
            'lokasis',
            'cabang_id',
            'rentang'
        ));
    }
}