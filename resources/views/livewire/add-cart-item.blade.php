<div x-data>
    <p class="text-gray-700 mb-4">
        <span class="font-semibold text-lg">Stock disponible:</span> {{ $quantity }}
    </p>

    <div class="flex">
        <div class="mr-4">
            <x-jet-secondary-button x-bind:disabled="$wire.qty <= 1" wire:loading.attr="disabled"
                wire:target="incrementAndDecrement" wire:click="incrementAndDecrement('-')">-</x-jet-secondary-button>
            <span class="mx-2 text-gray-700">{{ $qty }}</span>
            <x-jet-secondary-button x-bind:disabled="$wire.qty >= $wire.quantity" wire:loading.attr="disabled"
                wire:target="incrementAndDecrement" wire:click="incrementAndDecrement('+')">+</x-jet-secondary-button>
        </div>

        <div class="flex-1">
            <x-button color="orange" class="w-full">Agregar al carrito de compras</x-button>
        </div>
    </div>
</div>
