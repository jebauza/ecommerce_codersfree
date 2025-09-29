<div class="max-w-4xl px-4 py-12 mx-auto text-gray-700 sm:px-6 lg:px-8" x-data="productCreateAlpine()" id="wireCreateProductComponent">
    <h1 class="mb-8 text-3xl font-semibold text-center">@lang('Fill in this information to create :element', ['element'=>__('product')])</h1>

    <div class="grid grid-cols-2 gap-6 mb-4">
        {{-- Category --}}
        <div>
            <x-jet-label value="{{ ucfirst(__('categories')) }}"/>
            <select wire:model="categoryId" name="category" class="w-full form-control">
                <option value="" selected disabled>@lang('Select a :item', ['item'=>__('element')])</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="categoryId"/>
        </div>

        {{-- Subcategory --}}
        <div>
            <x-jet-label value="{{ ucfirst(__('subcategories')) }}"/>
            <select wire:model="subcategory_id" name="subcategory" class="w-full form-control">
                <option value="" selected disabled>@lang('Select a :item', ['item'=>__('element')])</option>
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="subcategory_id"/>
        </div>
    </div>

    {{-- Name --}}
    <div class="mb-4">
        <x-jet-label value="{{ ucfirst(__('name')) }}"/>
        <x-jet-input wire:model="name" class="w-full" type="text" placeholder="{{ __('Write :attribute', ['attribute'=>__('validation.attributes.name')]) }}"/>
        <x-jet-input-error for="name"/>
    </div>

    {{-- Slug --}}
    <div class="mb-4">
        <x-jet-label value="Slug"/>
        <x-jet-input wire:model="slug" class="w-full bg-gray-200" type="text" placeholder="{{ __('Write :attribute', ['attribute'=>'slug']) }}" disabled/>
        <x-jet-input-error for="slug"/>
    </div>

    {{-- Description --}}
    <div class="mb-4">
        <div wire:ignore>
            <x-jet-label value="{{ ucfirst(__('validation.attributes.description')) }}"/>
            <textarea wire:model="description" name="description" class="w-full form-control" rows="4" x-ref="descriptionEditor"></textarea>
            {{-- <textarea class="form-control" wire:model="description" x-data
            x-init="
                ClassicEditor.create($refs.descriptionEditor)
                            .then(function(editor){
                                editor.model.document.on('change:data', () => {
                                    @this.set('description', editor.getData())

                                })
                            });
            " x-ref="descriptionEditor">
            </textarea> --}}
        </div>
        <x-jet-input-error for="description"/>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-4">
        {{-- Brand --}}
        <div>
            <x-jet-label value="{{ ucfirst(__('validation.attributes.brand')) }}"/>
            <select wire:model="brand_id" name="brand" class="w-full form-control">
                <option value="" selected disabled>@lang('Select a :item', ['item'=>__('validation.attributes.brand')])</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="brand_id"/>
        </div>

        {{-- Price --}}
        <div class="mb-4">
            <x-jet-label value="{{ ucfirst(__('validation.attributes.price')) }}"/>
            <x-jet-input wire:model="price" class="w-full" type="number" min="0" step=".01" placeholder="{{ __('Write :attribute', ['attribute'=>__('validation.attributes.price')]) }}"/>
            <x-jet-input-error for="price"/>
        </div>
    </div>

    @if(!empty($this->subcategory) && !$this->subcategory->color && !$this->subcategory->size)
        {{-- Quantity --}}
        <div class="mb-4">
            <x-jet-label value="{{ ucfirst(__('validation.attributes.quantity')) }}"/>
            <x-jet-input wire:model="quantity" class="w-full" type="number" min="0" placeholder="{{ __('Write :attribute', ['attribute'=>__('validation.attributes.quantity')]) }}"/>
            <x-jet-input-error for="quantity"/>
        </div>
    @endif

    <div class="flex">
        <x-jet-button class="ml-auto" wire:click="saveProduct" wire:loading.attr="disabled" wire:target="saveProduct">
            @lang('Create')
        </x-jet-button>
    </div>

    @push('script')
        <script src="{{ asset('js/admin/products/productCreateAlpine.js') }}"></script>
    @endpush
</div>
