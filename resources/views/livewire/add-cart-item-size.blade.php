<div x-data>
    <p class="text-xl text-gray-700 capitalize">@lang('size'):</p>
    <select wire:model="sizeId" class="form-control w-full">
        <option value="" selected disabled>@lang('Select a size')</option>

        @foreach ($sizes as $size)
            <option value="{{ $size->id }}">{{ $size->name }}</option>
        @endforeach
    </select>

    @if ($sizeId)
        <p class="text-xl text-gray-700 mt-2 capitalize">@lang('colour'):</p>
        <select wire:model="colorId" class="form-control w-full">
            <option value="" selected disabled>@lang('Select a color')</option>
            @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ ucfirst(__($color->name)) }}</option>
            @endforeach
        </select>

        @if($colorId)
            <p class="text-gray-700 mt-4">
                <span class="font-semibold text-lg">@lang('Available stock'):</span> {{ $quantity }}
            </p>
        @endif
    @endif

    <div class="flex mt-4">
        <div class="mr-4">
            <x-jet-secondary-button x-bind:disabled="$wire.qty <= 1" wire:loading.attr="disabled"
                wire:target="incrementAndDecrement" wire:click="incrementAndDecrement('-')">-</x-jet-secondary-button>
            <span class="mx-2 text-gray-700">{{ $qty }}</span>
            <x-jet-secondary-button x-bind:disabled="$wire.qty >= $wire.quantity" wire:loading.attr="disabled"
                wire:target="incrementAndDecrement" wire:click="incrementAndDecrement('+')">+</x-jet-secondary-button>
        </div>

        <div class="flex-1">
            <x-button x-bind:disabled="!$wire.quantity" wire:click="addCartItem" wire:loading.attr="disabled" wire:target="addCartItem"
                color="orange" class="w-full">@lang('Add to shopping cart')</x-button>
        </div>
    </div>
</div>
