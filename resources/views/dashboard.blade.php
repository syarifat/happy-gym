<x-app-layout>
<style>
    .stat-card {
        position: relative;
        overflow: hidden;
        border-radius: 1.25rem;
        padding: 1.5rem;
        color: white;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.18); }
    .stat-card::after {
        content: '';
        position: absolute;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        right: -30px;
        bottom: -30px;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        right: 60px;
        bottom: 30px;
    }
    .stat-card .stat-icon {
        width: 48px; height: 48px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
    }
    .stat-card .stat-label { font-size: 0.8rem; opacity: 0.85; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
    .stat-card .stat-value { font-size: 2rem; font-weight: 800; line-height: 1; }
    .filter-pill {
        background: white;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        border: 1.5px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.15s;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%23dc2626' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        padding-right: 1.8rem;
    }
    .filter-pill:hover, .filter-pill:focus { border-color: #dc2626; color: #dc2626; outline: none; box-shadow: 0 0 0 3px rgba(220,38,38,0.1); }
    .chart-wrapper canvas { border-radius: 0.75rem; }
    .badge-aktif { background: #dcfce7; color: #15803d; padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
    .badge-nonaktif { background: #f3f4f6; color: #6b7280; padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
</style>

{{-- ======================== HEADER ======================== --}}
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-5 mb-8">
    <div>
        <p class="text-xs font-bold text-red-500 uppercase tracking-widest mb-1">Happy Gym Admin</p>
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">Dashboard Overview</h2>
        <p class="text-sm text-gray-400 mt-1">Pantau performa gym Anda secara real-time.</p>
    </div>
    <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-2 items-center bg-white/80 backdrop-blur px-4 py-3 rounded-2xl shadow-sm border border-gray-100">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-1"><i class="bi bi-sliders"></i> Filter</span>
        <select name="cabang_id" class="filter-pill" onchange="this.form.submit()">
            <option value="">Semua Cabang</option>
            @foreach($lokasis as $lok)
                <option value="{{ $lok->lokasi_id }}" {{ request('cabang_id') == $lok->lokasi_id ? 'selected' : '' }}>{{ $lok->nama_cabang }}</option>
            @endforeach
        </select>
        <select name="rentang" class="filter-pill" onchange="this.form.submit()">
            <option value="">Semua Waktu</option>
            <option value="hari_ini" {{ request('rentang') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
            <option value="minggu_ini" {{ request('rentang') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="bulan_ini" {{ request('rentang') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="tahun_ini" {{ request('rentang') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
        </select>
    </form>
</div>

{{-- ======================== STAT CARDS ======================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl flex-shrink-0" style="background: linear-gradient(135deg,#1e40af,#3b82f6); color:white;">
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Member</p>
            <p class="text-2xl font-extrabold text-gray-900 leading-tight">{{ number_format($totalMember) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl flex-shrink-0" style="background: linear-gradient(135deg,#065f46,#10b981); color:white;">
            <i class="bi bi-person-check-fill"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Member Aktif</p>
            <p class="text-2xl font-extrabold text-gray-900 leading-tight">{{ number_format($memberAktif) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl flex-shrink-0" style="background: linear-gradient(135deg,#92400e,#f59e0b); color:white;">
            <i class="bi bi-person-badge-fill"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Instruktur</p>
            <p class="text-2xl font-extrabold text-gray-900 leading-tight">{{ number_format($totalInstruktur) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl flex-shrink-0" style="background: linear-gradient(135deg,#991b1b,#dc2626); color:white;">
            <i class="bi bi-cash-stack"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
            <p class="text-lg font-extrabold text-gray-900 leading-tight">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>

</div>

{{-- ======================== CHART + TABLE ======================== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- CHART --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 flex justify-between items-center border-b border-gray-50">
            <div>
                <h3 class="font-bold text-gray-800 text-base">Transaksi per Paket</h3>
                <p class="text-xs text-gray-400 mt-0.5">Jumlah pemesanan berdasarkan jenis paket</p>
            </div>
            <span class="text-xs bg-red-50 text-red-600 font-bold px-3 py-1 rounded-full">
                <i class="bi bi-bar-chart-fill mr-1"></i>Chart
            </span>
        </div>
        <div class="chart-wrapper p-6" style="height: 320px;">
            <canvas id="paketChart"></canvas>
        </div>
    </div>

    {{-- CABANG INFO --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-5 border-b border-gray-50">
            <h3 class="font-bold text-gray-800 text-base">Informasi Cabang</h3>
            <p class="text-xs text-gray-400 mt-0.5">Ringkasan lokasi operasional</p>
        </div>
        <div class="flex-1 flex flex-col items-center justify-center p-6 gap-4">
            <div class="w-24 h-24 rounded-2xl flex items-center justify-center text-4xl" style="background: linear-gradient(135deg, #991b1b, #dc2626); color: white; box-shadow: 0 8px 24px rgba(220,38,38,0.3);">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="text-center">
                <p class="text-4xl font-extrabold text-gray-900">{{ $totalCabang }}</p>
                <p class="text-sm text-gray-500 mt-1">Cabang Aktif</p>
            </div>
        </div>
        <div class="px-6 pb-6">
            <a href="{{ route('lokasi.index') }}" class="flex items-center justify-center gap-2 w-full text-center bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold py-3 rounded-xl transition-all hover:shadow-lg">
                <i class="bi bi-arrow-right-circle-fill"></i>
                Kelola Cabang
            </a>
        </div>
    </div>
</div>

{{-- ======================== MEMBER TABLE ======================== --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800 text-base">Pendaftar Member Terbaru</h3>
            <p class="text-xs text-gray-400 mt-0.5">5 anggota yang baru bergabung</p>
        </div>
        <a href="{{ route('member.index') }}" class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-full transition">
            Lihat Semua →
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr style="background: #f8fafc;">
                    <th class="py-3 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest">#</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Nama</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Email</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($memberTerbaru as $i => $m)
                <tr class="border-t border-gray-50 hover:bg-red-50/30 transition-colors">
                    <td class="py-4 px-6 text-sm font-bold text-gray-300">{{ $i + 1 }}</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0" style="background: linear-gradient(135deg, #dc2626, #f97316);">
                                {{ strtoupper(substr($m->nama, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">{{ $m->nama }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $m->email }}</td>
                    <td class="py-4 px-6 text-center">
                        @if($m->status_membership == 'Aktif')
                            <span class="badge-aktif">✔ Aktif</span>
                        @else
                            <span class="badge-nonaktif">✖ Non-Aktif</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center text-xs text-gray-400 font-medium">
                        {{ \Carbon\Carbon::parse($m->created_at)->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center">
                        <div class="text-gray-300 text-4xl mb-3"><i class="bi bi-inbox"></i></div>
                        <p class="text-gray-400 text-sm">Belum ada member yang terdaftar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Chart JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('paketChart').getContext('2d');
        const labels = {!! json_encode($paketLabels) !!};
        const dataValues = {!! json_encode($paketValues) !!};

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(220, 38, 38, 0.85)');
        gradient.addColorStop(1, 'rgba(249, 115, 22, 0.6)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Transaksi',
                    data: dataValues,
                    backgroundColor: gradient,
                    borderRadius: 10,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: '#9ca3af', font: { size: 11 } },
                        grid: { color: '#f3f4f6', drawBorder: false }
                    },
                    x: {
                        ticks: { color: '#6b7280', font: { size: 11, weight: '600' } },
                        grid: { display: false, drawBorder: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#f9fafb',
                        bodyColor: '#d1d5db',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(ctx) { return '  ' + ctx.raw + ' Transaksi'; }
                        }
                    }
                }
            }
        });
    });
</script>
</x-app-layout>