<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My account') }}
        </h2>
    </x-slot>

    @if (session('status'))

        <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 my-8">
            <div class="flex items-center justify-center w-12 bg-green-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500 dark:text-green-400">Success</span>
                    <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('status') }}</p>
                </div>
            </div>
        </div>

    @endif

    <div class="container px-5 py-24 mx-auto text-gray-900 bg-gray-200">
        <div class="p-4 flex">
            <h1 class="text-3xl">
                Orders
            </h1>
        </div>
        <div class="px-3 py-4 flex justify-center">
            <table class="table w-full text-md bg-white shadow-md rounded mb-4">
                <thead>
                    <tr class="border-b">
                        <th class="text-center p-3 px-5">Id</th>
                        <th class="text-center p-3 px-5">Status</th>
                        <th class="text-center p-3 px-5">Total</th>
                        <th class="text-center p-3 px-5">Shipping Address</th>
                        <th class="text-center p-3 px-5">Date</th>
                        <th class="text-center p-3 px-5">Details</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="gap-10">
                    @foreach ($orders as $order)
                        <tr class="border-b hover:bg-orange-100 bg-gray-100 text-center py-10">
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->total }}€</td>
                            <td>{{ $order->address()->shipping_name }}<br>
                                {{ $order->address()->address }}<br>
                                {{ $order->address()->zipcode }} {{ $order->address()->city }}<br>
                                {{ $order->address()->country }}
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <a href="{{ route('order.details', ['id' => $order->id]) }}">
                                    <button type="submit"
                                        class="mr-3 text-sm bg-indigo-700 hover:bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">Détails</button>
                                </a>
                            </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="container px-5 py-24 mx-auto text-gray-900 bg-gray-200">
            <div class="p-4 flex">
                <h1 class="text-3xl">
                    Addresses
                </h1>
                <a href="{{ route('address.add') }}">
                    <x-button type="button" class="ml-4">
                        Add address
                    </x-button>
                </a>
            </div>
            <div class="px-3 py-4 flex justify-center">
                <table class="w-full text-md bg-white shadow-md rounded mb-4">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3 px-5">Shipping name</th>
                            <th class="text-left p-3 px-5">Address</th>
                            <th class="text-left p-3 px-5">City</th>
                            <th class="text-left p-3 px-5">Zipcode</th>
                            <th class="text-left p-3 px-5">Country</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addresses as $address)
                            <tr class="border-b hover:bg-orange-100 bg-gray-100">
                                <form action="{{ route('address.update', ['id' => $address->id]) }}" method="post">
                                    @csrf
                                    <td>
                                        <x-input class="block mt-1 w-full" type="text" name="shipping_name"
                                            :value="$address->shipping_name" required />
                                    </td>
                                    <td>
                                        <x-input class="block mt-1 w-full" type="text" name="address"
                                            :value="$address->address" required />
                                    </td>
                                    <td>
                                        <x-input class="block mt-1 w-full" type="text" name="city"
                                            :value="$address->city" required />
                                    </td>
                                    <td>
                                        <x-input class="block mt-1 w-full" type="text" name="zipcode"
                                            :value="$address->zipcode" required />
                                    </td>
                                    <td>
                                        <x-input class="block mt-1 w-full" type="text" name="country"
                                            :value="$address->country" required />
                                    </td>
                                    <td class="p-3 px-5 flex justify-end">

                                        <button type="submit"
                                            class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button>
                                        <a href="{{ route('address.delete', ['id' => $address->id]) }}">
                                            <button type="button"
                                                class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                        </a>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</x-app-layout>
