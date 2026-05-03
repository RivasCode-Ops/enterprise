<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Painel administrativo (faturamento global).
     */
    public function accessAdminPanel(User $user): bool
    {
        return $user->role === 'admin';
    }
}
