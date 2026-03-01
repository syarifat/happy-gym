<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-5">
            <x-text-input id="username" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4 placeholder-gray-400" 
                          type="text" 
                          name="username" 
                          :value="old('username')" 
                          required autofocus 
                          placeholder="Username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="mb-8 relative">
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4 placeholder-gray-400"
                          type="password"
                          name="password"
                          required autocomplete="current-password" 
                          placeholder="Password" />
            
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <button type="submit" class="w-full bg-[#da3535] hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md transition duration-200">
                Login
            </button>
        </div>
    </form>
</x-guest-layout>