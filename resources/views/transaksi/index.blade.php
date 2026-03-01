<x-app-layout>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Riwayat Transaksi</h2>
        <p class="text-gray-500 text-sm">Semua pembayaran otomatis melalui Midtrans.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs">Order ID</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs">Member</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs">Paket</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs">Jumlah</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs text-center">Status</th>
                    <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs text-center">Metode</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $t)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-4 px-6 text-sm font-mono text-gray-600">{{ $t->order_id }}</td>
                    <td class="py-4 px-6 font-medium text-gray-800">{{ $t->member->nama }}</td>
                    <td class="py-4 px-6 text-sm text-gray-600">{{ $t->pemesanan->paket->nama_paket ?? '-' }}</td>
                    <td class="py-4 px-6 font-bold">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-center">
                        @php
                            $color = [
                                'settlement' => 'bg-green-100 text-green-700',
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'expire' => 'bg-red-100 text-red-700',
                                'cancel' => 'bg-gray-100 text-gray-700',
                            ][$t->status] ?? 'bg-blue-100 text-blue-700';
                        @endphp
                        <span class="{{ $color }} px-3 py-1 rounded-full text-xs font-bold uppercase">
                            {{ $t->status }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center text-xs text-gray-500 uppercase">
                        {{ $t->metode ?? 'N/A' }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        <a href="{{ route('transaksi.show', $t->pembayaran_id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-2 px-4 rounded text-xs transition">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-gray-500 italic">Belum ada transaksi masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>