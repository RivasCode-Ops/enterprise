<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Imóveis publicados</h1>
            <p class="mt-1 text-sm text-slate-600">{{ $broker->company_name }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('broker.leads.index') }}" wire:navigate
               class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                Ver leads
            </a>
            <a href="{{ route('broker.sales.index') }}" wire:navigate
               class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                Vendas
            </a>
            <button type="button" wire:click="openCreate"
                    class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Novo imóvel
            </button>
        </div>
    </div>

    @if ($properties->isEmpty())
        <div class="rounded-lg border border-dashed border-slate-300 bg-white p-12 text-center">
            <p class="text-slate-600">Ainda não há imóveis. Clique em «Novo imóvel» para publicar.</p>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($properties as $property)
                @php
                    $thumb = $property->images->sortBy('sort_order')->first();
                @endphp
                <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                    <div class="aspect-[4/3] bg-slate-100">
                        @if ($thumb)
                            <img src="{{ $thumb->url }}" alt="{{ $property->title }}" class="h-full w-full object-cover"/>
                        @else
                            <div class="flex h-full items-center justify-center text-sm text-slate-400">Sem foto</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h2 class="line-clamp-2 font-semibold text-slate-900">{{ $property->title }}</h2>
                        <p class="mt-2 text-lg font-medium text-indigo-700">
                            R$ {{ number_format((float) $property->price, 2, ',', '.') }}
                        </p>
                        @if ($property->description)
                            <p class="mt-2 line-clamp-3 text-sm text-slate-600">{{ $property->description }}</p>
                        @endif
                        <p class="mt-2 text-xs text-slate-500">
                            {{ $property->images->count() }} foto(s)
                            @if ($thumb)
                                · <a href="{{ $thumb->url }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">abrir em /storage/</a>
                            @endif
                        </p>
                        <button type="button" wire:click="openEdit({{ $property->id }})"
                                class="mt-4 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Editar
                        </button>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/50" wire:click="closeModal"></div>
            <div class="relative z-10 max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-xl bg-white p-6 shadow-xl">
                <livewire:property-form :property-id="$editingId" wire:key="property-form-{{ $editingId ?? 'new' }}"/>
            </div>
        </div>
    @endif
</div>
