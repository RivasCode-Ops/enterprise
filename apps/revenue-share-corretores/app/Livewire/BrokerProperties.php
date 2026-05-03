<?php

namespace App\Livewire;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.broker')]
#[Title('Meus imóveis')]
class BrokerProperties extends Component
{
    public bool $showModal = false;

    public ?int $editingId = null;

    #[Computed]
    public function broker()
    {
        return Auth::guard('broker')->user()->broker;
    }

    public function openCreate(): void
    {
        $this->editingId = null;
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $owns = Property::query()
            ->where('broker_id', $this->broker->id)
            ->whereKey($id)
            ->exists();

        if (! $owns) {
            return;
        }

        $this->editingId = $id;
        $this->showModal = true;
    }

    #[On('property-saved')]
    #[On('close-property-form')]
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->editingId = null;
    }

    public function render()
    {
        $properties = Property::query()
            ->where('broker_id', $this->broker->id)
            ->with(['images' => fn ($q) => $q->orderBy('sort_order')])
            ->latest()
            ->get();

        return view('livewire.broker-properties', [
            'broker' => $this->broker,
            'properties' => $properties,
        ]);
    }
}
