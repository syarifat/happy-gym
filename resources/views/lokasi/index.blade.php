<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Lokasi Cabang Happy Gym</h2>
        <a href="{{ route('lokasi.create') }}" class="bg-[#e45151] hover:bg-red-700 text-white font-semibold py-2 px-6 rounded shadow-sm transition">
            + Tambah Cabang
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($lokasis as $l)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $l->nama_cabang }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $l->alamat }}</p>
                </div>
                <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                    @if($l->link_google_maps)
                        <a href="{{ $l->link_google_maps }}" target="_blank" class="text-red-500 font-semibold text-sm hover:underline">Lihat di Maps</a>
                    @else
                        <span class="text-gray-400 text-sm italic">Link Maps tidak tersedia</span>
                    @endif
                    <div class="flex gap-3">
                        <a href="{{ route('lokasi.edit', $l->lokasi_id) }}" class="text-blue-500 text-sm font-semibold hover:underline">Ubah</a>
                        <form action="{{ route('lokasi.destroy', $l->lokasi_id) }}" method="POST" onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm font-semibold hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 italic">Belum ada data lokasi cabang.</p>
        @endforelse
    </div>
</x-app-layout>