<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('pengumuman.index') }}" class="text-gray-500 font-semibold">← Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Ubah Pengumuman</h2>

        <form action="{{ route('pengumuman.update', $pengumuman->pengumuman_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Pengumuman / Promo</label>
                <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                @error('judul') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Isi Pengumuman</label>
                <textarea name="deskripsi" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ old('deskripsi', $pengumuman->deskripsi) }}</textarea>
                @error('deskripsi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto / Banner Saat Ini</label>
                @if($pengumuman->foto)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $pengumuman->foto) }}" class="w-48 h-32 object-cover rounded-lg border">
                        <p class="text-xs text-gray-500 mt-1 italic">*Biarkan jika tidak ingin mengganti foto</p>
                    </div>
                @endif
                
                <input type="file" name="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan Pengumuman di:</label>
                <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="tampil_web" class="form-checkbox text-red-500" value="1" {{ $pengumuman->tampil_web ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Web Landing Page</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="tampil_member" class="form-checkbox text-red-500" value="1" {{ $pengumuman->tampil_member ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Aplikasi Member</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="tampil_instruktur" class="form-checkbox text-red-500" value="1" {{ $pengumuman->tampil_instruktur ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Aplikasi Instruktur</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#2bc466] hover:bg-green-700 text-white font-bold py-2 px-8 rounded shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>