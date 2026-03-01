<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Ambil data pembayaran beserta data member dan paketnya
        $transaksis = Pembayaran::with(['member', 'pemesanan.paket'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('transaksi.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Pembayaran::with(['member', 'pemesanan.paket'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
}