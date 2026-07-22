<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-100 antialiased bg-slate-950">
        <div class="min-h-screen relative overflow-hidden bg-[radial-gradient(circle_at_top,_rgba(248,191,29,0.16),_transparent_18%),radial-gradient(circle_at_bottom_left,_rgba(245,158,11,0.12),_transparent_18%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_22%),#020617]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.06),_transparent_25%),radial-gradient(circle_at_center,_rgba(226,232,240,0.02),_transparent_20%)] pointer-events-none"></div>

            <div class="relative z-10 flex min-h-screen flex-col w-full">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
