<x-app-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Diskon Paket</h2>
            <p class="text-gray-500 mt-1">Atur potongan harga (diskon) dan periode diskon untuk masing-masing paket.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Nama Paket</th>
                        <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Harga Normal</th>
                        <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Harga Diskon</th>
                        <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Periode S/D</th>
                        <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Status Diskon</th>
                        <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pakets as $paket)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <span class="font-semibold text-gray-900">{{ $paket->nama_paket }}</span>
                            <span class="block text-xs text-gray-500 mt-1">{{ $paket->jenis }} ({{ $paket->durasi }} hari)</span>
                        </td>
                        <td class="py-4 px-6 text-gray-700">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-red-600 font-bold">
                            {{ $paket->harga_diskon ? 'Rp '.number_format($paket->harga_diskon, 0, ',', '.') : '-' }}
                        </td>
                        <td class="py-4 px-6 text-gray-700">
                            {{ $paket->tanggal_akhir_diskon ? \Carbon\Carbon::parse($paket->tanggal_akhir_diskon)->format('d M Y') : '-' }}
                        </td>
                        <td class="py-4 px-6">
                            @if($paket->is_diskon_aktif)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Aktif</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('diskon.edit', $paket->paket_id) }}" class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-200 transition">Atur Diskon</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
