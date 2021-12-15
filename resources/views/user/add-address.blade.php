<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add shipping address') }}
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

    <div class="leading-loose mx-auto">
        <form method="POST" action="#" class="mx-auto max-w-xl m-4 p-10 bg-white rounded shadow-xl">
            @csrf
            <p class="mt-4 text-gray-800 font-medium">Shipping information</p>
            <div class="mt-2">
                <x-label class="block text-sm text-gray-600" for="shipping_name" :value="__('Shipping name')" />
                <x-input id="shipping_name" class="block mt-1 w-full" type="text" name="shipping_name" :value="old('shipping_name')" required />
            </div>
            <div class="mt-2">
                <x-label class="block text-sm text-gray-600" for="address" :value="__('Address')" />
                <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                    required />
            </div>
            <div class="mt-2">
                <x-label class="block text-sm text-gray-600" for="city" :value="__('City')" />
                <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
            </div>
            <div class="inline-block mt-2 w-1/2 pr-1">
                <x-label class="block text-sm text-gray-600" for="country" :value="__('Country')" />
                <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')"
                    required />
            </div>
            <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
                <x-label class="block text-sm text-gray-600" for="zipcode" :value="__('Zipcode')" />
                <x-input id="zipcode" class="block mt-1 w-full" type="text" name="zipcode" :value="old('zipcode')" required />
            </div>

            <x-button class="mt-8" type="submit" id="card-button">
                Add address
            </x-button>

        </form>
    </div>
</x-app-layout>
