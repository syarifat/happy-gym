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
        // Ambil filter
        $cabang_id = $request->input('cabang_id');
        $rentang = $request->input('rentang');

        // Helper untuk filter tanggal
        $applyDateFilter = function ($query, $column) use ($rentang) {
            if ($rentang) {
                $now = \Carbon\Carbon::now();
                if ($rentang == 'hari_ini') {
                    $query->whereDate($column, $now->toDateString());
                } elseif ($rentang == 'minggu_ini') {
                    $query->whereBetween($column, [$now->startOfWeek()->toDateString(), $now->copy()->endOfWeek()->toDateString()]);
                } elseif ($rentang == 'bulan_ini') {
                    $query->whereMonth($column, $now->month)
                          ->whereYear($column, $now->year);
                } elseif ($rentang == 'tahun_ini') {
                    $query->whereYear($column, $now->year);
                }
            }
        };

        // Query Member
        $memberQuery = Member::query();
        if ($cabang_id) $memberQuery->where('lokasi_id', $cabang_id);
        $applyDateFilter($memberQuery, 'created_at');
        
        $totalMember = $memberQuery->count();
        $memberAktif = (clone $memberQuery)->where('status_membership', 'Aktif')->count();

        // Query Instruktur
        $instrukturQuery = Instruktur::query();
        if ($cabang_id) $instrukturQuery->where('lokasi_id', $cabang_id);
        $totalInstruktur = $instrukturQuery->count();

        // Query Pendapatan
        $pembayaranQuery = Pembayaran::where('status', 'settlement');
        if ($cabang_id) {
            $pembayaranQuery->whereHas('member', function($q) use ($cabang_id) {
                $q->where('lokasi_id', $cabang_id);
            });
        }
        $applyDateFilter($pembayaranQuery, 'tanggal_bayar');
        $totalPendapatan = $pembayaranQuery->sum('jumlah');

        $totalCabang = Lokasi::count();

        // Mengambil 5 member terbaru (sesuai filter juga)
        $memberTerbaru = (clone $memberQuery)->orderBy('created_at', 'desc')->take(5)->get();

        // Query untuk chart transaksi paket terbanyak
        $chartQuery = \App\Models\PemesananPaket::query()
            ->select('paket_id', \Illuminate\Support\Facades\DB::raw('COUNT(paket_id) as total_transaksi'))
            ->with('paket')
            ->whereHas('member', function($q) use ($cabang_id) {
                if ($cabang_id) {
                    $q->where('lokasi_id', $cabang_id);
                }
            });
        $applyDateFilter($chartQuery, 'tanggal_pesan');

        $paketData = $chartQuery->groupBy('paket_id')->get();
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