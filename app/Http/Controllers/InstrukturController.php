<?php

namespace App\Http\Controllers;

use App\Models\Instruktur;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstrukturController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua data lokasi untuk mengisi dropdown filter
        $lokasis = Lokasi::all();

        // 2. Siapkan query dasar untuk Instruktur (Eager Loading lokasi)
        $query = Instruktur::with('lokasi');

        // 3. Cek apakah admin memilih filter lokasi tertentu
        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
        }

        // 4. Eksekusi query
        $instrukturs = $query->get();

        return view('instruktur.index', compact('instrukturs', 'lokasis'));
    }

    public function create()
    {
        // Panggil semua data cabang untuk mengisi dropdown
        $lokasis = Lokasi::all();
        return view('instruktur.create', compact('lokasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:instrukturs,username',
            'password' => 'required|string|min:6',
            'spesialisasi' => 'nullable|string|max:255',
            'lokasi_id' => 'required|exists:lokasis,lokasi_id', // Validasi wajib pilih cabang
        ]);

        Instruktur::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Password dienkripsi
            'spesialisasi' => $request->spesialisasi,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return redirect()->route('instruktur.index')->with('success', 'Instruktur berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $instruktur = Instruktur::findOrFail($id);
        $lokasis = Lokasi::all();
        return view('instruktur.edit', compact('instruktur', 'lokasis'));
    }

    public function update(Request $request, $id)
    {
        $instruktur = Instruktur::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:instrukturs,username,'.$id.',instruktur_id',
            'password' => 'nullable|string|min:6', // Optional (tidak wajib diisi jika tidak ingin ganti password)
            'spesialisasi' => 'nullable|string|max:255',
            'lokasi_id' => 'required|exists:lokasis,lokasi_id',
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'spesialisasi' => $request->spesialisasi,
            'lokasi_id' => $request->lokasi_id,
        ];

        // Jika form password diisi, update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $instruktur->update($data);

        return redirect()->route('instruktur.index')->with('success', 'Data Instruktur berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $instruktur = Instruktur::findOrFail($id);
        $instruktur->delete();
        
        return redirect()->route('instruktur.index')->with('success', 'Instruktur berhasil dihapus!');
    }
}