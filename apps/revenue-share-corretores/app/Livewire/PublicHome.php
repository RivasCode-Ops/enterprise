<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class PublicHome extends Component
{
    public function render()
    {
        $properties = Property::query()
            ->published()
            ->with(['images' => fn ($q) => $q->orderBy('sort_order')])
            ->latest()
            ->get();

        return view('livewire.public-home', [
            'properties' => $properties,
        ]);
    }
}
