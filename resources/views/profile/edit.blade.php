<x-app-layout>
   @include('layouts.header')

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div
                class="p-6 sm:p-10 bg-white shadow-xl shadow-orange-100/50 rounded-[2rem] border border-orange-50 transition hover:border-orange-200">
                <div class="max-w-xl">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 bg-orange-100 rounded-2xl text-orange-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Informasi Pribadi</h3>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div
                class="p-6 sm:p-10 bg-white shadow-xl shadow-orange-100/50 rounded-[2rem] border border-orange-50 transition hover:border-orange-200">
                <div class="max-w-xl">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 bg-orange-100 rounded-2xl text-orange-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Keamanan Akun</h3>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div
                class="p-6 sm:p-10 bg-white shadow-xl shadow-red-50 rounded-[2rem] border border-red-50 transition hover:border-red-200">
                <div class="max-w-xl">
                    <div class="flex items-center space-x-4 mb-6 text-red-500">
                        <div class="p-3 bg-red-100 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">Hapus Akun</h3>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
