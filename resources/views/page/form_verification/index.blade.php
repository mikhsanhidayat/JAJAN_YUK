<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Pembayaran - JajanYuk</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-['Figtree'] bg-gray-50">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden px-4">

        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-[-5%] right-[-5%] w-[50%] h-[50%] bg-orange-400 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-orange-600 rounded-full blur-[120px]">
            </div>
        </div>

        <div
            class="w-full sm:max-w-md bg-white/80 backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-white/40 overflow-hidden rounded-[3rem] relative z-10 p-10">

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-3xl mb-4">
                    <span class="text-3xl">🧾</span>
                </div>
                <h1 class="text-[#ff6b35] font-black text-2xl tracking-tight uppercase">Verifikasi Akun</h1>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-2">Unggah Bukti Transfer
                    Anda</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('verifikasi.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                <div class="bg-orange-50/50 border border-orange-100 rounded-2xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <span class="text-orange-500">💡</span>
                        <div class="text-[11px] text-orange-800 leading-relaxed font-medium">
                            Akun: <span class="font-black">{{ auth()->user()->nama }}</span> (ID:
                            {{ auth()->user()->id }}) <br>
                            Unggah bukti transfer untuk memulai proses verifikasi.
                        </div>
                    </div>
                </div>

                <div>
                    <label for="bukti_transfer"
                        class="block text-xs font-black text-gray-400 uppercase tracking-wider ml-2 mb-2">Upload Bukti
                        Transfer</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-xl">
                            📸
                        </div>
                        <input id="bukti_transfer" type="file" name="bukti_transfer" accept="image/*" required
                            class="block w-full pl-14 pr-4 py-4 bg-gray-50/50 border-2 border-dashed border-gray-200 rounded-[2rem] text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-xs file:font-black
                          file:bg-orange-50 file:text-orange-600
                          hover:file:bg-orange-100
                          focus:outline-none focus:border-orange-500 transition-all cursor-pointer" />
                    </div>
                    <x-input-error :messages="$errors->get('bukti_transfer')" class="mt-2 ml-2" />
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-[#ff6b35] hover:bg-[#e85a2a] text-white font-black py-4 rounded-[2rem] shadow-lg shadow-orange-200 transition-all transform active:scale-[0.98] tracking-widest uppercase text-sm">
                        Kirim Verifikasi
                    </button>

                    <a href="{{ url('/') }}"
                        class="block text-center mt-6 text-[10px] text-gray-400 font-bold uppercase tracking-widest hover:text-orange-500 transition-colors">
                        Kembali Ke Beranda
                    </a>
                </div>
            </form>
        </div>

        <p class="mt-8 text-[10px] text-gray-400 font-bold uppercase tracking-[0.3em] relative z-10">
            © 2026 JAJANYUK - TASIKMALAYA STREET FOOD
        </p>
    </div>

</body>

</html>
