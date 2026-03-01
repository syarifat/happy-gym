<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('dashboard') }}" class="inline-block bg-[#2bc466] hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full shadow-sm transition">
            < Kembali
        </a>
        <a href="{{ route('instruktur.create') }}" class="inline-block bg-[#e45151] hover:bg-red-700 text-white font-semibold py-2 px-6 rounded shadow-sm transition">
            + Tambah Instruktur
        </a>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-6">Data Personal Trainer</h2>

    <div class="flex items-center gap-4 mb-6">
        <input type="text" placeholder="Cari instruktur..." class="border-gray-300 rounded-md shadow-sm w-64 focus:ring-red-500 focus:border-red-500">
        <button class="bg-[#e45151] hover:bg-red-600 text-white font-semibold py-2 px-6 rounded shadow-sm">
            Cari
        </button>
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
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider">Nama Lengkap</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider">Username Login</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider">Spesialisasi</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($instrukturs as $index => $instruktur)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-4 px-6 text-gray-600">{{ $index + 1 }}</td>
                    <td class="py-4 px-6 font-bold text-gray-800">{{ $instruktur->nama }}</td>
                    <td class="py-4 px-6 text-gray-600">{{ $instruktur->username }}</td>
                    <td class="py-4 px-6 text-gray-600">
                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $instruktur->spesialisasi ?? 'Umum' }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('instruktur.edit', $instruktur->instruktur_id) }}" class="text-blue-500 hover:text-blue-700 font-semibold text-sm">Ubah</a>
                            <form action="{{ route('instruktur.destroy', $instruktur->instruktur_id) }}" method="POST" onsubmit="return confirm('Hapus instruktur ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">Belum ada data instruktur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>