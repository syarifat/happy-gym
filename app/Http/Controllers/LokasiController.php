<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::all();
        return view('lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        return view('lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'kota' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
            'jam_buka' => 'nullable|string',
            'fasilitas_klub' => 'nullable|string',
            'link_google_maps' => 'nullable|string',
        ]);

        $data = $request->all();

        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            // Akan tersimpan di storage/app/public/lokasi
            $data['foto'] = $request->file('foto')->store('lokasi', 'public');
        }

        Lokasi::create($data);

        return redirect()->route('lokasi.index')->with('success', 'Cabang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'kota' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jam_buka' => 'nullable|string',
            'fasilitas_klub' => 'nullable|string',
        ]);

        $data = $request->all();

        // Proses upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($lokasi->foto && Storage::disk('public')->exists($lokasi->foto)) {
                Storage::disk('public')->delete($lokasi->foto);
            }
            $data['foto'] = $request->file('foto')->store('lokasi', 'public');
        }

        $lokasi->update($data);

        return redirect()->route('lokasi.index')->with('success', 'Data Cabang berhasil diperbarui!');
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('lokasi.edit', compact('lokasi'));
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus!');
    }
}