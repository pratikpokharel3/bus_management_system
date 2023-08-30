<x-app-layout>
    <x-card>
        <div class="flex justify-between">
            <x-go-back></x-go-back>

            @if ($booking->booking_status === \App\Enums\BookingStatus::ACCEPTED->value)
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
            @endif
        </div>

        <x-page-header class="mt-3">Booking Information</x-page-header>

        @if ($booking->booking_status == \App\Enums\BookingStatus::ACCEPTED->value)
            <x-alert
                class="mb-5 mt-4"
                variant="accepted"
            >
                Booking Confirmed
            </x-alert>
        @endif

        @if ($booking->booking_status == \App\Enums\BookingStatus::REJECTED->value)
            <x-alert
                class="mb-5 mt-4"
                variant="rejected"
            >
                <div>Booking Cancelled</div>
                <div class="flex gap-x-1">
                    <div>Reason:</div>
                    <div>{{ $booking->remarks }}</div>
                </div>
            </x-alert>
        @endif

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
                <span class="font-semibold">Number of Tickets</span>
                {{ $booking->total_tickets }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Seats Booked</span>
                {{ implode(', ', explode(',', $booking->seats_booked)) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Departure DateTime</span>
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

        <script type="text/javascript">
            let toggleState = "<?php echo old('booking_status'); ?>" === 'rejected'
        </script>

        @if ($booking->booking_status == \App\Enums\BookingStatus::PENDING->value)
            <hr class="mt-5">

            <div x-data="{
                open: toggleState,
                toggle(e) {
                    if (e.target.value === 'rejected') {
                        this.open = true;
                    } else {
                        this.open = false;
                    }
                }
            }">
                <form
                    method="POST"
                    action="{{ route('admin.booking.update', $booking) }}"
                >
                    @csrf
                    @method('PATCH')
                    <div class="mt-5 w-1/3">
                        <x-input-label
                            class="text-lg font-semibold"
                            for="booking_status"
                        >
                            Change Booking Status
                        </x-input-label>

                        <x-select
                            class="mt-1"
                            id="booking_status"
                            name="booking_status"
                            :value="old('booking_status', $booking->booking_status)"
                            @input="toggle"
                        >
                            @foreach (\App\Enums\BookingStatus::cases() as $booking_status)
                                @if ($booking_status->value !== \App\Enums\BookingStatus::PENDING->value)
                                    <option
                                        value="{{ $booking_status->value }}"
                                        {{ old('booking_status', $booking->booking_status) === $booking_status->value ? 'selected' : '' }}
                                    >
                                        {{ ucwords(str_replace('_', ' ', $booking_status->value)) }}
                                    </option>
                                @endif
                            @endforeach
                        </x-select>

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('booking_status')"
                        />
                    </div>

                    <template x-if="open">
                        <div class="mt-4 w-1/2">
                            <x-input-label for="remarks">Rejected Message</x-input-label>

                            <x-textarea
                                class="mt-1"
                                id="remarks"
                                name="remarks"
                                rows="4"
                                placeholder="Enter message here..."
                            >
                            </x-textarea>

                            <x-input-error
                                class="mt-2"
                                :messages="$errors->get('remarks')"
                            />
                        </div>
                    </template>

                    <div class="mt-5 w-1/3">
                        <x-primary-button>Change Status</x-primary-button>
                    </div>
                </form>
            </div>
        @endif
    </x-card>
</x-app-layout>
