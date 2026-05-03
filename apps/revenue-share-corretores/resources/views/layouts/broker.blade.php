<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Área do corretor' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3">
            <nav class="flex flex-wrap items-center gap-4">
                <a href="{{ route('broker.properties.index') }}" class="text-lg font-semibold text-slate-800" wire:navigate>
                    Meus anúncios
                </a>
                <a href="{{ route('broker.leads.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800" wire:navigate>
                    Leads
                </a>
                <a href="{{ route('broker.sales.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800" wire:navigate>
                    Vendas e comissões
                </a>
            </nav>
            <form method="POST" action="{{ route('broker.logout') }}" class="inline">
                @csrf
                <button type="submit" class="rounded-md border border-slate-300 bg-white px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">
                    Sair
                </button>
            </form>
        </div>
    </header>
    <main class="mx-auto max-w-6xl p-4 md:p-6">
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>
