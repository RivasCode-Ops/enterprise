<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-guest')]
class AdminLogin extends Component
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

        $throttleKey = 'login-admin:'.sha1(strtolower($this->email)).':'.request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', 'Demasiadas tentativas. Tenta novamente em '.$seconds.'s.');

            return;
        }

        $user = User::query()->where('email', $this->email)->first();

        if (! $user || $user->role !== User::ROLE_ADMIN) {
            RateLimiter::hit($throttleKey, 60);
            $this->addError('email', 'Conta de administrador inválida.');

            return;
        }

        if (! Auth::guard('admin')->attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            RateLimiter::hit($throttleKey, 60);
            $this->addError('email', 'Credenciais inválidas.');

            return;
        }

        RateLimiter::clear($throttleKey);

        session()->regenerate();

        $this->redirect(route('admin.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin-login');
    }
}
