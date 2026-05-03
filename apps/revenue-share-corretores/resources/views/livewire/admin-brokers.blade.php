<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Corretores</h1>
        <p class="mt-1 text-sm text-slate-600">Revenue total acumulado (split) por imobiliária.</p>
    </div>

    @if ($rows->isEmpty())
        <p class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">Sem corretores registados.</p>
    @else
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Imobiliária</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Contacto</th>
                    <th class="px-4 py-3 text-right font-semibold text-slate-700">Revenue total</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @foreach ($rows as $row)
                    @php $broker = $row['broker']; @endphp
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $broker->company_name }}</td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $broker->user?->email ?? '—' }}
                            @if ($broker->phone)
                                <span class="block text-xs text-slate-500">{{ $broker->phone }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-indigo-700">
                            R$ {{ number_format($row['revenue_total'], 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
