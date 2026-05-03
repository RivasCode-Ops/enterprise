<div class="space-y-4">
    <h2 class="text-lg font-semibold text-slate-900">
        {{ $propertyId ? 'Editar imóvel' : 'Novo imóvel' }}
    </h2>

    <form wire:submit="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-slate-700">Título</label>
            <input type="text" wire:model="title"
                   class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Preço (R$)</label>
            <input type="text" inputmode="decimal" wire:model="price"
                   class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
            @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Descrição</label>
            <textarea wire:model="description" rows="4"
                      class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"></textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        @if ($existingImages->isNotEmpty())
            <div>
                <p class="text-sm font-medium text-slate-700">Fotos atuais</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach ($existingImages as $img)
                        <img src="{{ $img->url }}" alt="" class="h-20 w-28 rounded-md object-cover ring-1 ring-slate-200"/>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-slate-700">
                {{ $propertyId ? 'Adicionar fotos' : 'Fotos' }}
            </label>
            <input type="file" wire:model="photos" multiple accept="image/*"
                   class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700"/>
            <p class="mt-1 text-xs text-slate-500">JPEG, PNG ou WebP até 5 MB cada.</p>
            @error('photos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            @error('photos.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div wire:loading wire:target="photos" class="text-sm text-slate-500">A processar ficheiros…</div>

        @if ($photos)
            <div class="flex flex-wrap gap-2">
                @foreach ($photos as $photo)
                    @if ($photo && method_exists($photo, 'temporaryUrl'))
                        <img src="{{ $photo->temporaryUrl() }}" alt="" class="h-20 w-28 rounded-md object-cover ring-1 ring-slate-200"/>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
            <button type="button" wire:click="$dispatch('close-property-form')"
                    class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                Cancelar
            </button>
            <button type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Guardar
            </button>
        </div>
    </form>
</div>
