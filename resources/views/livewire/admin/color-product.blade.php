<div>
    <div class="p-6 my-12 bg-white rounded-lg shadow-lg">

        {{-- Color --}}
        <div class="mb-6">
            <x-jet-label class="font-bold">@capitalizeLang('colour')</x-jet-label>
            <div class="grid grid-cols-6 gap-6">
                @foreach($colors as $color)
                    <label>
                        <input wire:model.defer="colorId" type="radio" name="colorId" value="{{ $color->id }}">
                        <span class="ml-2 text-gray-700 capitalize">
                            {{ __($color->name) }}
                        </span>
                    </label>
                @endforeach
            </div>

            <x-jet-input-error for="colorId" />
        </div>

        {{-- Quantity --}}
        <div>
            <x-jet-label class="font-bold">@capitalizeLang('quantity')</x-jet-label>
            <x-jet-input wire:model.defer="quantity" type="number" placeholder="Ingrese una cantidad" class="w-full"/>
            <x-jet-input-error for="quantity" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button wire:click="saveColor" wire:loading.attr="disabled" wire:target="saveColor">
                @capitalizeLang('add')
            </x-jet-button>
        </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <table>
            <thead>
                <tr>
                    <th class="w-1/3 px-4 py-2">@capitalizeLang('colour')</th>
                    <th class="w-1/3 px-4 py-2">@capitalizeLang('quantity')</th>
                    <th class="w-1/3 px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($productColors as $key => $productColor)
                    <tr wire:key="productColor_{{ $productColor->id }}">
                        <td class="px-4 py-2 capitalize">{{ __($productColor->name) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $productColor->pivot->quantity }} unidades</td>
                        <td class="flex px-4 py-2">
                            <x-jet-secondary-button class="ml-auto mr-2"
                                wire:click="showModal({{ $productColor->id }})"
                                wire:loading.attr="disabled"
                                wire:target="showModal({{ $productColor->id }})">
                                @capitalizeLang('update')
                            </x-jet-secondary-button>
                            <x-jet-danger-button wire:click="$emit('askDeleteColor', {{ $productColor->id }})">
                                @capitalizeLang('delete')
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-jet-dialog-modal wire:model="modalOpen">
        <x-slot name="title">
            @capitalizeLang('edit')
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label class="font-bold">@capitalizeLang('colour')</x-jet-label>

                <select wire:model="modalColorId" class="w-full form-control">
                    <option value="">@lang('Select a color')</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}">@capitalizeLang($color->name)</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-jet-label class="font-bold">@capitalizeLang('quantity')</x-jet-label>

                <x-jet-input wire:model="modalQuantity" class="w-full" type="number" placeholder="Ingrese una cantidad"></x-jet-input>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('modalOpen', false)" class="mr-1">@capitalizeLang('cancel')</x-jet-secondary-button>
            <x-jet-button wire:click="updateColor()" wire:loading.attr="disabled" wire:target="updateColor()">
                @capitalizeLang('update')
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('script')
        <script>
            Livewire.on('askDeleteColor', colorId => {
                Swal.fire({
                    title: "@lang('Are you sure?')",
                    text: `@lang("You won't be able to revert this!")`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "@lang('Yes, delete it!')"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteColor', colorId);
                        Swal.fire({
                            title: "@capitalizeLang('removing')" + "..."
                        })
                        Swal.showLoading()
                    }
                });
            });
        </script>
    @endpush
</div>
