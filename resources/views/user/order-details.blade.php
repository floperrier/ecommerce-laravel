<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    {{-- Error --}}
    @if ($errors->any() || session('error'))
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
                    <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('error') }}</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-gray-600 dark:text-gray-200">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="w-3/4 mx-auto flex shadow-md my-10">
        <div class="w-full bg-white px-10 py-10">

            <div class="flex justify-between border-b pb-8">
                <div>
                    <h1 class="font-semibold text-2xl">Order # {{ $order->id }}</h1>
                    <h2>Passed on {{ $order->created_at }}</h2>
                </div>
                <h2 class="font-semibold text-2xl">{{ $order->details->count() }} items</h2>
            </div>

            <div class="flex mt-10 mb-5">
                <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Product Details</h3>
                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Quantity
                </h3>
                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Unit Price
                </h3>
                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Total</h3>
            </div>

            @foreach ($order->details as $item)
                <div class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5">
                    <div class="flex w-2/5">
                        <!-- product -->
                        <div class="w-20">
                            <img class="h-24" src="{{ $item->product->image }}" alt="">
                        </div>
                        <div class="flex flex-col justify-between ml-4 flex-grow">
                            <a href="{{ route('product.show', ['id' => $item->product->id]) }}"><span
                                    class="font-bold text-sm">{{ $item->product->name }}</span></a>
                            <span class="text-red-500 text-xs">Apple</span>
                        </div>
                    </div>

                    <div class="flex justify-center items-center w-1/5">
                        <span class="text-center w-1/5 font-semibold text-sm">{{ $item->quantity }}</span>
                    </div>
                    <span class="text-center w-1/5 font-semibold text-sm">{{ $item->product->price }}
                        €</span>
                    <span
                        class="text-center w-1/5 font-semibold text-sm">{{ $item->price * $item->quantity }}
                        €</span>
                </div>
            @endforeach


            <a href="{{ route('account') }}" class="flex font-semibold text-indigo-600 text-sm mt-10">

                <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512">
                    <path
                        d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                </svg>
                Return on account page
            </a>
        </div>

    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
                    <h2 class="text-xl">{{ $order->total }}€</h2>
                    <ul>
                        @foreach ($order->details as $item)
                            <h2>{{ $item->product->name }} - x{{ $item->quantity }}</h2>
                        @endforeach
                    </ul>
                    {{-- <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <label>
                                            <input type="checkbox" class="checkbox">
                                        </label>
                                    </th>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar">
                                                <div class="w-12 h-12 mask mask-squircle">
                                                    <img src="/tailwind-css-component-profile-2@56w.png"
                                                        alt="Avatar Tailwind CSS Component">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">
                                                    Hart Hagerty
                                                </div>
                                                <div class="text-sm opacity-50">
                                                    United States
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        Zemlak, Daniel and Leannon

                                        <br>
                                        <span class="badge badge-outline badge-sm">Desktop Support Technician</span>
                                    </td>
                                    <td>Purple</td>
                                    <th>
                                        <button class="btn btn-ghost btn-xs">details</button>
                                    </th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Job</th>
                                    <th>Favorite Color</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
