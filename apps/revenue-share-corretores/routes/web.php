<?php

use App\Livewire\AdminBrokers;
use App\Livewire\AdminDashboard;
use App\Livewire\AdminLogin;
use App\Livewire\AdminPayments;
use App\Livewire\BrokerLeads;
use App\Livewire\BrokerLogin;
use App\Livewire\BrokerSales;
use App\Livewire\BrokerProperties;
use App\Livewire\PublicHome;
use App\Livewire\PropertyShow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicHome::class)->name('home');

Route::get('/properties/{property:slug}', PropertyShow::class)->name('properties.show');

Route::prefix('admin')->group(function () {
    Route::get('/login', AdminLogin::class)
        ->middleware(['guest:admin', 'throttle:20,1'])
        ->name('admin.login');

    Route::post('/logout', function () {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login');
    })->middleware('auth:admin')->name('admin.logout');

    Route::middleware(['auth:admin', 'admin.role'])->group(function () {
        Route::get('/', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/brokers', AdminBrokers::class)->name('admin.brokers');
        Route::get('/payments', AdminPayments::class)->name('admin.payments');
    });
});

Route::get('/broker/login', BrokerLogin::class)
    ->middleware(['guest:broker', 'throttle:20,1'])
    ->name('broker.login');

Route::post('/broker/logout', function () {
    Auth::guard('broker')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('broker.login');
})->middleware('auth:broker')->name('broker.logout');

/*
 * Full-page Livewire (equivalente a um Route::livewire do Volt — não existe no core Laravel).
 */
Route::get('/broker/properties', BrokerProperties::class)
    ->middleware('auth:broker')
    ->name('broker.properties.index');

Route::get('/broker/leads', BrokerLeads::class)
    ->middleware('auth:broker')
    ->name('broker.leads.index');

Route::get('/broker/sales', BrokerSales::class)
    ->middleware('auth:broker')
    ->name('broker.sales.index');
