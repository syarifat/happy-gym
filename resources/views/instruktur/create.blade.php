<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('instruktur.index') }}" class="text-gray-500 hover:text-[#db3535] transition font-semibold">← Kembali ke Data Instruktur</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Instruktur (Personal Trainer)</h2>

        <form action="{{ route('instruktur.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                    @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Spesialisasi Olahraga</label>
                    <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}" placeholder="Contoh: Cardio, Bodypump, Peleton" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Login Aplikasi</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                        @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#e45151] hover:bg-red-700 text-white font-bold py-2 px-8 rounded shadow-sm transition">
                    Simpan Instruktur
                </button>
            </div>
        </form>
    </div>
</x-app-layout>