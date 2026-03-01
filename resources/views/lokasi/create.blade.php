<x-app-layout>
    <div class="mb-6"><a href="{{ route('lokasi.index') }}" class="text-gray-500 font-semibold">← Kembali</a></div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Cabang Baru</h2>
        <form action="{{ route('lokasi.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Cabang</label>
                <input type="text" name="nama_cabang" placeholder="Contoh: Happy Gym - Pusat Tulungagung" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Link Google Maps (URL)</label>
                <input type="url" name="link_google_maps" placeholder="https://goo.gl/maps/..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#e45151] hover:bg-red-700 text-white font-bold py-2 px-8 rounded shadow-sm transition">Simpan Lokasi</button>
            </div>
        </form>
    </div>
</x-app-layout>