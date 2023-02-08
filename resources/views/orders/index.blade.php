<x-app-layout>
    <div class="container py-12">
        <section class="grid grid-cols-5 gap-6 text-white">
            <a href="{{ route('orders.index', ['status'=>App\Models\Order::STATUS_PENDING]) }}" class="px-12 py-8 bg-red-500 bg-opacity-75 rounded-lg">
                <p class="text-2xl text-center">
                    {{ $countPending }}
                </p>
                <p class="text-center uppercase">@lang('pending')</p>
                <p class="mt-2 text-2xl text-center">
                    <i class="fas fa-business-time"></i>
                </p>
            </a>
            <a href="{{ route('orders.index', ['status'=>App\Models\Order::STATUS_RECEIVED]) }}" class="px-12 pt-8 pb-4 bg-gray-500 bg-opacity-75 rounded-lg">
                <p class="text-2xl text-center">
                    {{ $countReceived }}
                </p>
                <p class="text-center uppercase">@lang('received')</p>
                <p class="mt-2 text-2xl text-center">
                    <i class="fas fa-credit-card"></i>
                </p>
            </a>
            <a href="{{ route('orders.index', ['status'=>App\Models\Order::STATUS_SHIPPED]) }}" class="px-12 pt-8 pb-4 bg-yellow-500 bg-opacity-75 rounded-lg">
                <p class="text-2xl text-center">
                    {{ $countShipped }}
                </p>
                <p class="text-center uppercase">@lang('senting')</p>
                <p class="mt-2 text-2xl text-center">
                    <i class="fas fa-truck"></i>
                </p>
            </a>
            <a href="{{ route('orders.index', ['status'=>App\Models\Order::STATUS_COMPLETED]) }}" class="px-12 pt-8 pb-4 bg-pink-500 bg-opacity-75 rounded-lg">
                <p class="text-2xl text-center">
                    {{ $countCompleted }}
                </p>
                <p class="text-center uppercase">@lang('completed')</p>
                <p class="mt-2 text-2xl text-center">
                    <i class="fas fa-check-circle"></i>
                </p>
            </a>
            <a href="{{ route('orders.index', ['status'=>App\Models\Order::STATUS_CANCELED]) }}" class="px-12 pt-8 pb-4 bg-green-500 bg-opacity-75 rounded-lg">
                <p class="text-2xl text-center">
                    {{ $countCanceled }}
                </p>
                <p class="text-center uppercase">@lang('canceled')</p>
                <p class="mt-2 text-2xl text-center">
                    <i class="fas fa-times-circle"></i>
                </p>
            </a>
        </section>

        <section class="px-12 py-8 mt-12 text-gray-700 bg-white rounded-lg shadow-lg">
            <h1 class="mb-4 text-2xl">@lang('Recent orders')</h1>

            <ul>
                @foreach ($orders as $order)
                    <li>
                        <a href="{{ route('orders.show', $order) }}" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <span class="w-12 text-center">
                                @switch($order->status)
                                    @case(App\Models\Order::STATUS_PENDING)
                                        <i class="text-red-500 opacity-50 fas fa-business-time"></i>
                                        @break
                                    @case(App\Models\Order::STATUS_RECEIVED)
                                        <i class="text-gray-500 opacity-50 fas fa-credit-card"></i>
                                        @break
                                    @case(App\Models\Order::STATUS_SHIPPED)
                                        <i class="text-yellow-500 opacity-50 fas fa-truck"></i>
                                        @break
                                    @case(App\Models\Order::STATUS_COMPLETED)
                                        <i class="text-pink-500 opacity-50 fas fa-check-circle"></i>
                                        @break
                                    @case(App\Models\Order::STATUS_ANNULED)
                                    @case(App\Models\Order::STATUS_CANCELED)
                                        <i class="text-green-500 opacity-50 fas fa-times-circle"></i>
                                        @break

                                    @default

                                @endswitch
                            </span>

                            <span>
                                @capitalizeLang('order'): {{ $order->id }}
                                <br>
                                {{ $order->created_at->format('d/m/Y') }}
                            </span>

                            <div class="ml-auto">
                                <span class="font-bold">
                                    @switch($order->status)
                                        @case(App\Models\Order::STATUS_PENDING)
                                            @capitalizeLang('pending')
                                            @break
                                        @case(App\Models\Order::STATUS_RECEIVED)
                                            @capitalizeLang('received')
                                            @break
                                        @case(App\Models\Order::STATUS_SHIPPED)
                                            @capitalizeLang('senting')
                                            @break
                                        @case(App\Models\Order::STATUS_COMPLETED)
                                            @capitalizeLang('completed')
                                            @break
                                        @case(App\Models\Order::STATUS_ANNULED)
                                        @case(App\Models\Order::STATUS_CANCELED)
                                            @capitalizeLang('canceled')
                                            @break
                                        @default
                                    @endswitch
                                </span>

                                <br>

                                <span class="text-sm">
                                    {{ $order->total }} USD
                                </span>
                            </div>

                            <span>
                                <i class="ml-6 fas fa-angle-right"></i>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
</x-app-layout>
