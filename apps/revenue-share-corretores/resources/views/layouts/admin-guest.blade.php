<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-900 text-slate-100 antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center p-4">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
