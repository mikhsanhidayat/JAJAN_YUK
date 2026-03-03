<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

     <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    
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

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="nama" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">👤</span>
                        <input id="nama" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm" 
                               type="text" name="nama" :value="old('nama')" required autofocus placeholder="Contoh: Budi Jajanan" />
                    </div>
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">✉️</span>
                        <input id="email" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm" 
                               type="email" name="email" :value="old('email')" required placeholder="email@anda.com" />
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
                        <input id="password" class="block w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm" 
                               type="password" name="password" required autocomplete="new-password" placeholder="••••••" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider ml-1 mb-1">Konfirmasi</label>
                        <input id="password_confirmation" class="block w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all text-sm shadow-sm" 
                               type="password" name="password_confirmation" required placeholder="••••••" />
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />

                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#ff6b35] hover:bg-[#e85a2a] text-white font-bold py-4 rounded-2xl shadow-lg shadow-orange-200 transition-all transform active:scale-[0.98] mb-4">
                        {{ __('DAFTAR SEKARANG') }}
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
            &copy; 2024 JajanYuk - Tasikmalaya Street Food
        </p>
    </div>

</body>
</html>