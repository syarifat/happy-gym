<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('dashboard') }}" class="inline-block bg-[#2bc466] hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full shadow-sm transition">
            < Kembali
        </a>
        </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-6">Data Member</h2>

    <div class="flex items-center gap-4 mb-6">
        <input type="text" placeholder="Cari member..." class="border-gray-300 rounded-md shadow-sm w-64 focus:ring-red-500 focus:border-red-500">
        <select class="border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            <option>Semua Bulan</option>
        </select>
        <select class="border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            <option>Semua Membership</option>
        </select>
        <button class="bg-[#e45151] hover:bg-red-600 text-white font-semibold py-2 px-6 rounded shadow-sm transition">
            Filter
        </button>
    </div>

    <div class="flex gap-4 mb-8">
        <button class="bg-[#2bc466] hover:bg-green-600 text-white font-semibold py-2 px-6 rounded shadow-sm transition">Export Excel</button>
        <button class="bg-[#e45151] hover:bg-red-600 text-white font-semibold py-2 px-6 rounded shadow-sm transition">Export PDF</button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider">No</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider">Nama & Kontak</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider text-center">Status</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider text-center">Masa Aktif</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $index => $member)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-4 px-6 text-gray-600">{{ $index + 1 }}</td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-gray-800">{{ $member->nama }}</div>
                        <div class="text-sm text-gray-500">{{ $member->email }} <br> {{ $member->no_hp ?? '-' }}</div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($member->status_membership == 'Aktif')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Aktif</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center text-gray-600 text-sm">
                        @if($member->tanggal_berakhir_member)
                            {{ \Carbon\Carbon::parse($member->tanggal_berakhir_member)->format('d M Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('member.show', $member->member_id) }}" class="text-green-500 hover:text-green-700 font-semibold text-sm">Detail</a>
                            
                            <a href="{{ route('member.edit', $member->member_id) }}" class="text-blue-500 hover:text-blue-700 font-semibold text-sm">Ubah</a>
                            
                            <form action="{{ route('member.destroy', $member->member_id) }}" method="POST" onsubmit="return confirm('Hapus member ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">Belum ada data member.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>