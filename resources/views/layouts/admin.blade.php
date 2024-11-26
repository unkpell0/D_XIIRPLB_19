<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard | AYORENT')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Custom Styles -->
    @yield('styles')
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div id="app">
        <!-- Navbar -->
        <nav class="bg-green-600 text-white">
            <div class="max-w-screen px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">Admin Dashboard</a>
                    </div>
                    <div>
                        <a href="{{ route('logout') }}"
                            class="text-sm font-medium hover:bg-green-500 px-4 py-2 rounded">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

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
    @yield('scripts')
</body>

</html>
