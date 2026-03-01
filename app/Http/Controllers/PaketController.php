<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    // 1. Tampilkan Halaman Data Paket (Read)
    public function index()
    {
        $pakets = Paket::orderBy('created_at', 'desc')->get();
        return view('paket.index', compact('pakets'));
    }

    // 2. Tampilkan Form Tambah Paket (Create)
    public function create()
    {
        return view('paket.create');
    }

    // 3. Proses Simpan Data Paket Baru (Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis' => 'required|in:One Day Pass,Membership Bulanan,Personal Training',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
        ]);

        Paket::create($request->all());

        return redirect()->route('paket.index')->with('success', 'Data Paket berhasil ditambahkan!');
    }

    // 4. Tampilkan Form Edit Paket (Edit)
    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('paket.edit', compact('paket'));
    }

    // 5. Proses Update Data Paket (Update)
    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis' => 'required|in:One Day Pass,Membership Bulanan,Personal Training',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
        ]);

        $paket->update($request->all());

        return redirect()->route('paket.index')->with('success', 'Data Paket berhasil diperbarui!');
    }

    // 6. Proses Hapus Data Paket (Destroy)
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('paket.index')->with('success', 'Data Paket berhasil dihapus!');
    }
}