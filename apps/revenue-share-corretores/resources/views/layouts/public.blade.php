<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta-title')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-4 py-3">
            <a href="{{ route('home') }}" class="text-lg font-semibold text-slate-800" wire:navigate>
                {{ config('app.name', 'Imóveis') }}
            </a>
            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="text-slate-600 hover:text-slate-900" wire:navigate>Imóveis</a>
                <a href="{{ route('broker.login') }}" class="text-indigo-600 hover:text-indigo-800">Área do corretor</a>
            </nav>
        </div>
    </header>
    <main class="mx-auto max-w-6xl p-4 md:p-6">
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>
