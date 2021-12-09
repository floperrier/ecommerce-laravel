<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    {{-- Error --}}
    @if ($errors->any())
        <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 mt-10">
            <div class="flex items-center justify-center w-12 bg-red-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z" />
                </svg>
            </div>
            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-red-500 dark:text-red-400">Error</span>
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-gray-600 dark:text-gray-200">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="container mx-auto mt-10">
        <div class="flex shadow-md my-10">
            <div class="w-3/4 bg-white px-10 py-10">

                <div class="flex justify-between border-b pb-8">
                    <h1 class="font-semibold text-2xl">Shopping Cart</h1>
                    <h2 class="font-semibold text-2xl">{{ $items->count() }} items</h2>
                </div>

                <div class="flex mt-10 mb-5">
                    <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Product Details</h3>
                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Quantity
                    </h3>
                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Unit Price
                    </h3>
                    <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Total</h3>
                </div>

                @if ($items->count() < 1)
                    <p class="block mx-auto text-xl text-center mt-10">You got no item in your card</p>
                @else
                    @foreach ($items as $item)
                        <div class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5">
                            <div class="flex w-2/5">
                                <!-- product -->
                                <div class="w-20">
                                    <img class="h-24" src="{{ $item->model->image }}" alt="">
                                </div>
                                <div class="flex flex-col justify-between ml-4 flex-grow">
                                    <a href="{{ route('product.show', ['id' => $item->model->id]) }}"><span
                                            class="font-bold text-sm">{{ $item->name }}</span></a>
                                    <span class="text-red-500 text-xs">Apple</span>
                                    <a href="{{ route('cart.remove', ['id' => $item->id]) }}"
                                        class="font-semibold hover:text-red-500 text-gray-500 text-xs">Remove</a>
                                </div>
                            </div>

                            <div class="flex justify-center items-center w-1/5">
                                <form id="update_item" action="{{ route('cart.update.item', ['id' => $item->id]) }}"
                                    method="POST">
                                    @csrf
                                    <input id="quantity-{{ $item->id }}" name="quantity" class="mx-2 border text-center w-16"
                                        type="number" min="0" value="{{ $item->quantity }}">
                                </form>
                                <button form="update_item"
                                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                    type="submit">Update</button>
                            </div>
                            <span
                                class="text-center w-1/5 font-semibold text-sm">{{ $item->attributes->priceWithVAT }}
                                €</span>
                            <span
                                class="text-center w-1/5 font-semibold text-sm">{{ $item->attributes->priceWithVAT * $item->quantity }}
                                €</span>
                        </div>
                    @endforeach
                @endif


                <a href="{{ route('product.index') }}" class="flex font-semibold text-indigo-600 text-sm mt-10">

                    <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512">
                        <path
                            d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                    </svg>
                    Continue Shopping
                </a>
            </div>

            <div id="summary" class="w-1/4 px-8 py-10">
                <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>
                {{-- @foreach ($items as $item)
                    <div class="flex justify-between my-4 mb-5">
                        <span class="font-semibold text-sm uppercase">{{ $item->name }} ({{ $item->quantity }})</span>
                        <span class="font-semibold text-sm">{{ $item->getPriceSum() }} €</span>
                    </div>
                @endforeach --}}
                <form id="shipping" method="POST" action="{{ route('cart.update') }}">
                    @csrf
                    <label class="font-medium inline-block mb-3 text-sm uppercase pt-4">Shipping</label>
                    <select name="shipping" class="block p-2 text-gray-600 w-full text-sm"
                        onchange="this.form.submit()">
                        @foreach ($shippingMethods as $shippingMethod)
                            <option {{ $selectedShipping->getName() == $shippingMethod->label ? 'selected' : null }}
                                value="{{ $shippingMethod->name }}">{{ $shippingMethod->label }} -
                                {{ $shippingMethod->price }} €</option>
                        @endforeach
                    </select>
                </form>
                <div class="py-10">
                    <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase">Promo Code</label>
                    <input type="text" id="promo" placeholder="Enter your code" class="p-2 text-sm w-full">
                </div>
                <button class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase">Apply</button>
                <div class="border-t mt-8 pt-4 gap-4 flex flex-col">
                    <div class="flex font-semibold justify-between text-sm uppercase">
                        <span>Subtotal </span>
                        <span>{{ $subTotal }} €</span>
                    </div>
                    <div class="flex font-semibold justify-between text-sm uppercase">
                        <span>VAT (20%)</span>
                        <span>{{ $vat }} €</span>
                    </div>
                    <div class="flex font-semibold justify-between text-sm uppercase">
                        <span>Shipping </span>
                        <span>{{ number_format($selectedShipping->getValue(), 2) }} €</span>
                    </div>
                    <div class="flex font-semibold justify-between text-sm uppercase">
                        <span>Total cost</span>
                        <span>{{ $totalPrice }} €</span>
                    </div>
                    <button
                        class="bg-indigo-500 font-semibold hover:bg-indigo-600 mt-4 py-3 text-sm text-white uppercase w-full">Checkout</button>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
