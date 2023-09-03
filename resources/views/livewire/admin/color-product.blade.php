<div>
    <div class="p-6 my-12 bg-white rounded-lg shadow-lg">

        {{-- Color --}}
        <div class="mb-6">
            <x-jet-label class="font-bold">Color</x-jet-label>
            <div class="grid grid-cols-6 gap-6">
                @foreach($colors as $color)
                    <label>
                        <input wire:model.defer="colorId" type="radio" name="colorId" value="{{ $color->id }}">
                        <span class="ml-2 text-gray-700 capitalize">
                            {{ __($color->name) }}
                        </span>
                    </label>
                @endforeach
            </div>

            <x-jet-input-error for="colorId" />
        </div>

        {{-- Quantity --}}
        <div>
            <x-jet-label class="font-bold">Cantidad</x-jet-label>
            <x-jet-input wire:model.defer="quantity" type="number" placeholder="Ingrese una cantidad" class="w-full"/>
            <x-jet-input-error for="quantity" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button wire:click="saveColor" wire:loading.attr="disabled" wire:target="saveColor">
                Agregar
            </x-jet-button>
        </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <table>
            <thead>
                <tr>
                    <th class="w-1/3 px-4 py-2">Color</th>
                    <th class="w-1/3 px-4 py-2">Cantidad</th>
                    <th class="w-1/3 px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($productColors as $key => $productColor)
                    <tr>
                        <td class="px-4 py-2 capitalize">{{ __($productColor->name) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $productColor->pivot->quantity }} unidades</td>
                        <td class="flex px-4 py-2">
                            <x-jet-secondary-button class="ml-auto mr-2">Actualizar</x-jet-secondary-button>
                            <x-jet-danger-button>Eliminar</x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
