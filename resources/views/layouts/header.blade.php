    <!-- HEADER SECTION: Added 'sticky top-0 z-40' to make it fixed on scroll -->
    <div class="sticky top-0 z-40 bg-gray-50 backdrop-blur-md border-b border-orange-100 shadow-sm">
        <div class="w-full py-6 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between">
                    <div class="w-48 text-left">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-4 py-2 bg-orange-50 text-orange-500 text-sm font-bold rounded-xl hover:bg-orange-500 hover:text-white transition-all duration-300 shadow-sm border border-orange-100 group">
                            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Dashboard
                        </a>
                    </div>

                    <div class="flex-1 text-center">
                        <h2 class="text-2xl md:text-3xl font-black text-orange-500 uppercase tracking-tight leading-tight">
                            Katalog Menu
                        </h2>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500 font-medium">
                            Kelola Jajanan di Toko Anda
                        </p>
                    </div>

                    <div class="hidden md:block w-48"></div>
                </div>
            </div>
        </div>
    </div>