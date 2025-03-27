<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('scripts')
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div id="app">
        <x-navigation></x-navigation>

        <div class="flex h-screen">
            <!-- Sidebar -->
            <aside class="bg-white w-64 shadow-md">
                <div class="p-4">
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="block py-2 px-4 text-gray-700 font-medium rounded hover:bg-green-100
                                {{ request()->is('admin.dashboard') ? 'bg-green-100 text-green-700 font-semibold' : '' }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.history') }}"
                                class="block py-2 px-4 text-gray-700 font-medium rounded hover:bg-green-100
                                {{ request()->is('admin.history') ? 'bg-green-100 text-green-700 font-semibold' : '' }}">
                                History
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('car.index') }}"
                                class="block py-2 px-4 text-gray-700 font-medium rounded hover:bg-green-100
                                {{ request()->is('car') ? 'bg-green-100 text-green-700 font-semibold' : '' }}">
                                Cars
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-200 text-center py-4">
            <p class="text-gray-600 text-sm">&copy; 2024 AYORENT - Admin Panel</p>
        </footer>
    </div>

    <!-- Scripts -->
    @livewireScripts
</body>

</html>
