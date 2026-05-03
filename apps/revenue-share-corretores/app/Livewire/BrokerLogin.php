<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('Entrar — Corretor')]
class BrokerLogin extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = 'login-broker:'.sha1(strtolower($this->email)).':'.request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', 'Demasiadas tentativas. Tenta novamente em '.$seconds.'s.');

            return;
        }

        $user = User::query()->where('email', $this->email)->first();

        if (! $user?->broker) {
            RateLimiter::hit($throttleKey, 60);
            $this->addError('email', 'Esta conta não está registada como corretor.');

            return;
        }

        if (! Auth::guard('broker')->attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            RateLimiter::hit($throttleKey, 60);
            $this->addError('email', 'Credenciais inválidas.');

            return;
        }

        RateLimiter::clear($throttleKey);

        session()->regenerate();

        $this->redirect(route('broker.properties.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.broker-login');
    }
}
