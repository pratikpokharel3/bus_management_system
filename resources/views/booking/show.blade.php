<x-app-layout>
    <x-card>
        <div class="flex justify-between">
            <div class="flex items-center gap-x-3">
                <x-go-back href="{{ route('admin.booking.index') }}"></x-go-back>
                <x-page-header>Booking Departure</x-page-header>
            </div>

            <div class="flex gap-x-3">
                <form
                    method="POST"
                    action="{{ route('admin.booking.invoice.view', $booking) }}"
                >
                    @csrf
                    <x-primary-button>View Invoice</x-primary-button>
                </form>

                <form
                    method="POST"
                    action="{{ route('admin.booking.invoice.download', $booking) }}"
                >
                    @csrf
                    <x-primary-button>Download Invoice</x-primary-button>
                </form>
            </div>
        </div>

        <div class="mt-2 grid grid-cols-3 gap-y-5">
            <div class="flex flex-col">
                <span class="font-semibold">Customer Name</span>
                @isset($booking->customer)
                    {{ $booking->customer->name }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Name</span>
                @isset($booking->bus_departure)
                    @isset($booking->bus_departure->bus)
                        {{ $booking->bus_departure->bus->bus_name }}
                    @else
                        -
                    @endisset
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Source-Destination</span>
                @isset($booking->bus_departure)
                    @isset($booking->bus_departure->bus_route)
                        {{ $booking->bus_departure->bus_route->source_location->district }} -
                        {{ $booking->bus_departure->bus_route->destination_location->district }}
                    @else
                        -
                    @endisset
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Number of Tickets Booked</span>
                {{ $booking->total_tickets }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Seats Booked</span>
                {{ implode(', ', explode(',', $booking->seats_booked)) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Departure Datetime</span>
                @isset($booking->bus_departure)
                    {{ \Carbon\Carbon::parse($booking->bus_departure->departure_datetime)->format('jS, M Y \a\t h:i A') }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Booked Date</span>
                {{ \Carbon\Carbon::parse($booking->created_at)->format('jS, M Y \a\t h:i A') }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Total Amount</span>
                Rs. {{ number_format($booking->total_amount) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">VAT</span>
                Rs. {{ number_format($booking->vat) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Grand Total</span>
                Rs. {{ number_format($booking->grand_total) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bank Name</span>
                @isset($booking->bank)
                    {{ $booking->bank->bank_name }}
                @else
                    -
                @endisset
            </div>
        </div>
    </x-card>
</x-app-layout>
