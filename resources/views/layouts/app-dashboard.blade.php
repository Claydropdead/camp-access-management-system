<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Dashboard CSS - direct link -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- Page specific styles -->
    @yield('styles')
</head> 
<body>
    <div class="app-layout">
        @include('components.sidebar')
        <div class="drawer-backdrop" id="drawer-backdrop"></div>
        <div class="content-with-drawer" id="main-content">
            @include('components.navbar')
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Night mode toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSwitch = document.getElementById('theme-toggle');
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme) {
                document.documentElement.setAttribute('data-theme', currentTheme);
                if (currentTheme === 'dark') {
                    toggleSwitch.checked = true;
                }
            }
            function switchTheme(e) {
                if (e.target.checked) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.setAttribute('data-theme', 'light');
                    localStorage.setItem('theme', 'light');
                }
            }
            toggleSwitch.addEventListener('change', switchTheme, false);
            const menuToggle = document.getElementById('menu-toggle');
            const drawer = document.getElementById('app-drawer');
            const backdrop = document.getElementById('drawer-backdrop');
            function toggleDrawer() {
                drawer.classList.toggle('drawer-open');
                backdrop.classList.toggle('drawer-backdrop-visible');
            }
            menuToggle.addEventListener('click', toggleDrawer);
            backdrop.addEventListener('click', toggleDrawer);
        });
    </script>
</body>
</html>
