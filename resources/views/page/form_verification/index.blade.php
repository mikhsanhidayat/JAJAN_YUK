<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h2 class="text-[#ff6b35] font-black text-3xl tracking-tight uppercase">Panel Verifikasi</h2>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-1">Konfirmasi Pembayaran
                        Pedagang</p>
                </div>
                <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100">
                    <span class="text-sm font-bold text-gray-600">Total Pengajuan: </span>
                    <span class="text-sm font-black text-[#ff6b35]">{{ $verifikasi->count() }}</span>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-white overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-orange-50/50">
                                <th class="px-6 py-5 text-[10px] font-black text-orange-600 uppercase tracking-widest">
                                    Pedagang</th>
                                <th class="px-6 py-5 text-[10px] font-black text-orange-600 uppercase tracking-widest">
                                    Toko</th>
                                <th class="px-6 py-5 text-[10px] font-black text-orange-600 uppercase tracking-widest">
                                    Status Aktif</th>
                                <th class="px-6 py-5 text-[10px] font-black text-orange-600 uppercase tracking-widest">
                                    Bukti Transfer</th>
                                <th
                                    class="px-6 py-5 text-[10px] font-black text-orange-600 uppercase tracking-widest text-center">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($verifikasi as $item)
                                <tr class="hover:bg-orange-50/20 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gray-200 rounded-full overflow-hidden border-2 border-white shadow-sm">
                                                <img src="{{ $item->user->foto_profil ? asset('storage/' . $item->user->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($item->user->nama) }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-gray-800">{{ $item->user->nama }}</p>
                                                <p class="text-[10px] text-gray-400 font-medium">
                                                    {{ $item->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-sm font-bold text-gray-600">
                                            {{ $item->user->pedagang->nama_toko ?? 'Belum Daftar Toko' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        @if ($item->user->pedagang && $item->user->pedagang->is_active)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase bg-green-100 text-green-600 tracking-wider">
                                                ● Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase bg-red-100 text-red-600 tracking-wider">
                                                ● Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <a href="{{ asset($item->bukti_transfer) }}" target="_blank"
                                            class="group flex items-center gap-2 text-[#ff6b35] hover:text-orange-700 transition-all">
                                            <div
                                                class="p-2 bg-orange-100 rounded-lg group-hover:scale-110 transition-transform">
                                                📸
                                            </div>
                                            <span class="text-[11px] font-black uppercase">Lihat Foto</span>
                                        </a>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <form action="{{ route('verifikasi.approve', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin memverifikasi pedagang ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="bg-[#ff6b35] hover:bg-[#e85a2a] text-white text-[10px] font-black px-4 py-2 rounded-xl shadow-md shadow-orange-100 transition-all active:scale-95 uppercase">
                                                Verifikasi Sekarang
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($verifikasi->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <span class="text-4xl mb-4">📥</span>
                                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.2em]">
                                                Belum ada data verifikasi masuk</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="mt-8 text-center text-[10px] text-gray-400 font-bold uppercase tracking-[0.3em]">
                Administrator System JajanYuk v1.0
            </p>
        </div>
    </div>
</x-app-layout>
