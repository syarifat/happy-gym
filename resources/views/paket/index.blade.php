<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('dashboard') }}" class="inline-block bg-[#2bc466] hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full shadow-sm transition">
            < Kembali
        </a>
        <a href="{{ route('paket.create') }}" class="inline-block bg-[#e45151] hover:bg-red-700 text-white font-semibold py-2 px-6 rounded shadow-sm transition">
            + Tambah Paket
        </a>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-6">Kelola Data Paket</h2>

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
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider">Nama Paket</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider">Jenis</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider">Harga</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider text-center">Durasi</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pakets as $index => $paket)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-4 px-6 text-gray-600">{{ $index + 1 }}</td>
                    <td class="py-4 px-6 font-bold text-gray-800">{{ $paket->nama_paket }}</td>
                    <td class="py-4 px-6 text-gray-600">
                        <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-semibold border border-red-100">
                            {{ $paket->jenis }}
                        </span>
                    </td>
                    <td class="py-4 px-6 font-semibold text-gray-700">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-center text-gray-600">{{ $paket->durasi }} Hari</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('paket.edit', $paket->paket_id) }}" class="text-blue-500 hover:text-blue-700 font-semibold text-sm">Ubah</a>
                            <form action="{{ route('paket.destroy', $paket->paket_id) }}" method="POST" onsubmit="return confirm('Hapus paket ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">Belum ada data paket.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>