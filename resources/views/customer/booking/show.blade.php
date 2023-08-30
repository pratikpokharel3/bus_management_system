<x-app-layout>
    <x-card>
        <div class="flex justify-between">
            <x-go-back></x-go-back>

            @if ($booking->booking_status == \App\Enums\BookingStatus::ACCEPTED->value)
                <div class="flex gap-x-3">
                    <form method="POST" action="{{ route('customer.booking.invoice.view', $booking) }}">
                        @csrf
                        <x-primary-button>View Invoice</x-primary-button>
                    </form>

                    <form method="POST" action="{{ route('customer.booking.invoice.download', $booking) }}">
                        @csrf
                        <x-primary-button>Download Invoice</x-primary-button>
                    </form>
                </div>
            @endif
        </div>

        <x-page-header class="mt-3">Booking Information</x-page-header>

        @if ($booking->booking_status != \App\Enums\BookingStatus::REJECTED->value)
            <div class="flex justify-end">
                <form method="POST" action="{{ route('customer.booking.destroy', $booking) }}">
                    @csrf
                    @method('DELETE')
                    <x-primary-button>
                        Cancel Booking
                    </x-primary-button>
                </form>
            </div>
        @endif

        @if ($booking->booking_status == \App\Enums\BookingStatus::ACCEPTED->value)
            <x-alert class="mb-5 mt-4" variant="accepted">
                {{ $booking->remarks }}
            </x-alert>
        @endif

        @if ($booking->booking_status == \App\Enums\BookingStatus::REJECTED->value)
            <x-alert class="mb-5 mt-4" variant="rejected">
                <div>Booking Cancelled</div>
                <div class="flex gap-x-1">
                    <div>Reason:</div>
                    <div>{{ $booking->remarks }}</div>
                </div>
            </x-alert>
        @endif

        @if (session()->has('booking_delete'))
            <x-alert class="mb-5 mt-4" variant="rejected">
                {!! session('booking_delete') !!}
            </x-alert>
        @endif

        <div class="mt-2 grid grid-cols-3 gap-y-5">
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
                <span class="font-semibold">Number of Tickets</span>
                {{ $booking->total_tickets }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Seats Booked</span>
                {{ implode(', ', explode(',', $booking->seats_booked)) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Departure</span>
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
                Rs. {{ number_format($booking->grand_total) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bank Name (Payment Method)</span>
                @isset($booking->bank)
                    {{ $booking->bank->bank_name }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Booking Status</span>
                {{ ucwords($booking->booking_status) }}
            </div>
        </div>
    </x-card>
</x-app-layout>
