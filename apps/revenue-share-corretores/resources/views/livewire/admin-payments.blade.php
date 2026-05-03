<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pagamentos</h1>
            <p class="mt-1 text-sm text-slate-600">Todos os lançamentos gerados a partir das vendas.</p>
        </div>
        <div class="flex items-center gap-2">
            <label for="status-filter" class="text-sm text-slate-600">Estado</label>
            <select id="status-filter" wire:model.live="statusFilter"
                    class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <option value="all">Todos</option>
                <option value="{{ \App\Models\Payment::STATUS_PENDING }}">Pendente</option>
                <option value="{{ \App\Models\Payment::STATUS_PAID }}">Pago</option>
            </select>
        </div>
    </div>

    @if ($payments->isEmpty())
        <p class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
            Nenhum pagamento encontrado para este filtro.
        </p>
    @else
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">ID</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Corretor</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Imóvel</th>
                    <th class="px-4 py-3 text-right font-semibold text-slate-700">Valor</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Vencimento</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Estado</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @foreach ($payments as $payment)
                    <tr>
                        <td class="whitespace-nowrap px-4 py-3 text-slate-500">#{{ $payment->id }}</td>
                        <td class="px-4 py-3 text-slate-800">{{ $payment->sale->lead->property->broker->company_name ?? '—' }}</td>
                        <td class="max-w-xs truncate px-4 py-3 text-slate-700">{{ $payment->sale->lead->property->title }}</td>
                        <td class="px-4 py-3 text-right font-medium text-slate-900">R$ {{ number_format((float) $payment->amount, 2, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $payment->due_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($payment->status === \App\Models\Payment::STATUS_PAID)
                                <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800">pago</span>
                            @else
                                <span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800">pendente</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
