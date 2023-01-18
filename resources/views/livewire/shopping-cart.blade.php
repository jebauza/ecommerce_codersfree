<div class="container py-8">
    <section class="p-6 text-gray-700 bg-white rounded-lg shadow-lg">
        <h1 class="mb-6 text-lg font-semibold uppercase">@lang('shopping cart')</h1>

        @if (Cart::count())
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th></th>
                        <th class="capitalize">@lang('price')</th>
                        <th class="capitalize">@lang('quantity')</th>
                        <th class="capitalize">total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach (\Cart::content() as $itemCart)
                        <tr>
                            <td>
                                <div class="flex">
                                    <img class="object-cover w-20 mr-4 h-15" src="{{ $itemCart->options->image }}" alt="">

                                    <div>
                                        <p class="font-bold">{{ $itemCart->name }}</p>

                                        @isset($itemCart->options['color'])
                                            <span class="capitalize">
                                                @lang('colour'): {{ ucfirst(__($itemCart->options['color']['name'])) }}
                                            </span>
                                        @endisset

                                        @isset($itemCart->options['size'])
                                            <span class="mx-1">-</span>

                                            <span class="capitalize">
                                                {{ ucfirst(__($itemCart->options['size']['name'])) }}
                                            </span>
                                        @endisset
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span>USD {{ $itemCart->price }}</span>
                                <a wire:click="delete('{{ $itemCart->rowId }}')" wire:loading.class="text-red-600" wire:target="delete('{{ $itemCart->rowId }}')"
                                    class="ml-6 cursor-pointer hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>

                            <td>
                                <div class="flex justify-center">
                                    @livewire('update-cart-item', ['rowId' => $itemCart->rowId], key($itemCart->rowId))
                                </div>
                            </td>

                            <td class="text-center">
                                USD {{ $itemCart->price * $itemCart->qty }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a wire:click="destroy" class="inline-block mt-3 text-sm cursor-pointer hover:underline">
                <i class="fas fa-trash"></i>
                @lang('Delete shopping cart')
            </a>
        @else
            <div class="flex flex-col items-center">
                <x-cart/>
                <p class="mt-4 text-lg text-gray-700 uppercase">@lang('Your cart is empty')</p>

                <x-button-link href="/" class="px-16 mt-4">
                    @lang('Go to home')
                </x-button-link>
            </div>
        @endif

    </section>

    @if (Cart::count())
        <div class="px-6 py-4 mt-4 bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-700">
                        <span class="text-lg font-bold">Total:</span>
                        USD {{ Cart::subTotal() }}
                    </p>
                </div>

                <div>
                    <x-button-link class="uppercase">@lang('continue')</x-button-link>
                </div>
            </div>
        </div>
    @endif
</div>
