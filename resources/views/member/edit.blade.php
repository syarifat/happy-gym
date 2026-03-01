<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('member.index') }}" class="text-gray-500 hover:text-[#db3535] transition font-semibold">← Kembali ke Data Member</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Ubah Data Member</h2>

        <form action="{{ route('member.update', $member->member_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $member->nama) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $member->email) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. Handphone</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $member->no_hp) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password <span class="text-gray-400 font-normal text-xs">(Kosongkan jika tidak ingin mengubah password)</span></label>
                <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-3 gap-6 border-t border-gray-100 pt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Membership</label>
                    <select name="status_membership" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                        <option value="Tidak Aktif" {{ $member->status_membership == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="Aktif" {{ $member->status_membership == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai_member" value="{{ old('tanggal_mulai_member', $member->tanggal_mulai_member) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_berakhir_member" value="{{ old('tanggal_berakhir_member', $member->tanggal_berakhir_member) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
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