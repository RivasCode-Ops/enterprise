<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Vendas e comissões</h1>
        <p class="mt-1 text-sm text-slate-600">Vendas originadas de leads, com comissões pendentes de repasse ou já quitadas.</p>
    </div>

    <div class="mb-8">
        <h2 class="mb-3 text-lg font-semibold text-slate-800">Repasses pendentes</h2>
        @if ($pendingPayments->isEmpty())
            <p class="rounded-lg border border-slate-200 bg-white p-6 text-sm text-slate-600">Nenhum repasse pendente no momento.</p>
        @else
            <div class="overflow-x-auto rounded-xl border border-amber-200 bg-amber-50/50 shadow-sm">
                <table class="min-w-full divide-y divide-amber-200 text-sm">
                    <thead class="bg-amber-100/80">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-800">Vencimento</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-800">Valor</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-800">Imóvel</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-800">Comprador</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-100 bg-white">
                    @foreach ($pendingPayments as $payment)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $payment->due_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 font-medium text-slate-900">R$ {{ number_format((float) $payment->amount, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $payment->sale->lead->property->title }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $payment->sale->lead->buyer_name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div>
        <h2 class="mb-3 text-lg font-semibold text-slate-800">Histórico de vendas</h2>
        @if ($sales->isEmpty())
            <p class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
                Nenhuma venda registrada. Registre a partir de um lead em <a href="{{ route('broker.leads.index') }}" wire:navigate class="text-indigo-600 hover:underline">Leads</a>.
            </p>
        @else
            <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Data</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Imóvel</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Lead</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-700">Valor venda</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-700">Split %</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-700">Sua comissão</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Pagamentos</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @foreach ($sales as $sale)
                        <tr class="align-top">
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-slate-900">{{ $sale->lead->property->title }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $sale->lead->buyer_name }}</td>
                            <td class="px-4 py-3 text-right font-medium text-slate-900">R$ {{ number_format((float) $sale->sale_value, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-slate-700">{{ number_format((float) $sale->split_percent, 2, ',', '.') }}%</td>
                            <td class="px-4 py-3 text-right font-semibold text-indigo-700">R$ {{ number_format((float) $sale->revenue_broker, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-slate-600">
                                <ul class="list-inside list-disc text-xs">
                                    @foreach ($sale->payments as $p)
                                        <li>
                                            R$ {{ number_format((float) $p->amount, 2, ',', '.') }}
                                            · {{ $p->due_date->format('d/m/Y') }}
                                            · <span class="@if($p->status === \App\Models\Payment::STATUS_PAID) text-emerald-700 @else text-amber-700 @endif">{{ $p->status }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
