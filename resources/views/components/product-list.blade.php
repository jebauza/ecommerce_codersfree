@props(['product'])

<li class="mb-4 bg-white rounded-lg shadow">
    <article class="flex">
        <figure>
            <img class="object-cover object-center w-56 h-48" src="{{ $product->images->first()->link }}" alt="">
        </figure>

        <div class="flex flex-col flex-1 px-6 py-4">
            <div class="flex justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-700">{{ $product->name }}</h1>
                    <p class="font-bold text-gray-700">US {{ $product->price }}</p>
                </div>

                <div class="flex items-center">
                    <ul class="flex text-sm">
                        <li>
                            <i class="mr-1 text-yellow-400 fas fa-star"></i>
                        </li>
                        <li>
                            <i class="mr-1 text-yellow-400 fas fa-star"></i>
                        </li>
                        <li>
                            <i class="mr-1 text-yellow-400 fas fa-star"></i>
                        </li>
                        <li>
                            <i class="mr-1 text-yellow-400 fas fa-star"></i>
                        </li>
                        <li>
                            <i class="mr-1 text-yellow-400 fas fa-star"></i>
                        </li>
                        <li>
                            <i class="mr-1 text-yellow-400 fas fa-star"></i>
                        </li>
                    </ul>

                    <span class="text-sm text-gray-700">(24)</span>
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
