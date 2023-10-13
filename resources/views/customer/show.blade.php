<x-app-layout>
    <x-card>
        <x-page-header>Customer Information</x-page-header>

        <div class="mt-2 grid grid-cols-3 gap-y-5">
            <div class="flex flex-col">
                <span class="font-semibold">Name</span>
                {{ $customer->name }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Email </span>
                {{ $customer->email }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Gender</span>
                {{ ucwords($customer->gender ?? '-') }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Phone Number</span>
                {{ $customer->phone_number ?? '-' }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Location</span>
                @isset($customer->location)
                    {{ $customer->location->district }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Associated Bank</span>
                @isset($customer->bank)
                    {{ $customer->bank->bank_name }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Account Created At:</span>
                {{ \Carbon\Carbon::parse($customer->created_at)->format('jS, M Y \a\t h:i A') }}
            </div>
        </div>
    </x-card>
</x-app-layout>
