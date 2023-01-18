<div class="flex items-center" x-data>
    <x-jet-secondary-button x-bind:disabled="$wire.qty <= 1" wire:loading.attr="disabled"
        wire:target="incrementAndDecrement" wire:click="incrementAndDecrement('-')">-</x-jet-secondary-button>

    <span class="mx-2">{{ $qty }}</span>

    <x-jet-secondary-button x-bind:disabled="$wire.qty >= $wire.quantity" wire:loading.attr="disabled"
        wire:target="incrementAndDecrement" wire:click="incrementAndDecrement('+')">+</x-jet-secondary-button>
</div>
