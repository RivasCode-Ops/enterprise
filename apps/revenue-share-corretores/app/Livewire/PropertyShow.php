<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Models\Property;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class PropertyShow extends Component
{
    public Property $property;

    public string $buyer_name = '';

    public string $buyer_email = '';

    public string $buyer_phone = '';

    public string $message = '';

    public bool $buyer_consent = false;

    public function mount(Property $property): void
    {
        $this->property = $property->load([
            'images' => fn ($q) => $q->orderBy('sort_order'),
            'broker',
        ]);
    }

    public function rules(): array
    {
        return [
            'buyer_name' => ['required', 'string', 'max:120'],
            'buyer_email' => ['required', 'email', 'max:255'],
            'buyer_phone' => ['nullable', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:2000'],
            'buyer_consent' => ['accepted'],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'buyer_name' => 'nome',
            'buyer_email' => 'email',
            'buyer_phone' => 'telefone',
            'message' => 'mensagem',
            'buyer_consent' => 'consentimento',
        ];
    }

    public function submitLead(): void
    {
        $this->validate();

        $ipKey = 'lead-ip:' . request()->ip();
        if (RateLimiter::tooManyAttempts($ipKey, 20)) {
            $this->addError('buyer_email', 'Demasiados envios a partir deste IP. Aguarda alguns minutos.');

            return;
        }

        $emailKey = sprintf(
            'lead-email:%d:%s',
            $this->property->id,
            hash('sha256', strtolower(trim($this->buyer_email)))
        );

        if (RateLimiter::tooManyAttempts($emailKey, 1)) {
            $this->addError(
                'buyer_email',
                'Já enviaste um pedido para este imóvel nas últimas 24 horas (mesmo email).'
            );

            return;
        }

        Lead::query()->create([
            'property_id' => $this->property->id,
            'buyer_name' => $this->buyer_name,
            'buyer_email' => $this->buyer_email,
            'buyer_phone' => $this->buyer_phone ?: null,
            'message' => $this->message ?: null,
            'consent_privacy_accepted' => true,
            'consent_accepted_at' => now(),
        ]);

        RateLimiter::hit($ipKey, 120);
        RateLimiter::hit($emailKey, 86400);

        session()->flash('lead_sent', true);

        $this->reset('buyer_name', 'buyer_email', 'buyer_phone', 'message', 'buyer_consent');
    }

    public function render()
    {
        return view('livewire.property-show');
    }
}
