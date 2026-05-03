<?php

namespace App\Livewire;

use App\Models\Broker;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class AdminBrokers extends Component
{
    public function mount(): void
    {
        $this->authorize('accessAdminPanel', Auth::guard('admin')->user());
    }

    public function render()
    {
        $rows = Broker::query()
            ->with('user')
            ->orderBy('company_name')
            ->get()
            ->map(function (Broker $broker) {
                return [
                    'broker' => $broker,
                    'revenue_total' => (float) Sale::query()
                        ->whereHas('lead.property', fn ($q) => $q->where('broker_id', $broker->id))
                        ->sum('revenue_broker'),
                ];
            })
            ->sortByDesc(fn (array $row) => $row['revenue_total'])
            ->values();

        return view('livewire.admin-brokers', [
            'rows' => $rows,
        ]);
    }
}
