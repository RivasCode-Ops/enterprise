<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Faturamento</h1>
        <p class="mt-1 text-sm text-slate-600">Visão global do MVP — revenue de corretores e estado dos pagamentos.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Revenue total (split)</p>
            <p class="mt-2 text-2xl font-bold text-indigo-700">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Vendas este mês</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $salesMonthCount }}</p>
            <p class="mt-1 text-xs text-slate-500">Volume R$ {{ number_format($salesMonthValue, 2, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-amber-800">Pagamentos pendentes</p>
            <p class="mt-2 text-2xl font-bold text-amber-900">R$ {{ number_format($pendingSum, 2, ',', '.') }}</p>
            <p class="mt-1 text-xs text-amber-800">{{ $pendingCount }} lançamento(s)</p>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-emerald-800">Pagamentos pagos</p>
            <p class="mt-2 text-2xl font-bold text-emerald-900">R$ {{ number_format($paidSum, 2, ',', '.') }}</p>
            <p class="mt-1 text-xs text-emerald-800">{{ $paidCount }} lançamento(s)</p>
        </div>
    </div>

    <div class="mt-10 grid gap-8 lg:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Revenue mensal (últimos 6 meses)</h2>
            <p class="mt-1 text-xs text-slate-500">Soma do revenue do corretor por mês de registo da venda.</p>
            <div class="mt-6 flex h-48 items-end justify-between gap-2 border-b border-l border-slate-200 pl-2 pb-0">
                @foreach ($revenueByMonth as $row)
                    @php
                        $hPct = ($row['total'] / $maxMonthly) * 100;
                    @endphp
                    <div class="flex flex-1 flex-col items-center justify-end gap-1">
                        <span class="text-[10px] font-medium text-slate-600">{{ number_format($row['total'] / 1000, 1, ',', '') }}k</span>
                        <div class="w-full max-w-[3rem] rounded-t bg-indigo-500 transition-all"
                             style="height: {{ max($hPct, 2) }}%"
                             title="R$ {{ number_format($row['total'], 2, ',', '.') }}"></div>
                        <span class="mt-1 max-w-[4rem] truncate text-center text-[10px] text-slate-500">{{ $row['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Pagamentos — pago vs pendente</h2>
            <p class="mt-1 text-xs text-slate-500">Distribuição por valor (não por número de lançamentos).</p>

            @if ($paidSum + $pendingSum <= 0)
                <p class="mt-8 text-center text-sm text-slate-500">Sem dados de pagamentos.</p>
            @else
                <div class="mx-auto mt-8 max-w-xs">
                    <div class="flex h-10 overflow-hidden rounded-full ring-1 ring-slate-200">
                        <div class="flex items-center justify-center bg-emerald-500 text-xs font-medium text-white"
                             style="width: {{ $paidPct }}%">
                            @if ($paidPct >= 15)
                                {{ $paidPct }}%
                            @endif
                        </div>
                        <div class="flex items-center justify-center bg-amber-400 text-xs font-medium text-amber-950"
                             style="width: {{ $pendingPct }}%">
                            @if ($pendingPct >= 15)
                                {{ $pendingPct }}%
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between gap-4 text-xs">
                        <span class="flex items-center gap-2 text-emerald-700">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Pago R$ {{ number_format($paidSum, 2, ',', '.') }}
                        </span>
                        <span class="flex items-center gap-2 text-amber-800">
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                            Pendente R$ {{ number_format($pendingSum, 2, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
