<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Leads recebidos</h1>
        <p class="mt-1 text-sm text-slate-600">Pedidos de contacto nos teus imóveis. Regista uma venda para gerar o split e pagamento.</p>
    </div>

    @if (session('sale_registered'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" role="alert">
            Venda registada. O pagamento do corretor foi criado como <strong>pendente</strong>.
        </div>
    @endif

    @if ($leads->isEmpty())
        <div class="rounded-lg border border-dashed border-slate-300 bg-white p-12 text-center text-slate-600">
            Ainda não há leads. Partilha o link público do imóvel com compradores.
        </div>
    @else
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Data</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Imóvel</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Nome</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Email</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Telefone</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Mensagem</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Venda</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @foreach ($leads as $lead)
                    <tr class="align-top">
                        <td class="whitespace-nowrap px-4 py-3 text-slate-600">
                            {{ $lead->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('properties.show', $lead->property) }}" target="_blank" rel="noopener"
                               class="font-medium text-indigo-600 hover:underline">
                                {{ $lead->property->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-slate-900">{{ $lead->buyer_name }}</td>
                        <td class="px-4 py-3">
                            <a href="mailto:{{ $lead->buyer_email }}" class="text-indigo-600 hover:underline">{{ $lead->buyer_email }}</a>
                        </td>
                        <td class="px-4 py-3 text-slate-700">{{ $lead->buyer_phone ?: '—' }}</td>
                        <td class="max-w-xs px-4 py-3 text-slate-600">{{ $lead->message ?: '—' }}</td>
                        <td class="whitespace-nowrap px-4 py-3">
                            @if ($lead->sale)
                                <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800">
                                    R$ {{ number_format((float) $lead->sale->sale_value, 2, ',', '.') }} · {{ number_format((float) $lead->sale->split_percent, 2, ',', '.') }}%
                                </span>
                                <p class="mt-1 text-xs text-slate-600">
                                    Revenue: R$ {{ number_format((float) $lead->sale->revenue_broker, 2, ',', '.') }}
                                </p>
                            @else
                                <button type="button" wire:click="openSaleModal({{ $lead->id }})"
                                        class="rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-700">
                                    Registrar venda
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($showSaleModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/50" wire:click="closeSaleModal"></div>
            <div class="relative z-10 w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
                <h2 class="text-lg font-semibold text-slate-900">Registrar venda</h2>
                <p class="mt-1 text-sm text-slate-600">O revenue do corretor é calculado como: valor × split ÷ 100.</p>

                <form wire:submit="saveSale" class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Valor da venda (R$)</label>
                        <input type="text" inputmode="decimal" wire:model="sale_value"
                               class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
                        @error('sale_value') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Split corretor (%)</label>
                        <input type="text" inputmode="decimal" wire:model="split_percent"
                               class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
                        @error('split_percent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                        <button type="button" wire:click="closeSaleModal"
                                class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                            Guardar venda
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
