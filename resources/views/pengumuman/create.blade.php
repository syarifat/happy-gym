<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('pengumuman.index') }}" class="text-gray-500 font-semibold">← Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Buat Pengumuman Baru</h2>

        <form action="{{ route('pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Pengumuman / Promo</label>
                <input type="text" name="judul" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Isi Pengumuman</label>
                <textarea name="deskripsi" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Foto / Banner Promo</label>
                <input type="file" name="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan Pengumuman di:</label>
                <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="tampil_web" class="form-checkbox text-red-500" value="1" checked>
                        <span class="ml-2 text-gray-700">Web Landing Page</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="tampil_member" class="form-checkbox text-red-500" value="1" checked>
                        <span class="ml-2 text-gray-700">Aplikasi Member</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="tampil_instruktur" class="form-checkbox text-red-500" value="1" checked>
                        <span class="ml-2 text-gray-700">Aplikasi Instruktur</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#e45151] hover:bg-red-700 text-white font-bold py-2 px-8 rounded shadow-sm transition">
                    Posting Sekarang
                </button>
            </div>
        </form>
    </div>
</x-app-layout>