<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.broker')]
class BrokerSales extends Component
{
    public function render()
    {
        $broker = Auth::guard('broker')->user()->broker;

        $sales = Sale::query()
            ->whereHas('lead.property', fn ($q) => $q->where('broker_id', $broker->id))
            ->with([
                'lead' => fn ($q) => $q->select('id', 'property_id', 'buyer_name', 'buyer_email'),
                'lead.property' => fn ($q) => $q->select('id', 'title', 'slug'),
                'payments',
            ])
            ->latest()
            ->get();

        $pendingPayments = Payment::query()
            ->where('status', Payment::STATUS_PENDING)
            ->whereHas('sale.lead.property', fn ($q) => $q->where('broker_id', $broker->id))
            ->with([
                'sale.lead' => fn ($q) => $q->select('id', 'property_id', 'buyer_name'),
                'sale.lead.property' => fn ($q) => $q->select('id', 'title'),
            ])
            ->orderBy('due_date')
            ->get();

        return view('livewire.broker-sales', [
            'broker' => $broker,
            'sales' => $sales,
            'pendingPayments' => $pendingPayments,
        ]);
    }
}
