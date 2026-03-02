<x-app-layout>
    <div class="mb-6"><a href="{{ route('member.index') }}" class="text-gray-500 hover:text-red-500 font-semibold transition">← Kembali ke Daftar Member</a></div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-3xl">
        <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-2xl font-bold">
                    {{ substr($member->nama, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $member->nama }}</h2>
                    <p class="text-gray-500">{{ $member->email }}</p>
                </div>
            </div>
            <div>
                @if($member->status_membership == 'Aktif')
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold shadow-sm">Membership Aktif</span>
                @else
                    <span class="bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-sm font-bold shadow-sm">Tidak Aktif</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Informasi Kontak</h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-xs text-gray-500">Nomor Handphone</span>
                        <span class="font-semibold text-gray-800">{{ $member->no_hp ?? 'Belum diisi' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Terdaftar Pada</span>
                        <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($member->created_at)->format('d F Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Detail Membership</h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-xs text-gray-500">Tanggal Mulai Membership</span>
                        <span class="font-semibold text-gray-800">
                            {{ $member->tanggal_mulai_member ? \Carbon\Carbon::parse($member->tanggal_mulai_member)->format('d F Y') : '-' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Tanggal Berakhir Membership</span>
                        <span class="font-semibold text-red-600">
                            {{ $member->tanggal_berakhir_member ? \Carbon\Carbon::parse($member->tanggal_berakhir_member)->format('d F Y') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex gap-4">
            <a href="{{ route('member.edit', $member->member_id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded shadow-sm transition">
                Edit Data Member
            </a>
        </div>
    </div>
</x-app-layout>