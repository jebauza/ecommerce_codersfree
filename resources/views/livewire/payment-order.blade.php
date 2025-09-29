<div>
    {{-- @php
        // SDK de Mercado Pago
        require base_path('vendor/autoload.php');
        // Agrega credenciales
        MercadoPago\SDK::setAccessToken(config('services.mercadopago.access_token'));

        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();

        // Agregar Costo de envio
        $shipments = new MercadoPago\Shipments();
        $shipments->cost = $order->shipping_cost;
        $shipments->mode = 'not_specified';

        $preference->shipments = $shipments;

        // Crea un ítem en la preferencia
        $mpItems = [];
        foreach ($items as $item) {
            $mpItem = new MercadoPago\Item();
            $mpItem->title = $item->name;
            $mpItem->quantity = $item->qty;
            $mpItem->unit_price = $item->price;

            $mpItems[] = $mpItem;
        }

        $preference->back_urls = [
            "success" => route('orders.pay', $order),
            "failure" => "http://www.tu-sitio/failure",
            "pending" => "http://www.tu-sitio/pending"
        ];
        $preference->auto_return = "approved";

        $preference->items = $mpItems;
        $preference->save();
    @endphp --}}

    <div class="container grid grid-cols-5 gap-6 py-8">
        <div class="col-span-3">
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

        </div>

        <div class="col-span-2">
            <div class="px-6 pt-6 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <img class="h-12" src="{{ asset('img/payments/class-payments.png') }}" alt="">

                    <div class="text-gray-700">
                        <p class="text-sm font-semibold">Subtotal: {{ $order->total - $order->shipping_cost }} USD</p>
                        <p class="text-sm font-semibold">{{ ucfirst(__('shipping')) }}: {{ $order->shipping_cost }} USD</p>
                        <p class="text-lg font-semibold uppercase">Total: {{ $order->total }} USD</p>

                        {{-- MercadoPago --}}
                        {{-- <div class="cho-container"></div> --}}

                    </div>
                </div>

                <div id="paypal-button-container"></div>
            </div>
        </div>
    </div>

    @push('script')
        {{-- SDK MercadoPago.js --}}
        {{-- <script src="https://sdk.mercadopago.com/js/v2"></script>
        <script>
            const mp = new MercadoPago("{{ config('services.mercadopago.public_Key') }}", {
                locale: 'es-AR'
            });

            mp.checkout({
                preference: {
                    id: '{{ $preference->id }}'
                },
                render: {
                    container: '.cho-container',
                    label: 'Pagar',
                }
            });
        </script> --}}

        <!-- Replace "test" with your own sandbox Business account app client ID -->
        <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>

        <script>
            paypal.Buttons({
                // Sets up the transaction when a payment button is clicked
                createOrder: (data, actions) => {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: "{{ $order->total }}" // Can also reference a variable or function
                            }
                        }]
                    });
                },
                // Finalize the transaction after payer approval
                onApprove: (data, actions) => {
                    return actions.order.capture().then(function(orderData) {
                        // Successful capture! For dev/demo purposes:
                        // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        // const transaction = orderData.purchase_units[0].payments.captures[0];
                        // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                        // When ready to go live, remove the alert and show a success message within this page. For example:
                        // const element = document.getElementById('paypal-button-container');
                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        // Or go to another URL:  actions.redirect('thank_you.html');
                        
                        livewire.emit('payOrder', orderData)
                    });
                }
            }).render('#paypal-button-container');
        </script>
    @endpush
</div>
