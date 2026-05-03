<?php

namespace Tests\Feature;

use App\Livewire\AdminDashboard;
use App\Livewire\AdminLogin;
use App\Livewire\BrokerLeads;
use App\Livewire\BrokerLogin;
use App\Livewire\PropertyShow;
use App\Models\Broker;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class MvpEndToEndTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_mvp_public_lead_sale_admin_dashboard(): void
    {
        $brokerUser = User::factory()->create([
            'email' => 'corretor-e2e@test.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_USER,
        ]);

        $broker = Broker::query()->create([
            'user_id' => $brokerUser->id,
            'company_name' => 'Imobiliária E2E',
            'phone' => '11999991111',
        ]);

        $property = Property::query()->create([
            'broker_id' => $broker->id,
            'title' => 'Apartamento E2E',
            'description' => 'Imóvel para teste MVP.',
            'price' => 450000,
            'city' => 'São Paulo',
            'state' => 'SP',
            'address_line' => 'Rua E2E, 1',
            'status' => 'published',
        ]);
        $property->refresh();

        $admin = User::factory()->create([
            'email' => 'admin-e2e@test.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        Livewire::test(PropertyShow::class, ['property' => $property])
            ->set('buyer_name', 'Comprador E2E')
            ->set('buyer_email', 'comprador-e2e@test.local')
            ->set('buyer_phone', '11988887777')
            ->set('message', 'Quero visitar.')
            ->set('buyer_consent', true)
            ->call('submitLead')
            ->assertHasNoErrors();

        $lead = Lead::query()->where('buyer_email', 'comprador-e2e@test.local')->firstOrFail();
        $this->assertTrue($lead->consent_privacy_accepted);
        $this->assertNotNull($lead->consent_accepted_at);

        Livewire::test(BrokerLogin::class)
            ->set('email', 'corretor-e2e@test.local')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect(route('broker.properties.index'));

        Livewire::actingAs($brokerUser, 'broker')
            ->test(BrokerLeads::class)
            ->call('openSaleModal', $lead->id)
            ->set('sale_value', '500000')
            ->set('split_percent', '5')
            ->call('saveSale')
            ->assertHasNoErrors();

        $sale = Sale::query()->where('lead_id', $lead->id)->firstOrFail();
        $this->assertSame('500000.00', (string) $sale->sale_value);
        $this->assertSame('5.00', (string) $sale->split_percent);
        $this->assertSame('25000.00', (string) $sale->revenue_broker);

        $this->assertDatabaseHas('payments', [
            'sale_id' => $sale->id,
            'status' => Payment::STATUS_PENDING,
        ]);

        Livewire::test(AdminLogin::class)
            ->set('email', 'admin-e2e@test.local')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect(route('admin.dashboard'));

        Livewire::actingAs($admin, 'admin')
            ->test(AdminDashboard::class)
            ->assertSuccessful();

        $this->assertEqualsWithDelta(25000.0, (float) Sale::query()->sum('revenue_broker'), 0.01);
        $this->assertEqualsWithDelta(
            25000.0,
            (float) Payment::query()->where('status', Payment::STATUS_PENDING)->sum('amount'),
            0.01
        );
    }
}
