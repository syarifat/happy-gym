<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('paket.index') }}" class="text-gray-500 hover:text-[#db3535] transition font-semibold">← Kembali ke Data Paket</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Paket Baru</h2>

        <form action="{{ route('paket.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Paket</label>
                    <input type="text" name="nama_paket" value="{{ old('nama_paket') }}" placeholder="Contoh: Paket Hemat 6 Bulan" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                    @error('nama_paket') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori Jenis Paket</label>
                    <select name="jenis" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                        <option value="One Day Pass">One Day Pass</option>
                        <option value="Membership Bulanan">Membership Bulanan</option>
                        <option value="Personal Training">Personal Training</option>
                    </select>
                    @error('jenis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 border-t border-gray-100 pt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" placeholder="Contoh: 150000" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                    @error('harga') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Durasi Aktif (Hari)</label>
                    <input type="number" name="durasi" value="{{ old('durasi') }}" placeholder="Contoh: 30" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                    <p class="text-xs text-gray-500 mt-1">Isi 1 untuk One Day Pass, 30 untuk sebulan, 180 untuk 6 bulan, dst.</p>
                    @error('durasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#e45151] hover:bg-red-700 text-white font-bold py-2 px-8 rounded shadow-sm transition">
                    Simpan Paket
                </button>
            </div>
        </form>
    </div>
</x-app-layout>