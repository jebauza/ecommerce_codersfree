<div>
    <div class="bg-white rounded-lg shadow-lg mb-4">
        <div class="px-6 py-2 flex justify-between items-center">
            <h1 class="font-semibold text-gray-700 uppercase">{{ $category->name }}</h1>

            <div class="grid grid-cols-2 border-gray-200 divide-x divide-gray-200 text-gray-500">
                <i class="fas fa-border-all p-3 cursor-pointer"></i>
                <i class="fas fa-th-list p-3"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-5">
        <aside>
            <h2 class="font-semibold text-center mb-2">Subcategorías</h2>

            <ul>
                @foreach ($category->subcategories as $subcategory)
                    <li class="my-2 text-sm">
                        <a href="" class="cursor-pointer hover:text-orange-500 capitalize">{{ $subcategory->name }}</a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <div class="col-span-4">
            <ul class="grid grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <li class="bg-white rounded-lg shadow">
                        <article>
                            <figure>
                                <img class="object-cover object-center w-full h-48" src="{{ Storage::url($product->images->first()->url) }}" alt="">
                            </figure>

                            <div class="px-6 py-4">
                                <h1 class="text-lg font-semibold">
                                    <a href="">{{ Str::limit($product->name, 20) }}</a>
                                </h1>

                                <p class="font-bold text-gray-700">US$ {{ $product->price }}</p>
                            </div>
                        </article>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>
