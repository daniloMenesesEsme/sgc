<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SGC - Sistema de Gestão Comercial</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            input[type="text"], 
            input[type="email"], 
            input[type="password"], 
            textarea, 
            select {
                width: 100%;
                border-radius: 0.375rem;
                border-color: #d1d5db;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            }
            input[type="text"]:focus, 
            input[type="email"]:focus, 
            input[type="password"]:focus, 
            textarea:focus, 
            select:focus {
                border-color: #6366f1;
                outline: none;
                box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
            }
            input[type="checkbox"] {
                border-radius: 0.25rem;
                border-color: #d1d5db;
            }
            input[type="checkbox"]:focus {
                border-color: #6366f1;
                outline: none;
                box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/" class="flex items-center justify-center">
                    <i class="fas fa-store text-6xl text-blue-600"></i>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} SGC. Todos os direitos reservados.
            </div>
        </div>
    </body>
</html>
