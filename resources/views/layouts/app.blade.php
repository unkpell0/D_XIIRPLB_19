<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}

    <title>@yield('title', 'AYORENT')</title>

    {{-- icon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    {{-- tailwind css --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Custom Dark Mode and Responsive Styles -->

    @yield('styles')
    <style>
        :root {
            --background-color: #ffffff;
            --text-color: #000000;
        }

        [data-theme="dark"] {
            --background-color: #181818;
            --text-color: #e4e4e4;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Pastikan tinggi halaman penuh layar */
            margin: 0;
        }

        #app {
            flex: 1;
            /* Membuat elemen ini mengisi sisa ruang antara header dan footer */
            display: flex;
            flex-direction: column;
        }

        /* Switch Button Styling */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        /* Rounded switch */
        .slider.round {
            border-radius: 20px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        /* Custom media queries for responsiveness */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 16px;
            }

            .navbar-nav .nav-link {
                font-size: 14px;
            }

            .custom-footer {
                font-size: 12px;
            }
        }

        @media (min-width: 768px) {
            .custom-footer {
                font-size: 16px;
            }

            .card {
                margin-bottom: 1rem;
            }

            .card-img-top {
                height: 200px;
                object-fit: cover;
            }
        }

        footer {
            flex-shrink: 0;
            text-align: center;
            background-color: #f8f9fa;
            padding: 1rem;
        }

        main {
            flex: 1;
            /* Konten utama memenuhi ruang yang tersedia */
        }
    </style>
</head>

<body data-theme="light" class="h-screen">
    <div id="app">
        @if (Request::is('login') || Request::is('register'))
            @include('components.navbar2');
        @else
            {{-- <x-navbar></x-navbar> --}}
            @include('components.navbar');
        @endif

        {{-- @include('components.dark-mode') --}}

        <main class="py-2">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="custom-footer align-bottom text-center mt-5 py-4">
            <p>&copy; 2024 AYORENT. Projek UAS.</p>
        </footer>
    </div>

    {{-- <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script> --}}

    <!-- Dark Mode Script -->
    @stack('scripts')
    <script>
        const darkModeSwitch = document.getElementById('darkModeSwitch');
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.body.setAttribute('data-theme', currentTheme);

        // Set switch position based on the current theme
        if (currentTheme === 'dark') {
            darkModeSwitch.checked = true;
        }

        darkModeSwitch.addEventListener('change', function() {
            let theme = document.body.getAttribute('data-theme');
            if (theme === 'light') {
                document.body.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
