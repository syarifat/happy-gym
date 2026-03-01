<?php

namespace App\Http\Controllers;

use App\Models\Instruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstrukturController extends Controller
{
    // 1. Tampilkan Halaman Data Instruktur (Read)
    public function index()
    {
        $instrukturs = Instruktur::orderBy('created_at', 'desc')->get();
        return view('instruktur.index', compact('instrukturs'));
    }

    // 2. Tampilkan Form Tambah Instruktur (Create)
    public function create()
    {
        return view('instruktur.create');
    }

    // 3. Proses Simpan Data Instruktur Baru (Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:instrukturs',
            'password' => 'required|string|min:6',
            'spesialisasi' => 'nullable|string|max:255',
        ]);

        Instruktur::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password
            'spesialisasi' => $request->spesialisasi,
        ]);

        return redirect()->route('instruktur.index')->with('success', 'Data Instruktur berhasil ditambahkan!');
    }

    // 4. Tampilkan Form Edit Instruktur (Edit)
    public function edit($id)
    {
        $instruktur = Instruktur::findOrFail($id);
        return view('instruktur.edit', compact('instruktur'));
    }

    // 5. Proses Update Data Instruktur (Update)
    public function update(Request $request, $id)
    {
        $instruktur = Instruktur::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:instrukturs,username,' . $instruktur->instruktur_id . ',instruktur_id',
            'spesialisasi' => 'nullable|string|max:255',
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'spesialisasi' => $request->spesialisasi,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $instruktur->update($data);

        return redirect()->route('instruktur.index')->with('success', 'Data Instruktur berhasil diperbarui!');
    }

    // 6. Proses Hapus Data Instruktur (Destroy)
    public function destroy($id)
    {
        $instruktur = Instruktur::findOrFail($id);
        $instruktur->delete();

        return redirect()->route('instruktur.index')->with('success', 'Data Instruktur berhasil dihapus!');
    }
}