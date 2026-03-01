<aside class="w-64 bg-white flex flex-col justify-between h-screen shadow-[4px_0_24px_rgba(0,0,0,0.03)] flex-shrink-0">
    <div>
        <div class="flex items-center justify-center h-28 border-b border-gray-100">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold text-xl">
                    h
                </div>
                <span class="text-xl font-extrabold text-gray-800 tracking-tight">happy<span class="text-red-600">gym</span></span>
            </a>
        </div>

        <nav class="mt-8 px-4 space-y-2">
            <a href="{{ url('/member') }}" class="block py-3 px-4 rounded-lg transition duration-200 {{ request()->is('member*') ? 'bg-red-50 text-[#db3535] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-[#db3535]' }}">
                Member
            </a>
            <a href="{{ url('/instruktur') }}" class="block py-3 px-4 rounded-lg transition duration-200 {{ request()->is('instruktur*') ? 'bg-red-50 text-[#db3535] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-[#db3535]' }}">
                Personal Trainer
            </a>
            <a href="{{ url('/paket') }}" class="block py-3 px-4 rounded-lg transition duration-200 {{ request()->is('paket*') ? 'bg-red-50 text-[#db3535] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-[#db3535]' }}">
                Paket
            </a>
            <a href="{{ url('/transaksi') }}" class="block py-3 px-4 rounded-lg transition duration-200 {{ request()->is('transaksi*') ? 'bg-red-50 text-[#db3535] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-[#db3535]' }}">
                Transaksi
            </a>
            <a href="{{ url('/pengumuman') }}" class="block py-3 px-4 rounded-lg transition duration-200 {{ request()->is('pengumuman*') ? 'bg-red-50 text-[#db3535] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-[#db3535]' }}">
                Pengumuman
            </a>
            <a href="{{ url('/lokasi') }}" class="block py-3 px-4 rounded-lg transition duration-200 {{ request()->is('lokasi*') ? 'bg-red-50 text-[#db3535] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-[#db3535]' }}">
                Lokasi
            </a>
        </nav>
    </div>

    <div class="p-6 mb-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-[#db3535] hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md transition duration-200">
                Logout
            </button>
        </form>
    </div>
</aside>