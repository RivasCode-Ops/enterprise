<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class AdminDashboard extends Component
{
    public function mount(): void
    {
        $this->authorize('accessAdminPanel', Auth::guard('admin')->user());
    }

    public function render()
    {
        $totalRevenue = (float) Sale::query()->sum('revenue_broker');

        $salesMonthBounds = [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ];

        $salesMonthCount = (int) Sale::query()
            ->whereBetween('created_at', $salesMonthBounds)
            ->count();

        $salesMonthValue = (float) Sale::query()
            ->whereBetween('created_at', $salesMonthBounds)
            ->sum('sale_value');

        $pendingSum = (float) Payment::query()->where('status', Payment::STATUS_PENDING)->sum('amount');
        $paidSum = (float) Payment::query()->where('status', Payment::STATUS_PAID)->sum('amount');

        $pendingCount = Payment::query()->where('status', Payment::STATUS_PENDING)->count();
        $paidCount = Payment::query()->where('status', Payment::STATUS_PAID)->count();

        $paymentTotal = $pendingSum + $paidSum;
        $paidPct = $paymentTotal > 0 ? round($paidSum / $paymentTotal * 100, 1) : 0;
        $pendingPct = $paymentTotal > 0 ? round($pendingSum / $paymentTotal * 100, 1) : 0;

        $revenueByMonth = collect(range(5, 0))->map(function (int $monthsAgo) {
            $d = now()->subMonths($monthsAgo)->startOfMonth();

            $total = (float) Sale::query()
                ->whereYear('created_at', $d->year)
                ->whereMonth('created_at', $d->month)
                ->sum('revenue_broker');

            return [
                'label' => $d->translatedFormat('M Y'),
                'total' => $total,
            ];
        });

        $maxMonthly = max($revenueByMonth->max('total') ?: 0, 1);

        return view('livewire.admin-dashboard', [
            'totalRevenue' => $totalRevenue,
            'salesMonthCount' => $salesMonthCount,
            'salesMonthValue' => $salesMonthValue,
            'pendingSum' => $pendingSum,
            'paidSum' => $paidSum,
            'pendingCount' => $pendingCount,
            'paidCount' => $paidCount,
            'paidPct' => $paidPct,
            'pendingPct' => $pendingPct,
            'revenueByMonth' => $revenueByMonth,
            'maxMonthly' => $maxMonthly,
        ]);
    }
}
