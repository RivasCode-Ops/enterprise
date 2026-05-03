<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin — Faturamento' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-3">
            <nav class="flex flex-wrap items-center gap-5 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="{{ request()->routeIs('admin.dashboard') ? 'text-indigo-700' : 'text-slate-700 hover:text-slate-900' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.brokers') }}" wire:navigate class="{{ request()->routeIs('admin.brokers') ? 'text-indigo-700' : 'text-slate-700 hover:text-slate-900' }}">
                    Corretores
                </a>
                <a href="{{ route('admin.payments') }}" wire:navigate class="{{ request()->routeIs('admin.payments') ? 'text-indigo-700' : 'text-slate-700 hover:text-slate-900' }}">
                    Pagamentos
                </a>
                <a href="{{ route('home') }}" class="text-slate-500 hover:text-slate-700">Site público</a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                @csrf
                <button type="submit" class="rounded-md border border-slate-300 bg-white px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">
                    Sair
                </button>
            </form>
        </div>
    </header>
    <main class="mx-auto max-w-7xl p-4 md:p-6">
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>
