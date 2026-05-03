@push('meta-title')
    <title>Imóveis disponíveis — {{ config('app.name', 'Laravel') }}</title>
@endpush

<div>
    <h1 class="text-2xl font-bold text-slate-900">Imóveis disponíveis</h1>
    <p class="mt-2 text-slate-600">Confira os detalhes e solicite contato com o corretor responsável.</p>

    @if ($properties->isEmpty())
        <p class="mt-8 rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
            Não há imóveis publicados no momento. Volte em breve.
        </p>
    @else
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($properties as $property)
                @php $thumb = $property->images->sortBy('sort_order')->first(); @endphp
                <a href="{{ route('properties.show', $property) }}"
                   wire:navigate
                   class="block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                    <div class="aspect-[4/3] bg-slate-100">
                        @if ($thumb)
                            <img src="{{ $thumb->url }}" alt="" class="h-full w-full object-cover"/>
                        @else
                            <div class="flex h-full items-center justify-center text-sm text-slate-400">Sem imagem</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h2 class="font-semibold text-slate-900">{{ $property->title }}</h2>
                        <p class="mt-2 text-lg font-medium text-indigo-700">
                            R$ {{ number_format((float) $property->price, 2, ',', '.') }}
                        </p>
                        @if ($property->city)
                            <p class="mt-1 text-sm text-slate-500">{{ $property->city }}{{ $property->state ? ', '.$property->state : '' }}</p>
                        @endif
                        <span class="mt-3 inline-block text-sm font-medium text-indigo-600">Ver imóvel →</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
