<x-app-layout>
    <div class="container py-8">
        <section>
            <h1 class="text-lg font-semibold text-gray-700 uppercase">
                {{ $categories->first()->name }}
            </h1>

            @livewire('category-products', ['category' => $categories->first()])
        </section>
    </div>

    <script>
        window.addEventListener('load', function(){
            new Glider(document.querySelector('.glider'), {
                slidesToShow: 5,
                slidesToScroll: 5,
                draggable: true,
                dots: '.dots',
                arrows: {
                    prev: '.glider-prev',
                    next: '.glider-next'
                }
            });
        });
    </script>
</x-app-layout>
