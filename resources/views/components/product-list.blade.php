@props(['product'])

<li class="bg-white rounded-lg shadow mb-4">
    <article class="flex">
        <figure>
            <img class="h-48 w-56 object-cover object-center" src="{{ Storage::url($product->images->first()->url) }}" alt="">
        </figure>

        <div class="flex-1 py-4 px-6 flex flex-col">
            <div class="flex justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-700">{{ $product->name }}</h1>
                    <p class="font-bold text-gray-700">US {{ $product->price }}</p>
                </div>

                <div class="flex items-center">
                    <ul class="flex text-sm">
                        <li>
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                        </li>
                    </ul>

                    <span class="text-gray-700 text-sm">(24)</span>
                </div>
            </div>

            <div class="mt-auto mb-6">
                <x-danger-link href="{{ route('products.show', $product) }}">
                    @lang('More information')
                </x-danger-link>
            </div>
        </div>
    </article>
</li>
