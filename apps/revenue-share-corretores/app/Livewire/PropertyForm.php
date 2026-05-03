<?php

namespace App\Livewire;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class PropertyForm extends Component
{
    use WithFileUploads;

    public ?int $propertyId = null;

    public string $title = '';

    public string $description = '';

    public string $price = '';

    /** @var array<int, mixed> */
    public array $photos = [];

    public function mount(?int $propertyId = null): void
    {
        $this->propertyId = $propertyId;

        if ($this->propertyId) {
            $property = Property::query()
                ->where('broker_id', $this->currentBrokerId())
                ->with('images')
                ->findOrFail($this->propertyId);

            $this->title = $property->title;
            $this->description = (string) $property->description;
            $this->price = (string) $property->price;
        }
    }

    public function rules(): array
    {
        $photoRules = $this->propertyId
            ? ['nullable', 'array', 'max:12']
            : ['required', 'array', 'min:1', 'max:12'];

        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'photos' => $photoRules,
            'photos.*' => ['image', 'max:5120'],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'title' => 'título',
            'description' => 'descrição',
            'price' => 'preço',
            'photos' => 'fotos',
            'photos.*' => 'foto',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $brokerId = $this->currentBrokerId();

        if ($this->propertyId) {
            $property = Property::query()
                ->where('broker_id', $brokerId)
                ->findOrFail($this->propertyId);

            $property->update([
                'title' => $this->title,
                'description' => $this->description ?: null,
                'price' => $this->price,
            ]);

            $this->storeNewPhotos($property);
        } else {
            $property = Property::query()->create([
                'broker_id' => $brokerId,
                'title' => $this->title,
                'description' => $this->description ?: null,
                'price' => $this->price,
                'status' => 'published',
            ]);

            $this->storeNewPhotos($property);
        }

        $this->photos = [];
        $this->dispatch('property-saved');
    }

    private function storeNewPhotos(Property $property): void
    {
        if ($this->photos === []) {
            return;
        }

        $disk = Storage::disk('public');
        $baseOrder = (int) $property->images()->max('sort_order') + 1;

        foreach ($this->photos as $index => $file) {
            $path = $file->store("properties/{$property->id}", 'public');
            PropertyImage::query()->create([
                'property_id' => $property->id,
                'path' => $path,
                'sort_order' => $baseOrder + $index,
            ]);
        }
    }

    private function currentBrokerId(): int
    {
        $user = Auth::guard('broker')->user();

        return (int) $user->broker->id;
    }

    public function render()
    {
        $existingImages = collect();

        if ($this->propertyId) {
            $property = Property::query()
                ->where('broker_id', $this->currentBrokerId())
                ->with('images')
                ->find($this->propertyId);

            $existingImages = $property?->images ?? collect();
        }

        return view('livewire.property-form', [
            'existingImages' => $existingImages,
        ]);
    }
}
