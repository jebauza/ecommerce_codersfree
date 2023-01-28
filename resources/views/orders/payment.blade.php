<x-app-layout>
    <div class="container py-8">
        <div class="px-6 py-4 mb-6 bg-white rounded-lg shadow-lg">
            <p class="text-gray-700 uppercase">
                <span class="font-semibold">@lang('Order number'):</span> {{ $order->id }}
            </p>
        </div>

        <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
            <div class="grid grid-cols-2 gap-6 text-gray-700">
                <div>
                    <p class="text-lg font-semibold uppercase">@lang('shipping')</p>

                    @if ($order->pickup_type == 'store')
                    <p class="text-sm">@lang('Products must be picked up in store')</p>
                    <p class="text-sm">Calle falsa 123</p>
                    @else
                    <p class="text-sm">@lang('The products will be sent to:')</p>
                    <p class="text-sm">{{ $order->address }}</p>
                    <p class="text-sm">{{ $order->department->name }} - {{ $order->city->name }} - {{
                        $order->district->name }}</p>
                    @endif
                </div>

                <div>
                    <p class="text-lg font-semibold uppercase">@lang('Contact information')</p>
                    <p class="text-sm">@lang('Contact name'): {{ $order->contact }}</p>
                    <p class="text-sm">@lang('Contact phone'): {{ $order->phone }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 mb-6 text-gray-700 bg-white rounded-lg shadow-lg">
            <p class="mb-4 text-lg font-semibold capitalize">@lang('resume')</p>

            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th></th>
                        <th class="capitalize">@lang('price')</th>
                        <th class="capitalize">@lang('quantity')</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <div class="flex">
                                    <img class="object-cover w-20 mr-4 h-15" src="{{ $item->options->image }}" alt="">
                                    <article>
                                        <h1 class="font-bold">{{ $item->name }}</h1>
                                        <div class="flex text-xs">
                                            @isset($item->options->color)
                                                {{ ucfirst(__('colour')) }}: @lang($item->options->color->name)
                                            @endisset

                                            @isset($item->options->size)
                                                - {{ $item->options->size->name }}
                                            @endisset
                                        </div>
                                    </article>
                                </div>
                            </td>
                            <td class="text-center">
                                {{ $item->price }} USD
                            </td>
                            <td class="text-center">
                                {{ $item->qty }}
                            </td>
                            <td class="text-center">
                                {{ $item->price * $item->qty }} USD
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between p-6 text-gray-700 bg-white rounded-lg shadow-lg">
            <img class="h-12" src="{{ asset('img/payments/class-payments.png') }}" alt="">

            <div class="text-gray-700">
                <p class="text-sm font-semibold">Subtotal: {{ $order->total - $order->shipping_cost }} USD</p>
                <p class="text-sm font-semibold">{{ ucfirst(__('shipping')) }}: {{ $order->shipping_cost }} USD</p>
                <p class="text-lg font-semibold uppercase">Total: {{ $order->total }} USD</p>
            </div>
        </div>


    </div>
</x-app-layout>
