<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('transaksi.index') }}" class="text-gray-500 font-semibold hover:text-[#db3535] transition">← Kembali ke Riwayat Transaksi</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Detail Transaksi</h2>
                        <p class="text-sm text-gray-500">Order ID: <span class="font-mono font-bold">{{ $transaksi->order_id }}</span></p>
                    </div>
                    @php
                        $color = [
                            'settlement' => 'bg-green-100 text-green-700',
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'expire' => 'bg-red-100 text-red-700',
                            'cancel' => 'bg-gray-100 text-gray-700',
                        ][$transaksi->status] ?? 'bg-blue-100 text-blue-700';
                    @endphp
                    <span class="{{ $color }} px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest">
                        {{ $transaksi->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 mb-1">Metode Pembayaran</p>
                        <p class="text-gray-800 font-semibold uppercase">{{ $transaksi->metode ?? 'Belum dipilih' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 mb-1">Waktu Pembayaran</p>
                        <p class="text-gray-800 font-semibold">
                            {{ $transaksi->tanggal_bayar ? \Carbon\Carbon::parse($transaksi->tanggal_bayar)->format('d M Y, H:i') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 mb-1">Transaction ID (Midtrans)</p>
                        <p class="text-gray-600 text-sm font-mono">{{ $transaksi->transaction_id ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 mb-1">Total Bayar</p>
                        <p class="text-2xl font-extrabold text-red-600">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Paket</h3>
                <div class="flex justify-between items-center py-4 border-t border-gray-50">
                    <span class="text-gray-600">Nama Paket</span>
                    <span class="font-bold text-gray-800">{{ $transaksi->pemesanan->paket->nama_paket }}</span>
                </div>
                <div class="flex justify-between items-center py-4 border-t border-gray-50">
                    <span class="text-gray-600">Jenis Paket</span>
                    <span class="bg-red-50 text-red-600 px-3 py-1 rounded text-xs font-bold">{{ $transaksi->pemesanan->paket->jenis }}</span>
                </div>
                <div class="flex justify-between items-center py-4 border-t border-gray-50">
                    <span class="text-gray-600">Durasi Aktif</span>
                    <span class="text-gray-800">{{ $transaksi->pemesanan->paket->durasi }} Hari</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 sticky top-10">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Profil Pembayar</h3>
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 text-xl">{{ $transaksi->member->nama }}</h4>
                    <p class="text-gray-500 text-sm">{{ $transaksi->member->email }}</p>
                </div>
                <div class="space-y-4 pt-6 border-t border-gray-50">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">No. Handphone</p>
                        <p class="text-gray-700">{{ $transaksi->member->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Status Member</p>
                        <p class="text-gray-700 font-semibold">{{ $transaksi->member->status_membership }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>