<x-app-layout>
    <div class="mb-6"><a href="{{ route('lokasi.index') }}" class="text-gray-500 hover:text-red-500 font-semibold transition">← Kembali ke Daftar</a></div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Edit Data Cabang: <span class="text-red-500">{{ $lokasi->nama_cabang }}</span></h2>
        
        <form action="{{ route('lokasi.update', $lokasi->lokasi_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Cabang <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_cabang" value="{{ $lokasi->nama_cabang }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kota</label>
                        <input type="text" name="kota" value="{{ $lokasi->kota }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="3" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ $lokasi->alamat }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat Cabang</label>
                        <textarea name="deskripsi" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ $lokasi->deskripsi }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Link Google Maps (URL / Iframe)</label>
                        <input type="text" name="link_google_maps" value="{{ $lokasi->link_google_maps }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Foto Cabang</label>
                        @if($lokasi->foto)
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$lokasi->foto) }}" class="h-32 rounded object-cover border">
                                <p class="text-xs text-gray-500 mt-1">Foto saat ini. Biarkan kosong jika tidak ingin mengubah foto.</p>
                            </div>
                        @endif
                        <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Jam Operasional</label>
                        <textarea name="jam_buka" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ $lokasi->jam_buka }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Gunakan 'Enter' untuk memisahkan baris hari.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Fasilitas Klub</label>
                        <textarea name="fasilitas_klub" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ $lokasi->fasilitas_klub }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Gunakan 'Enter' untuk memisahkan setiap fasilitas.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Daftar Alat Gym Terkemuka</label>
                        <textarea name="alat_gym" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ $lokasi->alat_gym }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Gunakan 'Enter' untuk memisahkan nama alat.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-8 mt-6 border-t border-gray-100">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-10 rounded shadow-md transition transform hover:-translate-y-1">
                    Update Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>