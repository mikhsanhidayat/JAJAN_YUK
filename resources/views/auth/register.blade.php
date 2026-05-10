<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar - JajanYuk</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-['Figtree']">
    
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-orange-400 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-orange-600 rounded-full blur-[120px]"></div>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/80 backdrop-blur-lg shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-white/20 overflow-hidden sm:rounded-[2.5rem] relative z-10">
            
            <div class="text-center mb-8">
                <h1 class="text-[#ff6b35] font-black text-3xl tracking-tight">JajanYuk</h1>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-1">Buat Akun Baru</p>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="nama" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">👤</span>
                        <input id="nama" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm" 
                               type="text" name="nama" value="{{ old('nama') }}" required autofocus placeholder="name" />
                    </div>
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">✉️</span>
                        <input id="email" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm" 
                               type="email" name="email" value="{{ old('email') }}" required placeholder="email@anda.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="role" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Daftar Sebagai</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">🚀</span>
                        <select id="role" name="role" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm appearance-none">
                            <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli (Cari Jajanan)</option>
                            <option value="pedagang" {{ old('role') == 'pedagang' ? 'selected' : '' }}>Pedagang (Jualan Jajanan)</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Password</label>
                        <div class="relative group">
                            <input id="password" class="block w-full px-4 pr-12 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm" 
                                   type="password" name="password" required autocomplete="new-password" placeholder="••••••" />
                            
                            <button type="button" onclick="toggleVisibility('password', 'eye-open-pass', 'eye-open-outer-pass', 'eye-closed-pass')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path id="eye-open-pass" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path id="eye-open-outer-pass" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path id="eye-closed-pass" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.076m3.313-3.313A9.959 9.959 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.105-2.105L12 12m0 0L3 3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Konfirmasi</label>
                        <div class="relative group">
                            <input id="password_confirmation" class="block w-full px-4 pr-12 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm" 
                                   type="password" name="password_confirmation" required placeholder="••••••" />
                            
                            <button type="button" onclick="toggleVisibility('password_confirmation', 'eye-open-conf', 'eye-open-outer-conf', 'eye-closed-conf')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path id="eye-open-conf" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path id="eye-open-outer-conf" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path id="eye-closed-conf" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.076m3.313-3.313A9.959 9.959 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.105-2.105L12 12m0 0L3 3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <label for="foto_profil" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Foto Profil</label>
                    <input id="foto_profil" class="block w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200" 
                           type="file" name="foto_profil" accept="image/*" />
                    <x-input-error :messages="$errors->get('foto_profil')" class="mt-1" />
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-1" />

                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#ff6b35] hover:bg-[#e85a2a] text-white font-black py-4 rounded-2xl shadow-lg shadow-orange-200 transition-all transform active:scale-[0.98] mb-4 tracking-widest uppercase">
                        DAFTAR SEKARANG
                    </button>
                    
                    <div class="text-center">
                        <p class="text-sm text-gray-500">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-[#ff6b35] font-bold hover:underline">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </div>
            </form>
        </div>

        <p class="mt-8 text-[10px] text-gray-400 font-medium uppercase tracking-widest relative z-10">
            &copy; 2026 JajanYuk - Tasikmalaya Street Food
        </p>
    </div>

    <script>
        function toggleVisibility(inputId, openId, outerId, closedId) {
            const passwordInput = document.getElementById(inputId);
            const eyeOpen = document.getElementById(openId);
            const eyeOpenOuter = document.getElementById(outerId);
            const eyeClosed = document.getElementById(closedId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeOpenOuter.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeOpenOuter.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

</body>
</html>