<div>
    <div class="mb-6 bg-white rounded-lg shadow-lg">
        <div class="flex items-center justify-between px-6 py-2">
            <h1 class="font-semibold text-gray-700 uppercase">{{ $category->name }}</h1>

            <div class="grid grid-cols-2 text-gray-500 border-gray-200 divide-x divide-gray-200">
                <i wire:click="$set('view', 'grid')" class="fas fa-border-all p-3 cursor-pointer {{ $view == 'grid' ? 'text-orange-500' : '' }}"></i>
                <i wire:click="$set('view', 'list')" class="fas fa-th-list p-3 cursor-pointer {{ $view == 'list' ? 'text-orange-500' : '' }}"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
        <aside>
            <h2 class="mb-2 font-semibold text-center">Subcategorías</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($category->subcategories as $subcategory)
                    <li class="py-2 text-sm">
                        <a wire:click="$set('searchSubcategoryId', '{{ $subcategory->id }}')"
                            class="cursor-pointer hover:text-orange-500 capitalize {{ $searchSubcategoryId == $subcategory->id ? 'text-orange-500 font-semibold' : '' }}">{{ $subcategory->name }}</a>
                    </li>
                @endforeach
            </ul>

            <h2 class="mt-4 mb-2 font-semibold text-center">Marcas</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($category->brands as $brand)
                    <li class="py-2 text-sm">
                        <a wire:click="$set('searchBrandId', '{{ $brand->id }}')"
                            class="cursor-pointer hover:text-orange-500 capitalize {{ $searchBrandId == $brand->id ? 'text-orange-500 font-semibold' : '' }}">{{ $brand->name }}</a>
                    </li>
                @endforeach
            </ul>

            <x-jet-button wire:click="clear" class="mt-4">
                Eliminar filtros
            </x-jet-button>
        </aside>

        <div class="md:col-span-2 lg:col-span-4">
            @if ($view == 'grid')
                <ul class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach ($products as $product)
                        <li class="bg-white rounded-lg shadow">
                            <article>
                                <figure>
                                    <img class="object-cover object-center w-full h-48" src="{{ $product->images->first()->link }}" alt="">
                                </figure>

                                <div class="px-6 py-4">
                                    <h1 class="text-lg font-semibold">
                                        <a href="{{ route('products.show', $product) }}">{{ Str::limit($product->name, 20) }}</a>
                                    </h1>

                                    <p class="font-bold text-gray-700">US$ {{ $product->price }}</p>
                                </div>
                            </article>
                        </li>
                    @endforeach
                </ul>
            @else
                <ul>
                    @foreach ($products as $product)
                        <x-product-list :product="$product"></x-product-list>
                    @endforeach
                </ul>
            @endif

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>
