<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // 1. Tampilkan Halaman Data Member (Read / Index)
    public function index()
    {
        $members = Member::orderBy('created_at', 'desc')->get();
        return view('member.index', compact('members'));
    }

    // 2. Tampilkan Detail Member (Show)
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('member.show', compact('member'));
    }

    // 3. Tampilkan Form Edit Member (Edit)
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('member.edit', compact('member'));
    }

    // 4. Proses Update Data Member (Update)
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email,' . $member->member_id . ',member_id',
            'no_hp' => 'nullable|string|max:15',
            'status_membership' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_mulai_member' => 'nullable|date',
            'tanggal_berakhir_member' => 'nullable|date',
        ]);

        // Persiapkan data yang akan diupdate
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'status_membership' => $request->status_membership,
            'tanggal_mulai_member' => $request->tanggal_mulai_member,
            'tanggal_berakhir_member' => $request->tanggal_berakhir_member,
        ];

        // Jika form password diisi, maka update password (jika kosong, biarkan password lama)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('member.index')->with('success', 'Data member berhasil diperbarui!');
    }

    // 5. Proses Hapus Data Member (Destroy)
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('member.index')->with('success', 'Data member berhasil dihapus!');
    }
}