@props(['category'])

<div class="grid grid-cols-4 p-4">
    <div>
        <p class="mb-3 text-lg font-bold text-center text-gray-500">Subcategorías</p>

        <ul>
            @foreach($category->subcategories as $subcategory)
                <li>
                    <a href="" class="inline-block px-4 py-1 font-semibold text-gray-500 hover:text-orange-500">{{ $subcategory->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="col-span-3">
        <img class="object-cover object-center w-full h-64" src="{{ $category->url }}" alt="">
    </div>
</div>
