<x-app-layout>
    <div class="container py-8">
        @foreach ($categories as $category)
            <section class="mb-6">
                <h1 class="text-lg font-semibold text-gray-700 uppercase">
                    {{ $category->name }}
                </h1>

                @livewire('category-products', ['category' => $category])
            </section>
        @endforeach
    </div>

    @push('script')
        <script>
            Livewire.on('glider', function(id) {
                new Glider(document.querySelector(`.glider-${id}`), {
                    slidesToShow: 5.5,
                    slidesToScroll: 5,
                    draggable: true,
                    dots: `.glider-${id}~ .dots`,
                    arrows: {
                        prev: `.glider-${id}~ .glider-prev`,
                        next: `.glider-${id}~ .glider-next`
                    }
                });
            })

            // window.addEventListener('load', function(){

            // });
        </script>
    @endpush
</x-app-layout>
