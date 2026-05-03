<?php

namespace App\Livewire;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class AdminPayments extends Component
{
    public string $statusFilter = 'all';

    public function mount(): void
    {
        $this->authorize('accessAdminPanel', Auth::guard('admin')->user());
    }

    public function updatedStatusFilter(): void
    {
        //
    }

    public function render()
    {
        $payments = Payment::query()
            ->with([
                'sale.lead' => fn ($q) => $q->select('id', 'property_id', 'buyer_name', 'buyer_email'),
                'sale.lead.property' => fn ($q) => $q->select('id', 'title', 'broker_id'),
                'sale.lead.property.broker' => fn ($q) => $q->select('id', 'company_name'),
            ])
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->get();

        return view('livewire.admin-payments', [
            'payments' => $payments,
        ]);
    }
}
