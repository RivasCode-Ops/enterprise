<?php

namespace Database\Seeders;

use App\Models\Broker;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BrokerPropertyDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->firstOrCreate(
            ['email' => 'corretor@demo.local'],
            [
                'name' => 'Corretor Demo',
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
            ]
        );

        $broker = Broker::query()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'company_name' => 'Imobiliária Demo',
                'phone' => '11999990000',
            ]
        );

        $property = Property::query()->firstOrCreate(
            [
                'broker_id' => $broker->id,
                'title' => 'Apartamento centro — publicação demo',
            ],
            [
                'description' => 'Imóvel de demonstração Fase 2.',
                'price' => 450000.00,
                'city' => 'São Paulo',
                'state' => 'SP',
                'address_line' => 'Rua Demo, 100',
                'status' => 'published',
            ]
        );

        $property->forceFill(['slug' => 'apartamento-demo'])->saveQuietly();

        PropertyImage::query()->where('property_id', $property->id)->delete();

        $disk = Storage::disk('public');
        for ($i = 0; $i < 3; $i++) {
            $path = "properties/{$property->id}/demo_" . ($i + 1) . '.jpg';
            $disk->put($path, "%PDF-1.4 demo foto placeholder \xFF\xD8\xFF\xD9");
            PropertyImage::query()->create([
                'property_id' => $property->id,
                'path' => $path,
                'sort_order' => $i,
            ]);
        }

        $leadVenda = Lead::query()->firstOrCreate(
            [
                'property_id' => $property->id,
                'buyer_email' => 'comprador-venda-demo@local',
            ],
            [
                'buyer_name' => 'Comprador Venda Demo',
                'buyer_phone' => '11977776666',
                'message' => 'Lead do seeder para teste de venda e split (Fase 4).',
            ]
        );

        $leadVenda->forceFill([
            'consent_privacy_accepted' => true,
            'consent_accepted_at' => now(),
        ])->saveQuietly();

        if (! $leadVenda->sale) {
            $sale = Sale::query()->create([
                'lead_id' => $leadVenda->id,
                'sale_value' => 500000,
                'split_percent' => 5,
                'revenue_broker' => 0,
            ]);

            Payment::query()->create([
                'sale_id' => $sale->id,
                'amount' => $sale->revenue_broker,
                'due_date' => now()->addDays(30)->toDateString(),
                'status' => Payment::STATUS_PENDING,
            ]);
        }
    }
}
