<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JajanYuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4">
        <div class="w-full max-w-md bg-white p-10 rounded-[3rem] shadow-2xl shadow-orange-100 border border-gray-100">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black text-orange-500 tracking-tight">JajanYuk</h1>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Masuk ke Akun Anda</p>
            </div>

            @if ($errors->has('email') || $errors->has('password'))
                <div id="alert-login" class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm">
                    <div class="flex-shrink-0 text-red-500 text-lg">⚠️</div>
                    <div class="ml-3">
                        <p class="text-xs font-bold text-red-800 uppercase tracking-tight">
                            Username atau password tidak sesuai
                        </p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider ml-4 mb-1">Email</label>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-orange-500 text-lg">📧</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="w-full pl-14 pr-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all duration-300 text-sm font-medium shadow-sm outline-none"
                            placeholder="email@anda.com">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider ml-4 mb-1">Password</label>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-orange-500 text-lg">🔒</span>
                        
                        <input id="password" type="password" name="password" required 
                            class="w-full pl-14 pr-14 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all duration-300 text-sm font-medium shadow-sm outline-none"
                            placeholder="••••••">

                        <button type="button" onclick="togglePassword()" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors focus:outline-none">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path id="eye-open-outer" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <path id="eye-closed" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.076m3.313-3.313A9.959 9.959 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.105-2.105L12 12m0 0L3 3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between px-2">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500" name="remember">
                        <span class="ms-2 text-xs font-bold text-gray-400 uppercase tracking-tight">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-orange-500 hover:underline uppercase tracking-tight" href="{{ route('password.request') }}">
                            Lupa?
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-2xl shadow-lg shadow-orange-200 transition-all active:scale-95 uppercase tracking-widest text-sm">
                        Masuk Sekarang
                    </button>
                </div>

                <div class="text-center mt-6">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-tight">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-orange-500 underline">Daftar di sini</a>
                    </p>
                </div>
            </form>
        </div>

        <p class="mt-8 text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">
            © 2026 JAJANYUK - TASIKMALAYA STREET FOOD
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeOpenOuter = document.getElementById('eye-open-outer');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                // Ubah ke text
                passwordInput.type = 'text';
                // Sembunyikan mata terbuka, munculkan mata tertutup
                eyeOpen.classList.add('hidden');
                eyeOpenOuter.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                // Ubah ke password
                passwordInput.type = 'password';
                // Munculkan mata terbuka, sembunyikan mata tertutup
                eyeOpen.classList.remove('hidden');
                eyeOpenOuter.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>