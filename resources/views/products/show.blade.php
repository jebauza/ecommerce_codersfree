<x-app-layout>
    <div class="container py-8">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="flexslider">
                    <ul class="slides">
                        @foreach ($product->images as $image)
                            <li data-thumb="{{ Storage::url($image->url) }}">
                                <img src="{{ Storage::url($image->url) }}" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div>
                <h1 class="text-xl font-bold text-gray-700">{{ $product->name }}</h1>

                <div class="flex">
                    <p class="text-gray-700">Marca: <a href="" class="underline capitalize hover:text-orange-500">{{ $product->brand->name }}</a></p>
                    <p class="text-gray-700 mx-6">5 <i class="fas fa-star text-sm text-yellow-400"></i></p>
                    <a href="" class="text-orange-500 underline hover:text-orange-600">39 reseñas</a>
                </div>

                <p class="text-2xl font-semibold text-gray-700 my-4">USD {{ $product->price }}</p>

                <div class="bg-white rounded-lg shadow-lg mb-6">
                    <div class="flex items-center p-4">
                        <span class="flex items-center justify-center h-10 w-10 rounded-full bg-green-700">
                            <i class="fas fa-truck text-sm text-white"></i>
                        </span>

                        <div class="ml-4">
                            <p class="text-left font-semibold text-green-700">Se hace envío a todo el Perú</p>
                            <p>Recibelo el {{ Date::now()->addDays(7)->locale('es')->format('l j F') }}</p>
                        </div>
                    </div>
                </div>

                @if ($product->subcategory->size)
                    @livewire('add-cart-item-size', ['product' => $product])
                @elseif ($product->subcategory->color)
                    @livewire('add-cart-item-color', ['product' => $product])
                @else
                    @livewire('add-cart-item', ['product' => $product])
                @endif
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                $('.flexslider').flexslider({
                    animation: "slide",
                    controlNav: "thumbnails"
                });
            });
        </script>
    @endpush
</x-app-layout>