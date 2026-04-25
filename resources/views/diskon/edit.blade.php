<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('diskon.index') }}" class="text-gray-500 hover:text-red-600 font-semibold text-sm mb-2 inline-block">&larr; Kembali ke Daftar</a>
        <h2 class="text-3xl font-bold text-gray-900">Atur Diskon Paket: {{ $paket->nama_paket }}</h2>
        <p class="text-gray-500 mt-1">Harga Normal: Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
        <form action="{{ route('diskon.update', $paket->paket_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="harga_diskon" class="block text-sm font-bold text-gray-700 mb-2">Harga Diskon (Rp)</label>
                <p class="text-xs text-gray-500 mb-2">Kosongkan jika ingin menonaktifkan diskon/kembali ke harga normal.</p>
                <input type="number" name="harga_diskon" id="harga_diskon" 
                       value="{{ old('harga_diskon', $paket->harga_diskon) }}" 
                       class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" 
                       placeholder="Contoh: 150000">
                @error('harga_diskon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="tanggal_akhir_diskon" class="block text-sm font-bold text-gray-700 mb-2">Periode Diskon Berakhir Pada</label>
                <p class="text-xs text-gray-500 mb-2">Diskon akan otomatis tidak berlaku jika tanggal ini telah terlewati.</p>
                <input type="date" name="tanggal_akhir_diskon" id="tanggal_akhir_diskon" 
                       value="{{ old('tanggal_akhir_diskon', $paket->tanggal_akhir_diskon) }}" 
                       class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500">
                @error('tanggal_akhir_diskon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('diskon.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
