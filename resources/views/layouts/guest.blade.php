<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'JajanYuk') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Navigation Header -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo & Brand -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                            <div class="text-2xl font-black text-orange-500">🎉 JajanYuk</div>
                        </a>
                    </div>

                    <!-- Right Side Menu -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-orange-600 font-semibold transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">
                            Daftar
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gradient-to-b from-gray-50 to-gray-100">
            <div class="w-full sm:max-w-2xl mt-6 px-6 py-4">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-3 gap-8 mb-8">
                    <div>
                        <h3 class="text-white font-bold mb-4">JajanYuk</h3>
                        <p class="text-sm">Platform jajanan lokal Tasikmalaya yang terpercaya dan mudah digunakan.</p>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Link Cepat</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white">Daftar</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Kontak</h4>
                        <p class="text-sm">Email: support@jajanyuk.com</p>
                        <p class="text-sm">WA: +62 XXX XXXX XXXX</p>
                    </div>
                </div>
                <div class="border-t border-gray-700 pt-8 text-center text-sm">
                    {{ config('app.name', 'JajanYuk') }} © 2026. Semua hak dilindungi.
                </div>
            </div>
        </footer>
    </body>
</html>
