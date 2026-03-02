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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($lokasis as $l)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                @if($l->foto)
                    <img src="{{ asset('storage/'.$l->foto) }}" alt="{{ $l->nama_cabang }}" class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-400">
                        <span>Tidak ada foto</span>
                    </div>
                @endif

                <div class="p-6 flex flex-col flex-grow justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-800">{{ $l->nama_cabang }}</h3>
                            @if($l->kota)
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $l->kota }}</span>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><i class="bi bi-geo-alt-fill text-red-500 mr-1"></i>{{ $l->alamat }}</p>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                        @if($l->link_google_maps)
                            <a href="{{ $l->link_google_maps }}" target="_blank" class="text-gray-500 hover:text-red-500 font-semibold text-sm transition">📍 Buka Maps</a>
                        @else
                            <span class="text-gray-400 text-sm italic">No Maps</span>
                        @endif
                        
                        <div class="flex gap-4">
                            <a href="{{ route('lokasi.edit', $l->lokasi_id) }}" class="text-blue-600 text-sm font-semibold hover:underline">Edit</a>
                            <form action="{{ route('lokasi.destroy', $l->lokasi_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus cabang ini? Semua instruktur di cabang ini akan kehilangan relasinya.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 text-sm font-semibold hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-8 text-center rounded-xl border border-gray-100 text-gray-500 italic">
                Belum ada data lokasi cabang yang ditambahkan.
            </div>
        @endforelse
    </div>
</x-app-layout>