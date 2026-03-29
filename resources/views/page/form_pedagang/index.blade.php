<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JajanYuk - Lengkapi Profil Toko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4">
        <div class="w-full max-w-lg bg-white p-10 rounded-[3rem] shadow-2xl shadow-orange-100 border border-gray-100">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black text-orange-500 tracking-tight">JajanYuk</h1>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Lengkapi Profil Toko</p>
            </div>

            @if(session('success'))
            <div id="alert-success" class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-2xl shadow-sm">
                <div class="flex-shrink-0 text-green-500 text-lg">✅</div>
                <div class="ml-3">
                    <p class="text-xs font-bold text-green-800 uppercase tracking-tight">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto text-green-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2"></path></svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div id="alert-error" class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm">
                <div class="flex-shrink-0 text-red-500 text-lg">⚠️</div>
                <div class="ml-3">
                    <p class="text-xs font-bold text-red-800 uppercase tracking-tight">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2"></path></svg>
                </button>
            </div>
            @endif

            <form method="POST" action="{{ route('pedagang.store') }}" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider ml-4 mb-1">Nama Toko</label>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-orange-500 text-lg">🏪</span>
                        <input type="text" name="nama_toko" value="{{ old('nama_toko') }}" required placeholder="Contoh: Seblak Mang Oleh"
                            class="w-full pl-14 pr-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all duration-300 text-sm font-medium shadow-sm outline-none">
                    </div>
                    @if($errors->has('nama_toko'))
                        <p class="mt-2 ml-4 text-xs text-red-500 font-semibold">{{ $errors->first('nama_toko') }}</p>
                    @endif
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider ml-4 mb-1">Jenis Jajanan</label>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-orange-500 text-lg">🍢</span>
                        <select name="jenis_jajanan" required
                            class="w-full pl-14 pr-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all duration-300 text-sm font-medium shadow-sm appearance-none outline-none cursor-pointer">
                            <option value="" disabled selected>Pilih Kategori Jajanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Makanan Ringan">Makanan Ringan</option>
                            <option value="Gorengan">Gorengan</option>
                            <option value="Pedas/Seblak">Pedas / Seblak</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider ml-4 mb-1">Foto Gerobak / Produk</label>
                    <div onclick="document.getElementById('foto_gerobak').click()" 
                         class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-100 border-dashed rounded-[2rem] bg-gray-50 hover:bg-orange-50 transition-colors group relative cursor-pointer">
                        
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-10 w-10 text-gray-300 group-hover:text-orange-400 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="font-black text-orange-500 hover:text-orange-600">Upload Foto</span>
                                <p class="pl-1" id="file-chosen">atau drag and drop</p>
                            </div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">PNG, JPG up to 2MB</p>
                        </div>

                        <input id="foto_gerobak" name="foto_gerobak" type="file" class="hidden" accept="image/*" required onchange="previewLabel(this)">
                    </div>
                    @if($errors->has('foto_gerobak'))
                        <p class="mt-2 ml-4 text-xs text-red-500 font-semibold">{{ $errors->first('foto_gerobak') }}</p>
                    @endif
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-2xl shadow-lg shadow-orange-200 transition-all active:scale-95 uppercase tracking-widest text-sm">
                        Simpan & Lanjutkan
                    </button>
                </div>

                <div class="text-center mt-6">
                    <p class="text-xs text-gray-400 font-bold">
                        Bukan Pedagang? <a href="{{ route('dashboard') }}" class="text-orange-500 underline">Kembali</a>
                    </p>
                </div>
            </form>
        </div>

        <p class="mt-8 text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">
            © 2026 JAJANYUK - TASIKMALAYA STREET FOOD
        </p>
    </div>

    <script>
        function previewLabel(input) {
            const label = document.getElementById('file-chosen');
            if (input.files && input.files.length > 0) {
                // Menampilkan nama file dan mengubah warna teks agar user tahu file masuk
                label.innerText = "Terpilih: " + input.files[0].name;
                label.classList.remove('text-gray-600');
                label.classList.add('text-orange-600', 'font-bold');
            }
        }
    </script>
</body>
</html>