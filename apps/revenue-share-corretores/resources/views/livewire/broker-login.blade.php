<div class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
    <h1 class="text-xl font-semibold text-slate-900">Área do corretor</h1>
    <p class="mt-1 text-sm text-slate-600">Acesse sua conta para publicar imóveis e acompanhar leads e vendas.</p>

    <form wire:submit="login" class="mt-6 space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" type="email" wire:model="email" autocomplete="username"
                   class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Senha</label>
            <input id="password" type="password" wire:model="password" autocomplete="current-password"
                   class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" wire:model="remember" class="rounded border-slate-300"/>
            Manter conectado
        </label>
        <button type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Entrar
        </button>
    </form>
</div>
