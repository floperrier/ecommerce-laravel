<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Résultat de la recherche') }}
        </h2>
    </x-slot>

    <section class="bg-white py-8">

        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

            <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                    <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl"
                        href="{{ route('product.index') }}">{{ $results_number }} résultats correspondant à '{{ $query }}'</a>

                    <div class="flex items-center" id="store-nav-content">

                        <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                            <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z"></path>
                            </svg>
                        </a>

                        <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                            <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path
                                    d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z">
                                </path>
                            </svg>
                        </a>

                    </div>
                </div>
            </nav>

            <section class="text-gray-600 body-font">
                <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-wrap -m-4">

                        @foreach ($products as $product)
                            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                                <a class="block relative h-48 rounded overflow-hidden" href="{{ route('product.show', ['id' => $product->id]) }}">
                                    <img alt="ecommerce" class="object-cover object-center w-full h-full block"
                                        src="{{ $product->image }}">
                                </a>
                                <div class="mt-4">
                                    <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">CATEGORY</h3>
                                    <h2 class="productName text-gray-900 title-font text-lg font-medium">{!! $product->name !!}</h2>
                                    <h2 class="productDescription">{!! $product->description !!}</h2>
                                    <p class="mt-1">{{ $product->price }} €</p>
                                </div>
                            </div>
                              
                        @endforeach

                        {{-- <script>
                            let text = document.querySelectorAll('.productName, .productDescription');
                            text.forEach(element => {
                                element.textContent.replace()
                            });
                            console.log(text);
                        </script> --}}

                    </div>
                </div>
            </section>
        </div>
    </section>
</x-app-layout>
