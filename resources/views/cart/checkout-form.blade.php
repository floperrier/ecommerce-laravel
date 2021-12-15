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

    {{-- Payment error --}}
    <div id="payment-error-container"
        class="hidden flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 mt-10">
        <div class="flex items-center justify-center w-12 bg-red-500">
            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z" />
            </svg>
        </div>
        <div class="px-4 py-2 -mx-3">
            <div class="mx-3">
                <span class="font-semibold text-red-500 dark:text-red-400">Error</span>
                <p id="payment-error" class="text-sm text-gray-600 dark:text-gray-200"></p>
            </div>
        </div>
    </div>

    <div class="leading-loose mx-auto">
        <form id="checkout-form" method="POST" action="{{ route('checkout') }}"
            class="mx-auto max-w-xl m-4 p-10 bg-white rounded shadow-xl">
            @csrf
            {{-- <p class="text-gray-800 font-medium">Contact information</p>
            <div class="mt-2">
                <x-label class="block text-sm text-gray-600" for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div> --}}
            <p class="mt-4 text-gray-800 font-medium">Shipping information</p>
            <label class="mt-4 text-gray-800 font-medium">Address</label>
            <select name="address" class="block p-2 text-gray-600 w-full text-sm" onchange="this.form.submit()">
                @foreach ($addresses as $address)
                    <option {{ old('address') == $address->id ? 'selected' : '' }} value="{{ $address->id }}">
                        {{ $address->address }} - {{ $address->zipcode }} {{ $address->city }}
                        ({{ $address->country }})</option>
                @endforeach
            </select>
            <a href="{{ route('address.add') }}">
                <x-button type="button" class="mt-8">
                    Add address
                </x-button>
            </a>
            <p class="mt-4 text-gray-800 font-medium">Payment information</p>
            <div class="mt-2">
                <x-label class="block text-sm text-gray-600" for="cardHolderName" :value="__('Card holder')" />
                <x-input id="cardHolderName" class="block mt-1 w-full" type="text" name="cardHolderName"
                    :value="old('cardHolderName')" required />
            </div>
            <div class="mt-4">
                <x-label class="block text-sm text-gray-600" for="cardHolderName" :value="__('Card details')" />
                <!-- Stripe Elements Placeholder -->
                <div id="card-element"></div>
                <input type="hidden" name="paymentMethodId" id="paymentMethod" />
            </div>

            <x-button class="mt-8" type="submit" id="card-button">
                Process Payment
            </x-button>

        </form>
    </div>

    <script>
        const stripe = Stripe(" {{ env('STRIPE_KEY') }}");
        console.log(stripe);

        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            classes: {
                base: 'StripeElement rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full'
            }
        });

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('cardHolderName');
        const cardButton = document.getElementById('card-button');

        cardButton.addEventListener('click', async (e) => {
            e.preventDefault();
            const {paymentMethod,error} = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            );

            if (error) {
                document.getElementById('payment-error-container').classList.remove('hidden');
                document.getElementById('payment-error').textContent = error.message;
            } else {
                document.getElementById('payment-error-container').classList.add('hidden');
                document.getElementById('paymentMethod').value = paymentMethod.id
                document.getElementById('checkout-form').submit();
            }

        });
    </script>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
    @endpush
</x-app-layout>
