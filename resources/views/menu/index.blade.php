<x-app-layout>

    @include('layouts.header')

    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            
            <div class="mb-10 flex justify-end">
                <button onclick="toggleModal('modal-menu')" class="bg-orange-500 hover:bg-orange-600 text-white font-black px-8 py-4 rounded-[2rem] shadow-lg shadow-orange-200 transition-all active:scale-95 uppercase tracking-widest text-xs flex items-center gap-2">
                    <span class="text-xl">+</span> Tambah Menu Baru
                </button>
            </div>

            @if(session('success'))
            <div id="alert-success" class="fixed top-24 right-6 z-50 flex items-center gap-3 px-6 py-4 bg-green-50 border-l-4 border-green-500 rounded-xl shadow-lg animate-fade-in">
                <div class="flex-shrink-0 text-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-green-800">Berhasil!</p>
                    <p class="text-xs text-green-700">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('alert-success').remove()" class="ml-2 text-green-400 hover:text-green-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($menus as $menu)
                <div class="bg-white rounded-[3rem] p-6 shadow-2xl shadow-orange-100 border border-gray-50 relative group transition-all hover:-translate-y-2">
                    
                    <div class="absolute top-6 left-6 z-10">
                        <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $menu->stok_status ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $menu->stok_status ? '● Tersedia' : '● Habis' }}
                        </span>
                    </div>

                    <div class="w-full h-48 rounded-[2.5rem] overflow-hidden mb-6 bg-gray-100 border-4 border-white shadow-inner">
                        <img src="{{ asset('storage/' . $menu->foto_produk) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $menu->nama_produk }}">
                    </div>

                    <div class="px-2">
                        <h3 class="text-xl font-black text-gray-800 tracking-tight leading-tight mb-1">{{ $menu->nama_produk }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-4">Mulai Dari</p>
                        
                        <div class="flex justify-between items-end">
                            <span class="text-2xl font-black text-[#ff6b35]">Rp {{ number_format($menu->harga_minimal, 0, ',', '.') }}</span>
                            <div class="flex gap-2">
                                <button onclick="openEditModal({{ $menu->id }}, '{{ $menu->nama_produk }}', '{{ $menu->tipe_harga }}', {{ $menu->harga_minimal }})" 
                                        class="p-3 bg-gray-50 hover:bg-orange-50 rounded-2xl text-gray-400 hover:text-orange-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </button>

                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini dari katalog?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-3 bg-gray-50 hover:bg-red-50 rounded-2xl text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full flex flex-col items-center py-20 opacity-50">
                    <span class="text-6xl mb-4">🍱</span>
                    <p class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Belum Ada Menu Jajanan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modals (Add & Edit) remain the same -->
    <div id="modal-menu" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-lg rounded-[3rem] shadow-2xl p-10 animate-scale-in border border-white my-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Tambah Menu</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Isi Detail Jajanan</p>
                </div>
                <button onclick="toggleModal('modal-menu')" class="text-gray-300 hover:text-red-500 transition-colors text-2xl">×</button>
            </div>

            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2">Nama Jajanan</label>
                    <input type="text" name="nama_produk" required placeholder="Contoh: Seblak Tulang Mercon"
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all outline-none text-sm font-medium shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2">Tipe Harga</label>
                        <select name="tipe_harga" class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all outline-none text-sm font-medium shadow-sm appearance-none cursor-pointer">
                            <option value="pas">Harga Pas</option>
                            <option value="custom">Harga Custom</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2">Harga (Rp)</label>
                        <input type="number" name="harga_minimal" required placeholder="5000"
                            class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all outline-none text-sm font-medium shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2">Foto Produk</label>
                    <div onclick="document.getElementById('input-foto-menu').click()" 
                        class="relative cursor-pointer py-6 border-2 border-dashed border-gray-100 rounded-3xl bg-gray-50 hover:bg-orange-50 transition-all text-center group">
                        <span id="label-foto" class="text-[10px] font-black text-gray-400 uppercase group-hover:text-orange-500 tracking-widest">Klik Untuk Pilih Foto</span>
                        <input type="file" name="foto_produk" id="input-foto-menu" class="hidden" accept="image/*" onchange="updateLabel(this, 'label-foto')">
                    </div>
                </div>

                <button type="submit" class="w-full py-5 bg-[#ff6b35] hover:bg-[#e85a2a] text-white font-black rounded-2xl shadow-xl shadow-orange-200 transition-all active:scale-95 uppercase tracking-[0.2em] text-xs">
                    Simpan ke Katalog
                </button>
            </form>
        </div>
    </div>

    <div id="modal-edit-menu" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-lg rounded-[3rem] shadow-2xl p-10 animate-scale-in border border-white my-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Edit Menu</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Ubah Detail Jajanan</p>
                </div>
                <button onclick="toggleModal('modal-edit-menu')" class="text-gray-300 hover:text-red-500 transition-colors text-2xl">×</button>
            </div>

            <form id="edit-menu-form" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf 
                @method('PUT')
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2">Nama Jajanan</label>
                    <input type="text" name="nama_produk" id="edit-nama-produk" required
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all outline-none text-sm font-medium shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2">Tipe Harga</label>
                        <select name="tipe_harga" id="edit-tipe-harga" class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all outline-none text-sm font-medium shadow-sm appearance-none cursor-pointer">
                            <option value="pas">Harga Pas</option>
                            <option value="custom">Harga Custom</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2">Harga (Rp)</label>
                        <input type="number" name="harga_minimal" id="edit-harga-minimal" required
                            class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl transition-all outline-none text-sm font-medium shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2">Foto Produk</label>
                    <div class="mb-2 text-[9px] text-orange-600 font-bold uppercase tracking-tight">* Kosongkan jika tidak ingin mengganti foto</div>
                    <div onclick="document.getElementById('input-edit-foto-menu').click()" 
                        class="relative cursor-pointer py-6 border-2 border-dashed border-gray-100 rounded-3xl bg-gray-50 hover:bg-orange-50 transition-all text-center group">
                        <span id="label-edit-foto" class="text-[10px] font-black text-gray-400 uppercase group-hover:text-orange-500 tracking-widest">Klik Untuk Ganti Foto</span>
                        <input type="file" name="foto_produk" id="input-edit-foto-menu" class="hidden" accept="image/*" onchange="updateLabel(this, 'label-edit-foto')">
                    </div>
                </div>

                <button type="submit" class="w-full py-5 bg-[#ff6b35] hover:bg-[#e85a2a] text-white font-black rounded-2xl shadow-xl shadow-orange-200 transition-all active:scale-95 uppercase tracking-[0.2em] text-xs">
                    Update Menu
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes scale-in {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-scale-in { animation: scale-in 0.3s ease-out forwards; }

        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }

        @keyframes fade-out {
            0% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-10px); }
        }
        .animate-fade-out { animation: fade-out 0.4s ease-out forwards; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertSuccess = document.getElementById('alert-success');
            if (alertSuccess) {
                setTimeout(function() {
                    alertSuccess.classList.remove('animate-fade-in');
                    alertSuccess.classList.add('animate-fade-out');
                    setTimeout(function() {
                        alertSuccess.remove();
                    }, 400);
                }, 5000);
            }
        });

        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function updateLabel(input, labelId) {
            const label = document.getElementById(labelId);
            if (input.files.length > 0) {
                label.innerText = "Terpilih: " + input.files[0].name;
                label.classList.add('text-orange-600');
            }
        }

        function openEditModal(id, nama, tipe, harga) {
            const editForm = document.getElementById('edit-menu-form');
            editForm.action = `/menu/${id}`; 
            document.getElementById('edit-nama-produk').value = nama;
            document.getElementById('edit-tipe-harga').value = tipe;
            document.getElementById('edit-harga-minimal').value = harga;
            const labelFoto = document.getElementById('label-edit-foto');
            labelFoto.innerText = "Klik Untuk Ganti Foto";
            labelFoto.classList.remove('text-orange-600');
            toggleModal('modal-edit-menu');
        }
    </script>
</x-app-layout>