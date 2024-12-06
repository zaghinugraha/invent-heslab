<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            .bg-cover {
                background-image: url('{{ asset('images/background.jpg') }}');
                background-size: cover;
                background-position: center;
                position: relative;
            }
            .bg-cover::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8); /* Adjust the opacity as needed */
                z-index: 0;
            }
            .content {
                position: relative;
                z-index: 1;
            }
        </style>

        
    </head>
    <body class="bg-cover flex items-center justify-center h-screen">
        <div class="text-center content">
            <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-24 h-28 mx-auto mb-4">
            <h1 class="text-2xl font-bold mb-6 text-white">Selamat datang di HES Vault</h1>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded w-32 hover:bg-blue-600">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-500 text-white rounded w-32 hover:bg-blue-600">Register</a>
            </div>
        </div>
    </body>
</html>