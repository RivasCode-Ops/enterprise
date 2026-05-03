<div class="w-full max-w-md rounded-xl border border-slate-700 bg-slate-800 p-8 shadow-xl">
    <h1 class="text-xl font-semibold text-white">Área administrativa</h1>
    <p class="mt-1 text-sm text-slate-400">Faturamento e pagamentos (MVP).</p>

    <form wire:submit="login" class="mt-6 space-y-4">
        <div>
            <label for="admin-email" class="block text-sm font-medium text-slate-300">Email</label>
            <input id="admin-email" type="email" wire:model="email" autocomplete="username"
                   class="mt-1 w-full rounded-md border border-slate-600 bg-slate-900 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
            @error('email') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="admin-password" class="block text-sm font-medium text-slate-300">Password</label>
            <input id="admin-password" type="password" wire:model="password" autocomplete="current-password"
                   class="mt-1 w-full rounded-md border border-slate-600 bg-slate-900 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
            @error('password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-300">
            <input type="checkbox" wire:model="remember" class="rounded border-slate-600 bg-slate-900"/>
            Lembrar-me
        </label>
        <button type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900">
            Entrar
        </button>
    </form>
</div>
