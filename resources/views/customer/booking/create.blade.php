<x-app-layout>
    <style>
        .orange_box {
            width: 32px;
            height: 32px;
            background-color: orange;
        }

        .green_box {
            width: 32px;
            height: 32px;
            background-color: green;
        }

        .pending_seats {
            color: white;
            background-color: orange;
        }

        .booked_seats {
            color: white;
            background-color: green;
        }

        .selected_seats {
            color: white;
            background-color: gray;
        }
    </style>

    <x-card
        class="pb-10"
        id="vue-app"
    >
        @if ($kyc_information['is_kyc_verified'])
            <template v-if="departureInfo">
                <x-go-back></x-go-back>

                <x-page-header>Departure Information</x-page-header>

                <div class="mt-2 grid grid-cols-3 gap-y-5">
                    <div>
                        Bus Name
                        <div class="font-semibold">@{{ busInfo.bus_name }}</div>
                    </div>

                    <div>
                        Bus Route
                        <div class="font-semibold">
                            @{{ departureInfo.bus_route.source_location.district }} -
                            @{{ departureInfo.bus_route.destination_location.district }}
                        </div>
                    </div>

                    <div>
                        Departure DateTime
                        <div class="font-semibold">
                            {{-- blade-formatter-disable --}}
                        @{{ new Intl.DateTimeFormat('en-US', {
                                month: 'long',
                                day: 'numeric',
                                year: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                                hour12: true,
                            }).format(new Date(departureInfo.departure_datetime)) }}
                        {{-- blade-formatter-enable --}}
                        </div>
                    </div>

                    <div>
                        Seats Booked
                        <div class="font-semibold">
                            @{{ departureInfo.total_tickets_booked }} out of
                            @{{ busInfo.total_seats }}
                        </div>
                    </div>

                    <div>
                        Bus Plate Number
                        <div class="font-semibold">@{{ busInfo.bus_plate_number }}</div>
                    </div>
                </div>

                <x-alert
                    class="mt-5"
                    variant="info"
                >
                    If you have already booked tickets, you can check your booking status
                    <a
                        class="font-semibold underline"
                        href="{{ route('customer.booking.index') }}"
                    >here</a>.
                </x-alert>

                @if (session()->has('booking'))
                    <x-alert
                        class="mt-5"
                        variant="pending"
                    >
                        {{ session('booking') }}
                    </x-alert>
                @endif

                <div class="mt-8 flex flex-col items-center gap-y-8 border-t pt-5">
                    <div class="text-center">
                        <div class="text-xl font-semibold">Bus Seat Planning</div>
                        <div>Select Seats Below for Booking</div>
                    </div>

                    <div class="flex gap-x-8">
                        <div class="flex items-center gap-x-3">
                            <div class="orange_box"></div>
                            <div>Pending</div>
                        </div>

                        <div class="flex items-center gap-x-3">
                            <div class="green_box"></div>
                            <div>Already Booked</div>
                        </div>
                    </div>

                    <div class="flex w-1/2 flex-col gap-y-5">
                        <div
                            class="flex justify-around"
                            v-for="(seat, idx) in seatList"
                            :key="idx"
                        >
                            <div class="flex items-center justify-between gap-x-5">
                                <div
                                    class="border px-5 py-3 text-center hover:cursor-pointer"
                                    :class="{
                                        'pending_seats': pendingSeatList.includes(seat[0]),
                                        'selected_seats': selectedSeatsList.includes(seat[0]),
                                        'booked_seats': bookedSeatsList.includes(seat[0])
                                    }"
                                    @click="handleSelectedSeats(seat[0])"
                                >
                                    @{{ seat[0] }}
                                </div>

                                <div
                                    class="border px-5 py-3 text-center hover:cursor-pointer"
                                    :class="{
                                        'pending_seats': pendingSeatList.includes(seat[1]),
                                        'selected_seats': selectedSeatsList.includes(seat[1]),
                                        'booked_seats': bookedSeatsList.includes(seat[1])
                                    }"
                                    @click="handleSelectedSeats(seat[1])"
                                >
                                    @{{ seat[1] }}
                                </div>
                            </div>

                            <div class="flex items-center justify-around gap-x-5">
                                <div
                                    class="border px-5 py-3 text-center hover:cursor-pointer"
                                    :class="{
                                        'pending_seats': pendingSeatList.includes(seat[2]),
                                        'selected_seats': selectedSeatsList.includes(seat[2]),
                                        'booked_seats': bookedSeatsList.includes(seat[2])
                                    }"
                                    @click="handleSelectedSeats(seat[2])"
                                >
                                    @{{ seat[2] }}
                                </div>

                                <div
                                    class="border px-5 py-3 text-center hover:cursor-pointer"
                                    :class="{
                                        'pending_seats': pendingSeatList.includes(seat[3]),
                                        'selected_seats': selectedSeatsList.includes(seat[3]),
                                        'booked_seats': bookedSeatsList.includes(seat[3])
                                    }"
                                    @click="handleSelectedSeats(seat[3])"
                                >
                                    @{{ seat[3] }}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-around">
                            <div
                                class="border px-5 py-3 text-center hover:cursor-pointer"
                                :class="{
                                    'pending_seats': pendingSeatList.includes('C1'),
                                    'selected_seats': selectedSeatsList.includes('C1'),
                                    'booked_seats': bookedSeatsList.includes('C1')
                                }"
                                @click="handleSelectedSeats('C1')"
                            >
                                C1
                            </div>

                            <div
                                class="border px-5 py-3 text-center hover:cursor-pointer"
                                :class="{
                                    'pending_seats': pendingSeatList.includes('C2'),
                                    'selected_seats': selectedSeatsList.includes('C2'),
                                    'booked_seats': bookedSeatsList.includes('C2')
                                }"
                                @click="handleSelectedSeats('C2')"
                            >
                                C2
                            </div>

                            <div
                                class="border px-5 py-3 text-center hover:cursor-pointer"
                                :class="{
                                    'pending_seats': pendingSeatList.includes('C3'),
                                    'selected_seats': selectedSeatsList.includes('C3'),
                                    'booked_seats': bookedSeatsList.includes('C3')
                                }"
                                @click="handleSelectedSeats('C3')"
                            >
                                C3
                            </div>

                            <div
                                class="border px-5 py-3 text-center hover:cursor-pointer"
                                :class="{
                                    'pending_seats': pendingSeatList.includes('C4'),
                                    'selected_seats': selectedSeatsList.includes('C4'),
                                    'booked_seats': bookedSeatsList.includes('C4')
                                }"
                                @click="handleSelectedSeats('C4')"
                            >
                                C4
                            </div>
                        </div>

                        <div
                            class="mt-10 text-center"
                            v-if="selectedSeatsList.length !== 0"
                        >
                            <div class="font-xl font-semibold">Seats Selected:</div>
                            @{{ selectedSeatsList.join(', ') }}
                        </div>
                    </div>

                    <x-primary-button
                        class="mt-5"
                        @click="handleBookings"
                    >
                        Confirm Booking
                    </x-primary-button>
                </div>

                <template v-if="bookingInfo">
                    <div
                        class="mt-14 border-t p-4"
                        id="booking_section"
                    >
                        <x-page-header>Booking Information</x-page-header>

                        <div class="mt-2 grid grid-cols-3 gap-y-5">
                            <div>
                                <div>Seats Booked</div>
                                <div class="font-semibold">
                                    @{{ selectedSeatsList.join(', ') }}
                                </div>
                            </div>

                            <div>
                                <div>Seat Per Price</div>
                                <div class="font-semibold">Rs. @{{ bookingInfo.seat_per_price }}</div>
                            </div>

                            <div>
                                <div>Total Amount</div>
                                <div class="font-semibold">Rs. @{{ bookingInfo.total_amount }}</div>
                            </div>

                            <div>
                                <div>VAT (13%)</div>
                                <div class="font-semibold">Rs. @{{ bookingInfo.vat }}</div>
                            </div>

                            <div>
                                <div>Grand Total:</div>
                                <div class="font-semibold">Rs. @{{ bookingInfo.grand_total }}</div>
                            </div>
                        </div>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('customer.confirm_payment') }}"
                    >
                        @csrf
                        <input
                            name="departure_id"
                            type="hidden"
                            :value="departureInfo.id"
                        >
                        <input
                            name="total_tickets"
                            type="hidden"
                            :value="selectedSeatsList.length"
                        >
                        <input
                            name="seats_booked"
                            type="hidden"
                            :value="selectedSeatsList"
                        >

                        <x-primary-button class="mt-10">Pay Now</x-primary-button>
                    </form>
                </template>
            </template>
        @else
            <x-alert variant="info">
                {!! $kyc_information['message'] !!}
            </x-alert>
        @endif
    </x-card>

    <script src="{{ asset('vue.js') }}"></script>
    <script src="{{ asset('booking.js') }}"></script>
</x-app-layout>
