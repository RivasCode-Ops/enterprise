<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.broker')]
class BrokerLeads extends Component
{
    public bool $showSaleModal = false;

    public ?int $saleLeadId = null;

    public string $sale_value = '';

    public string $split_percent = '';

    public function openSaleModal(int $leadId): void
    {
        $broker = Auth::guard('broker')->user()->broker;

        $lead = Lead::query()
            ->whereKey($leadId)
            ->whereHas('property', fn ($q) => $q->where('broker_id', $broker->id))
            ->with('sale')
            ->firstOrFail();

        if ($lead->sale) {
            return;
        }

        $this->saleLeadId = $lead->id;
        $this->sale_value = '';
        $this->split_percent = '5';
        $this->showSaleModal = true;
        $this->resetValidation();
    }

    public function closeSaleModal(): void
    {
        $this->showSaleModal = false;
        $this->saleLeadId = null;
        $this->reset('sale_value', 'split_percent');
        $this->resetValidation();
    }

    public function saveSale(): void
    {
        $this->validate([
            'sale_value' => ['required', 'numeric', 'min:0'],
            'split_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ], [], [
            'sale_value' => 'valor da venda',
            'split_percent' => 'percentagem de split',
        ]);

        $broker = Auth::guard('broker')->user()->broker;

        $lead = Lead::query()
            ->whereKey($this->saleLeadId)
            ->whereHas('property', fn ($q) => $q->where('broker_id', $broker->id))
            ->with('sale')
            ->firstOrFail();

        if ($lead->sale) {
            $this->addError('sale_value', 'Este lead já tem venda registada.');

            return;
        }

        DB::transaction(function () use ($lead): void {
            $sale = Sale::query()->create([
                'lead_id' => $lead->id,
                'sale_value' => $this->sale_value,
                'split_percent' => $this->split_percent,
                'revenue_broker' => 0,
            ]);

            Payment::query()->create([
                'sale_id' => $sale->id,
                'amount' => $sale->revenue_broker,
                'due_date' => now()->addDays(30)->toDateString(),
                'status' => Payment::STATUS_PENDING,
            ]);
        });

        session()->flash('sale_registered', true);
        $this->closeSaleModal();
    }

    public function render()
    {
        $broker = Auth::guard('broker')->user()->broker;

        $leads = Lead::query()
            ->whereHas('property', fn ($q) => $q->where('broker_id', $broker->id))
            ->with([
                'property' => fn ($q) => $q->select('id', 'title', 'slug', 'broker_id'),
                'sale.payments',
            ])
            ->latest()
            ->get();

        return view('livewire.broker-leads', [
            'broker' => $broker,
            'leads' => $leads,
        ]);
    }
}
