@push('meta-title')
    <title>{{ $property->title }} — Contacto | {{ config('app.name', 'Laravel') }}</title>
@endpush

<div>
    <nav class="mb-6 text-sm text-slate-600">
        <a href="{{ route('home') }}" class="text-indigo-600 hover:underline" wire:navigate>← Voltar à listagem</a>
    </nav>

    @if (session('lead_sent'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" role="alert">
            Pedido enviado com sucesso. O corretor entrará em contacto brevemente.
        </div>
    @endif

    <div class="grid gap-8 lg:grid-cols-2">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $property->title }}</h1>
            <p class="mt-3 text-3xl font-semibold text-indigo-700">
                R$ {{ number_format((float) $property->price, 2, ',', '.') }}
            </p>
            @if ($property->city || $property->address_line)
                <p class="mt-2 text-slate-600">
                    {{ $property->address_line }}
                    @if ($property->city)
                        <br>{{ $property->city }}{{ $property->state ? ', '.$property->state : '' }}
                    @endif
                </p>
            @endif
            @if ($property->description)
                <div class="prose prose-sm mt-4 max-w-none text-slate-700">
                    {{ $property->description }}
                </div>
            @endif

            @if ($property->images->isNotEmpty())
                <div class="mt-6 grid grid-cols-2 gap-2 sm:grid-cols-3">
                    @foreach ($property->images->sortBy('sort_order') as $img)
                        <img src="{{ $img->url }}" alt="" class="aspect-[4/3] w-full rounded-lg object-cover ring-1 ring-slate-200"/>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Pedir informações</h2>
            <p class="mt-1 text-sm text-slate-600">
                Dados enviados ao corretor responsável ({{ $property->broker->company_name ?? 'Imobiliária' }}).
            </p>

            <form wire:submit="submitLead" class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nome</label>
                    <input type="text" wire:model="buyer_name" autocomplete="name"
                           class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
                    @error('buyer_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" wire:model="buyer_email" autocomplete="email"
                           class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
                    @error('buyer_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Telefone</label>
                    <input type="tel" wire:model="buyer_phone" autocomplete="tel"
                           class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
                    @error('buyer_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Mensagem</label>
                    <textarea wire:model="message" rows="4"
                              class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"></textarea>
                    @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="flex cursor-pointer items-start gap-2 text-sm text-slate-700">
                        <input type="checkbox" wire:model="buyer_consent" class="mt-1 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"/>
                        <span>
                            Aceito o tratamento dos meus dados pessoais para este pedido de contacto, nos termos descritos em
                            <code class="rounded bg-slate-100 px-1 text-xs">docs/lgpd-retention.md</code> (retenção e direitos LGPD).
                        </span>
                    </label>
                    @error('buyer_consent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Enviar pedido
                </button>
            </form>
        </div>
    </div>
</div>
