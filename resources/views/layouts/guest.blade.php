<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SMAN 1 PLUTO - Portal Guru</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS with Brand colors -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316', // Primary Orange
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50/50">
        
        {{-- Minimalist Header/Logo --}}
        <div class="mb-6">
            <a href="/" class="flex flex-col items-center justify-center gap-1 group">

                <span class="text-slate-900 font-extrabold text-lg tracking-tight font-heading mt-2">SMAN 1 PLUTO</span>
                <span class="text-[0.65rem] text-slate-400 font-bold tracking-widest uppercase">Portal Guru</span>
            </a>
        </div>

        {{-- Centered form card --}}
        <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white border border-slate-200/80 shadow-xl shadow-slate-100/50 overflow-hidden sm:rounded-2xl">
            {{ $slot }}
        </div>
        
    </div>
</body>
</html>
