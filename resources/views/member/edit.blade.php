<x-app-layout>
    <div class="mb-6"><a href="{{ route('member.index') }}" class="text-gray-500 hover:text-red-500 font-semibold transition">← Kembali ke Daftar</a></div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Edit Data Member</h2>
        
        <form action="{{ route('member.update', $member->member_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $member->nama) }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $member->email) }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Handphone</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $member->no_hp) }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Status Membership <span class="text-red-500">*</span></label>
                    <select name="status_membership" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        <option value="Aktif" {{ $member->status_membership == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $member->status_membership == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Mulai Membership</label>
                    <input type="date" name="tanggal_mulai_member" value="{{ old('tanggal_mulai_member', $member->tanggal_mulai_member) }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Berakhir Membership</label>
                    <input type="date" name="tanggal_berakhir_member" value="{{ old('tanggal_berakhir_member', $member->tanggal_berakhir_member) }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-1">Ganti Password (Opsional)</label>
                <input type="password" name="password" minlength="6" placeholder="Kosongkan jika tidak ingin ganti password" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-10 rounded shadow-md transition transform hover:-translate-y-1">
                    Update Data Member
                </button>
            </div>
        </form>
    </div>
</x-app-layout>