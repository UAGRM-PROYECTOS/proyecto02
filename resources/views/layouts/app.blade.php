<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ isDarkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': isDarkMode }"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
    x-data="{ 
        isDarkMode: {{ gmdate('H', time() - 4*3600) >= 20 || gmdate('H', time() - 4*3600) < 6 ? 'true' : 'false' }}, 
        isChildMode: localStorage.getItem('isChildMode') === 'true',
        isYoungMode: localStorage.getItem('isYoungMode') === 'true',
        counter : 0,
        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
            localStorage.setItem('theme', this.isDarkMode ? 'dark' : 'light');
        }
    }" 
    :class="{ 'dark': isDarkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" :class="{ 'dark': isDarkMode }">
    <div 
    :class="{ 'bg-gray-100 dark:bg-gray-900': !isChildMode,  'border-b border-green-500 bg-red-500': isChildMode, 'border-b border-blue-500 bg-blue-500': isYoungMode, }"
    class="min-h-screen ">
        @include('layouts.navigation')
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow dark:bg-gray-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            <div></div>
        @endisset
        
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        
    </div>


</body>

</html>
