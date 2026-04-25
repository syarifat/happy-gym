<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Paket;

class DiskonController extends Controller
{
    public function index()
    {
        $pakets = Paket::all();
        return view('diskon.index', compact('pakets'));
    }

    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('diskon.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga_diskon' => 'nullable|numeric|min:0',
            'tanggal_akhir_diskon' => 'nullable|date',
        ]);

        $paket = Paket::findOrFail($id);
        $paket->update([
            'harga_diskon' => $request->harga_diskon,
            'tanggal_akhir_diskon' => $request->tanggal_akhir_diskon,
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon paket berhasil diperbarui.');
    }
}
