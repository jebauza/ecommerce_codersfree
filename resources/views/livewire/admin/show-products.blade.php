<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Lista de productos
            </h2>

            <x-button-link class="ml-auto" href="{{ route('admin.products.create') }}">
                @capitalizeLang('add')
            </x-button-link>
        </div>
    </x-slot>

    <!-- component -->
    <div class="container py-12">
        <x-table-responsive>
            <div class="px-6 py-4">
                <x-jet-input type="text" placeholder="Buscar" class="w-full" wire:model="search"></x-jet-input>
            </div>

            @if ($products->count())
                <table class="w-full text-sm text-left text-gray-500 bg-white border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-900 uppercase">@lang('name')</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-900 uppercase">@lang('category')</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-900 uppercase">@lang('status')</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-900 uppercase">@lang('price')</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-900"></th>
                        </tr>
                    </thead>
                    <tbody class="border-t border-gray-100 divide-y divide-gray-100">
                        @foreach ($products as $product)
                        <tr class="hover:bg-gray-100">
                            <td class="flex items-center gap-3 px-6 py-4 font-normal text-gray-900">
                                <div class="relative w-10 h-10">
                                    <img src="{{ $product->images->first()->link }}" class="object-cover object-center w-full h-full rounded-full" alt="" />
                                </div>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700">{{ $product->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-700">
                                    {{ $product->category->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @switch($product->status)
                                    @case(1)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold text-red-700 bg-red-200 rounded-full">
                                            Borrador
                                        </span>
                                        @break

                                    @case(2)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold text-green-700 bg-green-200 rounded-full">
                                            Publicado
                                        </span>
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-700">
                                    {{ $product->price }} USD
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-4">
                                    <a href="{{ route('admin.products.edit', $product) }}">
                                        <i class="text-xl text-blue-500 hover:text-blue-800 fas fa-pencil"></i>
                                    </a>
                                    <a href="#">
                                        <i class="text-xl text-red-500 hover:text-red-800 fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <div class="px-6 py-4">
                    @lang('No product matches those parameters')
                </div>
            @endif

            @if ($products->hasPages())
                <div class="px-6 py-4">
                    {{ $products->links() }}
                </div>
            @endif

        </x-table-responsive>
    </div>
</div>
