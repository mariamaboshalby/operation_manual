<!DOCTYPE html>
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
    </head>
    <body class="font-sans text-slate-100 antialiased bg-slate-950">
        <div class="min-h-screen relative overflow-hidden bg-[radial-gradient(circle_at_top,_rgba(248,191,29,0.14),_transparent_18%),radial-gradient(circle_at_bottom_left,_rgba(245,158,11,0.12),_transparent_18%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_22%),#020617]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.06),_transparent_25%),radial-gradient(circle_at_center,_rgba(226,232,240,0.02),_transparent_20%)] pointer-events-none"></div>

            <div class="relative z-10 flex min-h-screen flex-col px-4 pt-6 sm:px-6">
                <div class="flex items-center justify-between">
                    <a href="/" class="inline-flex items-center gap-2 text-sm text-slate-200 hover:text-amber-200 transition">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-900/75 border border-slate-700 text-amber-300 shadow-glow">☕</span>
                        <span class="font-semibold">العودة للرئيسية</span>
                    </a>
                    <div class="text-right text-2xl font-semibold tracking-wide text-amber-200">Barista Academy</div>
                </div>

                <div class="mt-10 flex flex-1 items-center justify-center">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-900/85 p-8 shadow-[0_40px_120px_-60px_rgba(255,190,11,0.75)] backdrop-blur-xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
