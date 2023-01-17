<div class="container py-8">
    <section class="bg-white rounded-lg shadow-lg p-6 text-gray-700">
        <h1 class="uppercase text-lg font-semibold mb-6">@lang('shopping cart')</h1>

        <table class="table-auto w-full">
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
                                <img class="h-15 w-20 object-cover mr-4" src="{{ $itemCart->options->image }}" alt="">

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
                            <a class="ml-6 cursor-pointer hover:text-red-600">
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
    </section>
</div>
