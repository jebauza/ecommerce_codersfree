<div>
    <x-jet-dropdown width="96">
        <x-slot name="trigger">
            <span class="relative inline-block cursor-pointer">
                <x-cart color="white" size="30"/>

                @if (Cart::count())
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ Cart::content()->count() }}</span>
                @else
                    <span class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
                @endif


            </span>
        </x-slot>

        <x-slot name="content">

            <ul>
                @forelse (Cart::content() as $itemCart)
                    <li class="flex p-2 border-b border-gray-200">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $itemCart->options->image }}" alt="">

                        <article class="flex-1">
                            <h1 class="font-bold">{{ $itemCart->name }}</h1>

                            <div class="flex">
                                <p>Cant: {{ $itemCart->qty }}</p>

                                @isset($itemCart->options['color'])
                                    <p class="mx-2">- Color: {{ ucfirst(__($itemCart->options['color']['name'])) }}</p>
                                @endisset

                                @isset($itemCart->options['size'])
                                    <p class="mx-2">Talla: {{ ucfirst(__($itemCart->options['size']['name'])) }}</p>
                                @endisset
                            </div>

                            <p>USD {{ $itemCart->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="px-4 py-6">
                        <p class="text-center text-gray-700">
                            @lang('You have not added any items to the cart')
                        </p>
                    </li>
                @endforelse
            </ul>

            @if (Cart::count())
                <div class="py-2 px-3">
                    <p class="text-lg text-gray-700 mt-2 mb-3"><span class="font-bold">Total: </span>USD {{ Cart::subtotal() }}</p>

                    <x-button-link href="{{ route('shopping-cart') }}" color="orange" class="w-full">@lang('Go to shopping cart')</x-button-link>
                </div>
            @endif

        </x-slot>
    </x-jet-dropdown>
</div>
