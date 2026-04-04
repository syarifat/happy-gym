<x-app-layout>
    <div class="mb-6"><a href="{{ route('instruktur.index') }}" class="text-gray-500 hover:text-red-500 font-semibold transition">← Kembali</a></div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Data Instruktur</h2>
        
        <form action="{{ route('instruktur.update', $instruktur->instruktur_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ $instruktur->nama }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Penempatan Cabang <span class="text-red-500">*</span></label>
                <select name="lokasi_id" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    <option value="" disabled>-- Pilih Cabang Penempatan --</option>
                    @foreach($lokasis as $l)
                        <option value="{{ $l->lokasi_id }}" {{ $instruktur->lokasi_id == $l->lokasi_id ? 'selected' : '' }}>
                            {{ $l->nama_cabang }} ({{ $l->kota }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Spesialisasi</label>
                <input type="text" name="spesialisasi" value="{{ $instruktur->spesialisasi }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil</label>
                @if($instruktur->foto)
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $instruktur->foto) }}" alt="Foto {{ $instruktur->nama }}" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 border border-gray-300 rounded-md shadow-sm">
                <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto. Maksimal 2MB.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Username Login <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ $instruktur->username }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" minlength="6" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" placeholder="Kosongkan jika tak diubah">
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-8 rounded shadow-sm transition">
                    Update Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>