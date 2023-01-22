<div class="container grid grid-cols-5 gap-6 py-8">
    <div class="col-span-3">
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="mb-4">
                <x-jet-label value="{{ __('Contact name') }}" />
                <x-jet-input wire:model.defer="contact" class="w-full" type="text" placeholder="{{ __('Enter the name of the person who will receive the product') }}" />
                <x-jet-input-error for="contact"/>
            </div>

            <div>
                <x-jet-label value="{{ __('Contact phone') }}" />
                <x-jet-input wire:model.defer="phone" class="w-full" type="text" placeholder="{{ __('Enter a contact phone number') }}" />
                <x-jet-input-error for="phone"/>
            </div>
        </div>

        <div x-data="{ pickupType: @entangle('pickupType') }">
            <p class="mt-6 mb-3 text-lg font-semibold text-gray-700 capitalize">@lang('shipments')</p>

            <label class="flex items-center px-6 py-4 mb-4 bg-white rounded-lg shadow">
                <input x-model="pickupType" value="store" type="radio" name="pickupType" class="text-gray-700">
                <span class="ml-2 text-gray-700">Recojo en tienda (Calle false 123)</span>
                <span class="ml-auto font-semibold text-gray-700">Gratis</span>
            </label>

            <div class="bg-white rounded-lg shadow">
                <label class="flex items-center px-6 py-4">
                    <input x-model="pickupType" value="delivery" type="radio" name="pickupType" class="text-gray-700">
                    <span class="ml-2 text-gray-700">@lang('Home delivery')</span>
                </label>

                <div class="grid grid-cols-2 gap-6 px-6 pb-6" :class="{ 'hidden': pickupType != 'delivery' }">
                    {{-- Departments --}}
                    <div class="col-span-1">
                        <x-jet-label value="{{ ucfirst(__('department')) }}"/>
                        <select wire:model="departmentId" class="w-full form-control">
                            <option value="" disabled selected>@lang('Select a :item', ['item'=>__('department')])</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="departmentId" />
                    </div>

                    {{-- Cities --}}
                    <div class="col-span-1">
                        <x-jet-label value="{{ ucfirst(__('city')) }}"/>
                        <select wire:model="cityId" class="w-full form-control">
                            <option value="" disabled selected>@lang('Select a :item', ['item'=>__('city')])</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="cityId" />
                    </div>

                    {{-- Districts --}}
                    <div class="col-span-1">
                        <x-jet-label value="{{ ucfirst(__('district')) }}"/>
                        <select wire:model="districtId" class="w-full form-control">
                            <option value="" disabled selected>@lang('Select a :item', ['item'=>__('district')])</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="districtId" />
                    </div>

                    <div>
                        <x-jet-label value="{{ ucfirst(__('address')) }}" />
                        <x-jet-input class="w-full" wire:model="address"  type="text" />
                        <x-jet-input-error for="address" />
                    </div>

                    <div class="col-span-2">
                        <x-jet-label value="{{ ucfirst(__('reference')) }}" />
                        <x-jet-input class="w-full" wire:model="references"  type="text" />
                        <x-jet-input-error for="references" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-2">
            <x-jet-button wire:click="createOrder" wire:loading.attr="disabled" wire:target="createOrder"
                class="mt-6 mb-4">@lang('continue')</x-jet-button>
            <hr>
            <p class="mt-2 text-sm text-gray-700">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos debitis earum necessitatibus cupiditate ducimus quia soluta, delectus distinctio tenetur sapiente aspernatur iure dolorem dolor! Aut fuga earum cumque nesciunt architecto. <a class="font-semibold text-orange-500" href="">Políticas y privacidad</a></p>
        </div>
    </div>

    <div class="col-span-2">
        <div class="p-6 bg-white rounded-lg shadow">
            <ul>
                @forelse (Cart::content() as $itemCart)
                    <li class="flex p-2 border-b border-gray-200">
                        <img class="object-cover w-20 mr-4 h-15" src="{{ $itemCart->options->image }}" alt="">

                        <article class="flex-1">
                            <h1 class="font-bold">{{ $itemCart->name }}</h1>

                            <div class="flex">
                                <p class="capitalize">@lang('quantity'): {{ $itemCart->qty }}</p>

                                @isset($itemCart->options['color'])
                                    <p class="mx-2 capitalize">- @lang('colour'): {{ ucfirst(__($itemCart->options['color']['name'])) }}</p>
                                @endisset

                                @isset($itemCart->options['size'])
                                    <p class="mx-2 capitalize">@lang('size'): {{ ucfirst(__($itemCart->options['size']['name'])) }}</p>
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

            <hr class="mt-4 mb-3">

            <div class="text-gray-700">
                <p class="flex items-center justify-between">
                    Subtotal
                    <span class="font-semibold">{{ Cart::subtotal() }} USD</span>
                </p>

                <p class="flex items-center justify-between">
                    {{ ucfirst(__('shipping')) }}
                    <span class="font-semibold">
                        @if ($pickupType == 'store' || $shippingCost == 0)
                            {{ ucfirst(__('free')) }}
                        @else
                            {{ $shippingCost }} USD
                        @endif
                    </span>
                </p>

                <hr class="mt-4 mb-3">

                <p class="flex items-center justify-between font-semibold">
                    <span class="text-lg">Total</span>
                    @if ($pickupType == 'store' || $shippingCost == 0)
                        {{ Cart::subtotal() }}
                    @else
                        {{ Cart::subtotal() + $shippingCost }}
                    @endif
                    USD
                </p>
            </div>
        </div>
    </div>
</div>
