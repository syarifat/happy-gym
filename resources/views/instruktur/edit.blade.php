<x-app-layout>
    <div class="mb-6"><a href="{{ route('instruktur.index') }}" class="text-gray-500 hover:text-red-500 font-semibold transition">← Kembali</a></div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Data Instruktur</h2>
        
        <form action="{{ route('instruktur.update', $instruktur->instruktur_id) }}" method="POST" class="space-y-6">
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