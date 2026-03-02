<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
        <p class="text-gray-500 mt-1">Selamat datang kembali, Admin! Berikut adalah ringkasan sistem Happy Gym hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Total Member</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalMember) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-2xl">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Member Aktif</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($memberAktif) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center text-2xl">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Total Instruktur</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalInstruktur) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 bg-red-50 text-red-600 rounded-full flex items-center justify-center text-2xl">
                <i class="bi bi-wallet2"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Total Pendapatan</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Pendaftar Member Terbaru</h3>
                <a href="{{ route('member.index') }}" class="text-sm text-red-500 font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-3 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Nama</th>
                            <th class="py-3 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Kontak</th>
                            <th class="py-3 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($memberTerbaru as $m)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="py-3 px-6 text-sm font-semibold text-gray-800">{{ $m->nama }}</td>
                            <td class="py-3 px-6 text-sm text-gray-500">{{ $m->email }}</td>
                            <td class="py-3 px-6 text-center">
                                @if($m->status_membership == 'Aktif')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Aktif</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-gray-500 text-sm italic">Belum ada member baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-900">Informasi Cabang</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-center w-full h-32 bg-gray-50 rounded-lg mb-4 border border-dashed border-gray-200">
                    <div class="text-center">
                        <i class="bi bi-shop text-3xl text-gray-400"></i>
                        <h4 class="font-bold text-gray-800 text-xl mt-2">{{ $totalCabang }} Lokasi</h4>
                        <p class="text-xs text-gray-500">Cabang Happy Gym beroperasi</p>
                    </div>
                </div>
                <a href="{{ route('lokasi.index') }}" class="block w-full text-center bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold py-2 rounded transition">
                    Kelola Cabang
                </a>
            </div>
        </div>
    </div>
</x-app-layout>